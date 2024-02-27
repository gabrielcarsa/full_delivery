<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produto;
use App\Models\CategoriaProduto;


class ProdutoController extends Controller
{
     //LISTAGEM
     public function listar(Request $request){

        $categoria_id = $request->input('categoria_id');

        $categoria = CategoriaProduto::find($categoria_id)->first();

        $produtos = Produto::where('categoria_id', $categoria_id);

        return view('produto/listar', compact('produtos', 'categoria'));
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
