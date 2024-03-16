<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CategoriaProduto;
use App\Models\Restaurante;

class CategoriaProdutoController extends Controller
{
    //LISTAGEM
    public function index(){
        $categorias = CategoriaProduto::orderBy('ordem')->get();
        return view('categoria_produto/listar', compact('categorias'));
    }

    //CADASTRAR
    public function store(Request $request, $usuario_id){

        //TODO: fazer validações

        //Cadastro de categoria
        $categoria = new CategoriaProduto();
        $categoria->nome = $request->input('nome');
        $categoria->descricao = $request->input('descricao');
        $categoria->ordem = $request->input('ordem');
        $categoria->restaurante_id = $request->input('restaurante_id');
        $categoria->cadastrado_usuario_id = $usuario_id;
        $categoria->save();

        return redirect()->back()->with('success', 'Cadastro feito com sucesso');

    }

    //ALTERAR VIEW
    public function edit(Request $request){
        $id = $request->input('id');
        $categoria = CategoriaProduto::find($id);
        return view('categoria_produto/novo', compact('categoria'));
    }

    //ALTERAR
    public function update(Request $request, $usuario_id, $id){

         //alterando categoria
         $categoria = CategoriaProduto::find($id);
         $categoria->nome = $request->input('nome');
         $categoria->descricao = $request->input('descricao');
         $categoria->ordem = $request->input('ordem');
         $categoria->restaurante_id = $request->input('restaurante_id');
         $categoria->alterado_usuario_id = $usuario_id;
         $categoria->save();
 
         return redirect()->back()->with('success', 'Alteração feita com sucesso');
    }

    //EXCLUIR
    public function destroy($id){
        $produto = CategoriaProduto::find($id);
        $produto->delete();
        return redirect()->back()->with('success', 'Categoria excluida com sucesso');
    }
}
