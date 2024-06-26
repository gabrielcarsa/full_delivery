<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Produto;
use App\Models\OpcionalProduto;

class OpcionalProdutoController extends Controller
{
    //LISTAR    
    public function index(Request $request){

        $produto_id = $request->input('produto_id');

        $produto = Produto::find($produto_id);

        $opcionais = OpcionalProduto::where('produto_id', $produto_id)->get();

        return view('opcional_produto/listar', compact('produto', 'opcionais'));
    }
    
    //RETORNAR VIEW PARA CADASTRO
    public function create(Request $request){

        $produto_id = $request->input('produto_id');

        $produto = Produto::find($produto_id);

        return view('opcional_produto/novo', compact('produto'));
    }

    //CADASTRAR
    public function store(Request $request, $produto_id, $usuario_id){

        $request->merge([
            'preco' => str_replace(['.', ','], ['', '.'], $request->input('preco')),
        ]);

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:200',
            'preco' => 'required|numeric',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Cadastro de opcional
        $opcional = new OpcionalProduto();
        $opcional->nome = $request->input('nome');
        $opcional->descricao = $request->input('descricao');

        $opcional->preco = (double) $request->input('preco'); // Converter a string diretamente para um número em ponto flutuante

        $opcional->produto_id = $produto_id;
        $opcional->cadastrado_usuario_id = $usuario_id;
        $opcional->save();

        return redirect()->back()->with('success', 'Cadastro de opcional feito com sucesso');

    }

    //ALTERAR VIEW
    public function edit(Request $request){
        $id = $request->input('id');
        $opcional = OpcionalProduto::find($id);
        return view('opcional_produto/novo', compact('opcional'));
    }


    //ALTERAR
    public function update(Request $request, $usuario_id, $id){
        
        $request->merge([
            'preco' => str_replace(['.', ','], ['', '.'], $request->input('preco')),
        ]);

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:200',
            'preco' => 'required|numeric',
        ]);

        //Alterando opcional
        $opcional = OpcionalProduto::find($id);
        $opcional->nome = $request->input('nome');
        $opcional->descricao = $request->input('descricao');

        $opcional->preco = (double) $request->input('preco'); // Converter a string diretamente para um número em ponto flutuante

        $opcional->alterado_usuario_id = $usuario_id;

        $opcional->save();
        return redirect()->back()->with('success', 'Alteração feita com sucesso');
    }

    //EXCLUIR
    public function destroy($id){
        $opcional = OpcionalProduto::find($id);
      
        $opcional->delete();
        return redirect()->back()->with('success', 'Opcional excluido com sucesso');
    }

    //RETORNA UM JSON COM A CONTA CORRENTE ESPECÍFICA
    function opcionais($produto_id){
        $opcionais = OpcionalProduto::where('produto_id',$produto_id)->get();
        return response()->json($opcionais);
    }

}