<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaProduto;
use App\Models\Restaurante;
use App\Models\HorarioFuncionamento;
use Illuminate\Support\Facades\DB;

class CardapioController extends Controller
{
    //
    public function index(Request $request){

        $restaurante_id = $request->get('restaurante_id');

        $cardapio_resultados = DB::table('produto as p')
        ->select(
            'p.nome as nome_produto',
            'p.descricao as descricao_produto',
            'p.imagem as imagem_produto',
            'p.preco as preco_produto',
            'cp.nome as nome_categoria'
            )
        ->rightjoin('categoria_produto as cp', 'cp.id', '=', 'p.categoria_id')
        ->get();

        $categoria_cardapio = CategoriaProduto::all();
        
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

        return view('cardapio', compact('data'));
    }
}
