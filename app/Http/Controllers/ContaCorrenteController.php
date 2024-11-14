<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContaCorrente;
use Illuminate\Support\Facades\Auth;

class ContaCorrenteController extends Controller
{
    //LISTAR CONTAS
    public function index(){

        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar as categorias e produtos');
        }

        //Sessão do loja que está conectado
        $lojaIdConectado = session('lojaConectado')['id'];

        $contas_corrente = ContaCorrente::where('loja_id', $lojaIdConectado)
        ->with('loja', 'usuarioCadastrador')
        ->get();

        return view('conta_corrente/listar', compact('contas_corrente'));
    }

    //VIEW PARA CADASTRAR CONTA CORRENTE
    public function create(){
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar as categorias e produtos');
        }
        return view('conta_corrente/novo');
    }

    //CADASTRAR CONTA CORRENTE
    public function store(Request $request){

        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para cadastrar uma conta corrente');
        }

        //Sessão do loja que está conectado
        $lojaIdConectado = session('lojaConectado')['id'];

        //Validação formulário
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'banco' => 'required|string|max:50',
        ]);

        ContaCorrente::create([
            'nome' => $request->input('nome'),
            'banco' => $request->input('banco'),
            'agencia' => $request->input('agencia'),
            'numero_conta' => $request->input('numero_conta'),
            'loja_id' => $lojaIdConectado,
            'cadastrado_usuario_id' => Auth::guard()->user()->id,
        ]);

        return redirect()->route('conta_corrente.listar')->with('success', 'Cadastro feito com sucesso!');
    }
}
