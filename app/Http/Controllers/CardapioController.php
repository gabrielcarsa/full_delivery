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

        $lojas = Loja::all();

        $categoria_produto = CategoriaProduto::where('loja_id', $loja_id)
        ->with('loja', 'produto')
        ->get();

        $horarios_funcionamento = HorarioFuncionamento::all();

        $data = [
            'categoria_produto' => $categoria_produto,
            'lojas' => $lojas,
            'horarios_funcionamento' => $horarios_funcionamento,
            'loja_id' => $loja_id,
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

        $produto = Produto::where('id', $produto_id)
        ->with('opcional_produto', 'categoria')
        ->first();

        $loja = Loja::find($loja_id);
        return view('cardapio/produto', compact('produto', 'loja'))->with('loja_id', $loja_id);
    }
}