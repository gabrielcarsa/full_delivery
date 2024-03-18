<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaProduto;
use App\Models\Restaurante;
use App\Models\HorarioFuncionamento;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;

class CardapioController extends Controller
{
    //
    public function index(Request $request){

        $restaurante_id = $request->get('restaurante_id');

        $cardapio_resultados = DB::table('produto as p')
        ->select(
            'p.id as id_produto',
            'p.nome as nome_produto',
            'p.descricao as descricao_produto',
            'p.imagem as imagem_produto',
            'p.preco as preco_produto',
            'p.categoria_id as categoria_id',
            'cp.nome as nome_categoria'
            )
        ->rightjoin('categoria_produto as cp', 'cp.id', '=', 'p.categoria_id')
        ->rightjoin('restaurante as r', 'r.id', '=', 'cp.restaurante_id')
        ->get();

        $categoria_cardapio = CategoriaProduto::orderBy('ordem')->get();
        
        if($restaurante_id != null){
            $restaurantes = Restaurante::find($restaurante_id)->first();
        }else{
            $restaurantes = Restaurante::all();
        }

        $horarios_funcionamento = HorarioFuncionamento::all();
        $data = [
            'cardapio_resultados' => $cardapio_resultados,
            'restaurantes' => $restaurantes,
            'horarios_funcionamento' => $horarios_funcionamento,
            'restaurante_id' => $restaurante_id,
            'categoria_cardapio' => $categoria_cardapio,
        ];

        return view('cardapio/cardapio', compact('data'));
    }

    public function carrinho(Request $request){
        
        $restaurante_id = $request->get('restaurante_id');

        return view('cardapio/carrinho')->with('restaurante_id', $restaurante_id);
    }

    public function produto(Request $request){
        $restaurante_id = $request->get('restaurante_id');
        $produto_id = $request->get('produto_id');
        
        $produto = DB::table('produto as p')
        ->select(
            'op.nome as nome_opcional',
            'op.descricao as descricao_opcional',
            'op.preco as preco_opcional',
            'p.*'
        )
        ->leftjoin('opcional_produto as op', 'op.produto_id', '=', 'p.id')
        ->where('p.id', $produto_id)
        ->get();

        return view('cardapio/produto', compact('produto'))->with('restaurante_id', $restaurante_id);
    }
}
