<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContaCorrente;
use App\Models\Saldo;
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
            'agencia' => 'nullable|string|max:50',
            'numero_conta' => 'nullable|string|max:50',
            'saldo' => 'required|string|max:50',
        ]);

        $request->merge([
            'saldo' => str_replace(['.', ','], ['', '.'], $request->input('saldo')),
        ]);

        $conta_corrente = ContaCorrente::create([
            'nome' => $request->input('nome'),
            'banco' => $request->input('banco'),
            'agencia' => $request->input('agencia'),
            'numero_conta' => $request->input('numero_conta'),
            'loja_id' => $lojaIdConectado,
            'cadastrado_usuario_id' => Auth::guard()->user()->id,
        ]);

        Saldo::create([
            'saldo' => $request->input('saldo'),
            'conta_corrente_id' => $conta_corrente->id,
            'data' => now()->toDateString(),
        ]);

        return redirect()->route('conta_corrente.listar')->with('success', 'Cadastro feito com sucesso!');
    }

    //VIEW PARA CADASTRAR CONTA CORRENTE
    public function edit(Request $request){
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar as categorias e produtos');
        }

        //ID
        $conta_corrente_id = $request->input('id');

        //Conta Corrente Selecionada
        $conta_corrente = ContaCorrente::find($conta_corrente_id);

        return view('conta_corrente/novo', compact('conta_corrente'));
    }

    //ALTERAR CONTA CORRENTE
    public function update(Request $request){

        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para cadastrar uma conta corrente');
        }

        //Sessão do loja que está conectado
        $lojaIdConectado = session('lojaConectado')['id'];

        //Validação formulário
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'banco' => 'required|string|max:50',
            'agencia' => 'nullable|string|max:50',
            'numero_conta' => 'nullable|string|max:50',
        ]);

        //ID
        $conta_corrente_id = $request->input('id');

        //Conta Corrente Selecionada
        $conta_corrente = ContaCorrente::find($conta_corrente_id);
        $conta_corrente->nome = $request->input('nome');
        $conta_corrente->banco = $request->input('banco');
        $conta_corrente->agencia = $request->input('agencia');
        $conta_corrente->numero_conta = $request->input('numero_conta');
        $conta_corrente->alterado_usuario_id =  Auth::guard()->user()->id;
        $conta_corrente->save();

        return redirect()->route('conta_corrente.listar')->with('success', 'Alteração feita com sucesso!');
    }

    //EXCLUIR
    public function destroy(Request $request){
        
        //ID
        $id = $request->input('id');

        $conta_corrente = ContaCorrente::find($id);
        $conta_corrente->delete();
        return redirect()->back()->with('success', 'Conta excluída com sucesso');
    }
}
