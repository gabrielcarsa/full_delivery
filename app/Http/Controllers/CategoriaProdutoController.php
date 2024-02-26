<?php

namespace App\Http\Controllers;
use App\Models\CategoriaProduto;

use Illuminate\Http\Request;

class CategoriaProdutoController extends Controller
{
    //LISTAGEM
    public function listar(){
        $categorias = CategoriaProduto::all();
        return view('categoria_produto/listar', compact('categorias'));
    }

    //CADASTRAR
    public function cadastrar(Request $request){

    }

    //ALTERAR VIEW

    //ALTERAR

    //EXCLUIR
}
