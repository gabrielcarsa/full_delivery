<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaProduto;
use App\Models\Loja;
use App\Models\HorarioFuncionamento;
use App\Models\Produto;
use App\Models\OpcionalProduto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CardapioController extends Controller
{
    //
    public function index(Request $request){

        $loja_id = $request->get('loja_id');

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
        ->rightjoin('loja as r', 'r.id', '=', 'cp.loja_id')
        ->get();

        $categoria_cardapio = CategoriaProduto::orderBy('ordem')->get();
        
        if($loja_id != null){
            $lojas = Loja::find($loja_id)->first();
        }else{
            $lojas = Loja::all();
        }

        $horarios_funcionamento = HorarioFuncionamento::all();

        $data = [
            'cardapio_resultados' => $cardapio_resultados,
            'lojas' => $lojas,
            'horarios_funcionamento' => $horarios_funcionamento,
            'loja_id' => $loja_id,
            'categoria_cardapio' => $categoria_cardapio,
        ];

        $carrinho = session()->get('carrinho', []);

        return view('cardapio/cardapio', compact('data', 'carrinho'));
    }

    public function indexCarrinho(Request $request){
        
        $loja_id = $request->get('loja_id');

        $carrinho = session()->get('carrinho', []);

        return view('cardapio/carrinho', compact('carrinho'))->with('loja_id', $loja_id);
    }

    public function storeCarrinho(Request $request, $produto_id){
        $observacao = $request->input('observacao');
        $opcional_id = $request->input('opcionais');
        $loja_id = $request->get('loja_id');

        $produto = Produto::find($produto_id);

        $opcionais = OpcionalProduto::find($opcional_id);

        $itensCarrinho = [
            'opcionais' => $opcionais,
            'observacao' => $observacao,
            'produto' => $produto,
        ];

        // Adicionando o item ao carrinho na sessão
        $request->session()->push('carrinho', $itensCarrinho);

        return redirect()->action([CardapioController::class, 'index'], ['loja_id' => $loja_id]);
    }

    public function destroyCarrinho(){
        Session::forget('carrinho');

        return redirect()->back();
    }

    public function showProduto(Request $request){
        $loja_id = $request->get('loja_id');
        $produto_id = $request->get('produto_id');
        
        $produto = DB::table('produto as p')
        ->select(
            'op.id as id_opcional',
            'op.nome as nome_opcional',
            'op.descricao as descricao_opcional',
            'op.preco as preco_opcional',
            'p.*'
        )
        ->leftjoin('opcional_produto as op', 'op.produto_id', '=', 'p.id')
        ->where('p.id', $produto_id)
        ->get();

        return view('cardapio/produto', compact('produto'))->with('loja_id', $loja_id);
    }
}
