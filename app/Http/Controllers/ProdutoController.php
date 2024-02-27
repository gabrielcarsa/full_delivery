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

        $produtos = Produto::where('categoria_id', $categoria_id)->get();

        return view('produto/listar', compact('produtos', 'categoria'));
    }

    //RETORNAR VIEW PARA CADASTRO
    public function novo(Request $request){

        $categoria_id = $request->input('categoria_id');

        $categoria = CategoriaProduto::find($categoria_id)->first();

        return view('produto/novo', compact('categoria'));
    }

    //CADASTRAR
    public function cadastrar(Request $request, $categoria_id, $usuario_id){

        //TODO: fazer validações

        //Cadastro de categoria
        $produto = new Produto();
        $produto->nome = $request->input('nome');
        $produto->descricao = $request->input('descricao');
        $produto->disponibilidade = $request->input('disponibilidade');
        $produto->preco = $request->input('preco');
        $produto->categoria_id = $categoria_id;
        $produto->cadastrado_usuario_id = $usuario_id;
        if ($request->hasFile('imagem')) {
            //Colocando nome único no arquivo
            $imagemNome = $request->file('imagem')->getClientOriginalName();
            $imagemNome = pathinfo($imagemNome, PATHINFO_FILENAME);
            $nomeArquivo = $imagemNome . '_' . time() . '.' . $request->file('imagem')->getClientOriginalExtension();

            $request->file('imagem')->storeAs('public/imagens_produtos', $nomeArquivo);
            $produto->imagem = $nomeArquivo;
        }
        $produto->save();

        return redirect()->back()->with('success', 'Cadastro feito com sucesso');

    }

    //ALTERAR VIEW

    //ALTERAR

    //EXCLUIR
}
