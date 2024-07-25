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
        $categorias_opcionais = CategoriaOpcional::where('produto_id', $produto_id)->get();

        // array dos opcionais
        $opcionais = [];

        // Colocando todos opcionais em uma array só
        foreach ($categorias_opcionais as $categoria_opcional) {
            $opcionais = array_merge($opcionais, OpcionalProduto::where('categoria_opcional_id', $categoria_opcional->id)->get()->toArray());
        }

        return view('categoria_opcional/listar', compact('produto', 'categorias_opcionais'));
    }
}
