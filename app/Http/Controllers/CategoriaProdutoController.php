<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CategoriaProduto;

class CategoriaProdutoController extends Controller
{
    //LISTAGEM
    public function listar(){
        $categorias = CategoriaProduto::all();
        return view('categoria_produto/listar', compact('categorias'));
    }

    //CADASTRAR
    public function cadastrar(Request $request, $usuario_id){

        //TODO: fazer validações

        //Cadastro de categoria
        $categoria = new CategoriaProduto();
        $categoria->nome = $request->input('nome');
        $categoria->descricao = $request->input('descricao');
        $categoria->ordem = $request->input('ordem');
        $categoria->cadastrado_usuario_id = $usuario_id;
        $categoria->save();

        return redirect()->back()->with('success', 'Cadastro feito com sucesso');

    }

    //ALTERAR VIEW

    //ALTERAR

    //EXCLUIR
}
