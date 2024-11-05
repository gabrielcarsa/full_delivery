<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaFinanceiro;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CategoriaFinanceiroController extends Controller
{
    //INDEX
    public function index(){

        //Obtendo todas categorias a receber
        $categorias_pagar = CategoriaFinanceiro::where('tipo', 0)->get();

        //Obtendo todas categorias a pagar
        $categorias_receber = CategoriaFinanceiro::where('tipo', 1)->get();

        $categorias = [
            'categorias_receber' => $categorias_receber,
            'categorias_pagar' => $categorias_pagar,
        ];

        return view('categoria_financeiro.listar', compact('categorias'));
    }

    //STORE
    public function store(Request $request){

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|numeric|min:1',
            'nome' => 'required|string',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Contas a pagar(0) ou receber(1)
        $tipo = $request->input('tipo') == 2 ? 0 : 1;

        //Salvar no banco
        CategoriaFinanceiro::create([
            'tipo' => $tipo,
            'nome' => $request->input('nome'),
            'cadastrado_usuario_id' => Auth::guard()->user()->id,
        ]);

        return redirect()->back()->with('success', 'Cadastrado com sucesso');
    
    }

    //EDITAR NOME CATEGORIA
    public function edit(Request $request){

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $categoria_id = $request->input('id');
        $nome = $request->input('nome');

        $categoria = CategoriaFinanceiro::find($categoria_id);
        $categoria->nome = $nome;
        $categoria->alterado_usuario_id = Auth::guard()->user()->id;
        $categoria->save();

        return redirect()->back()->with('success', 'Nome alterado com sucesso');
    }
}
