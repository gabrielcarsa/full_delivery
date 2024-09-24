<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
use App\Models\CategoriaProduto;
use App\Models\Loja;

class CategoriaProdutoController extends Controller
{
    //LISTAGEM
    public function index(){

        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar as categorias e produtos');
        }

        //Sessão do loja que está conectado
        $lojaIdConectado = session('lojaConectado')['id'];

        $categorias = CategoriaProduto::where('loja_id', $lojaIdConectado)
        ->with('loja', 'produto')
        ->orderBy('ordem')
        ->get();

        return view('categoria_produto/listar', compact('categorias'));
    }

    //RETORNAR VIEW PARA CADASTRO
    public function create(Request $request){

        $lojas = Loja::all();

        return view('categoria_produto/novo', compact('lojas'));
    }

    //CADASTRAR
    public function store(Request $request, $usuario_id){
        
        //validação dos campos
        $validator = Validator::make($request->all(), [
            //TODO: fazer validações
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:100',
        ]);

        //Cadastro de categoria
        $categoria = new CategoriaProduto();
        $categoria->nome = $request->input('nome');
        $categoria->descricao = $request->input('descricao');
        $categoria->ordem = $request->input('ordem');
        $categoria->loja_id = $request->input('loja_id');
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
        //validação dos campos
        $validator = Validator::make($request->all(), [
            //TODO: fazer validações
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:100',
        ]);

         //alterando categoria
         $categoria = CategoriaProduto::find($id);
         $categoria->nome = $request->input('nome');
         $categoria->descricao = $request->input('descricao');
         $categoria->ordem = $request->input('ordem');
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

    public function indexJSON(Request $request){

        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar as categorias e produtos');
        }

        //Sessão do loja que está conectado
        $loja_id = session('lojaConectado')['id'];

        // Termo de busca, se existir
        $pesquisa = $request->input('pesquisa');

        // Busca por categorias e produtos da loja selecionada, filtrando se houver um termo de busca
        $categoria_produto = CategoriaProduto::where('loja_id', $loja_id)
        ->whereHas('produto', function($query) use ($pesquisa) {
            if ($pesquisa) {
                // Filtra produtos cujo nome contenha o termo de busca
                $query->where('nome', 'like', '%' . $pesquisa . '%');
            }
        })
        ->with(['produto' => function($query) use ($pesquisa) {
            if ($pesquisa) {
                // Filtra produtos cujo nome contenha o termo de busca
                $query->where('nome', 'like', '%' . $pesquisa . '%');
            }
        }])
        ->orderBy('ordem')
        ->get();

        return response()->json($categoria_produto);
    }
}