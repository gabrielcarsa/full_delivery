<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Produto;
use App\Models\OpcionalProduto;
use App\Models\CategoriaOpcional;

class CategoriaOpcionalController extends Controller
{
    //LISTAR    
    public function index(Request $request){

        // Definindo ID do produto
        $produto_id = $request->input('produto_id');

        // Procurando o produto
        $produto = Produto::find($produto_id);

        // Definindo todas as categorias de opcionais do produto 
        $categorias_opcionais = CategoriaOpcional::where('produto_id', $produto_id)
        ->with('opcional_produto')
        ->get();

        // array dos opcionais
        $opcionais = [];

        // Colocando todos opcionais em uma array só
        foreach ($categorias_opcionais as $categoria_opcional) {
            $opcionais = array_merge($opcionais, OpcionalProduto::where('categoria_opcional_id', $categoria_opcional->id)->get()->toArray());
        }

        return view('categoria_opcional/listar', compact('produto', 'categorias_opcionais'));
    }

     //RETORNAR VIEW PARA CADASTRO
     public function create(Request $request){

        $produto_id = $request->input('produto_id');

        $produto = Produto::find($produto_id);

        return view('categoria_opcional/novo', compact('produto'));
    }

    //CADASTRAR
    public function store(Request $request, $produto_id, $usuario_id){

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:50',
            'limite' => 'required|numeric|min:1',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Cadastro de opcional
        $categoria_opcional = new CategoriaOpcional();
        $categoria_opcional->nome = $request->input('nome');
        $categoria_opcional->limite = $request->input('limite');
        $categoria_opcional->produto_id = $produto_id;
        $categoria_opcional->cadastrado_usuario_id = $usuario_id;
        if($request->input('preenchimentoObrigatorio') == 0){
            $categoria_opcional->is_required = false;
        }else{
            $categoria_opcional->is_required = true;
        }
        $categoria_opcional->save();

        return redirect()->back()->with('success', 'Cadastro de categoria de opcional feito com sucesso');

    }

    //EXCLUIR
    public function destroy($id){
        $categoria_opcional = CategoriaOpcional::find($id);
        $categoria_opcional->delete();
        return redirect()->back()->with('success', 'Categoria Opcional excluido com sucesso');
    }
}
