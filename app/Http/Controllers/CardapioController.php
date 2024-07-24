<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaProduto;
use App\Models\Loja;
use App\Models\HorarioFuncionamento;
use App\Models\Produto;
use App\Models\OpcionalProduto;
use App\Models\ClienteEndereco;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DistanciaEntregaHelper;

class CardapioController extends Controller
{
    // CARDAPIO
    public function index(Request $request){

        //Variaveis via GET
        $loja_id = $request->get('loja_id');
        $consumo_local_viagem = $request->get('consumo_local_viagem');
        $endereco_selecionado = $request->get('endereco_selecionado');

        //Declarando variaveis zeradas
        $categoria_produto = null;
        $lojas = null;
        $horarios_funcionamento = null;

        //Verifivar se há uma loja selecionada
        if($loja_id == null){
            //Buscar todas as lojas
            $lojas = Loja::all();

            //Se mudar loja zerar o carrinho
            Session::forget('carrinho');

        } else{
            //Categorias e produtos da loja selecionada
            $categoria_produto = CategoriaProduto::where('loja_id', $loja_id)
            ->with('loja', 'produto')
            ->get();

            $horarios_funcionamento = HorarioFuncionamento::all();
        }

        $cliente_enderecos = null;

        //Enderecos Clientes
        if( Auth::guard('cliente')->user()){
            $cliente_id = Auth::guard('cliente')->user()->id;
            $cliente_enderecos = ClienteEndereco::where('cliente_id', $cliente_id)->get();
        }

        
        // Array para passar variaveis
        $data = [
            'categoria_produto' => $categoria_produto,
            'lojas' => $lojas,
            'horarios_funcionamento' => $horarios_funcionamento,
            'loja_id' => $loja_id,
            'consumo_local_viagem' => $consumo_local_viagem,
            'endereco_selecionado' => $endereco_selecionado,
            'cliente_enderecos' => $cliente_enderecos,
        ];

        //Carrinho
        $carrinho = session()->get('carrinho', []);

        return view('cardapio/cardapio', compact('data', 'carrinho'));
    }

    // CARRINHO
    public function indexCarrinho(Request $request){
        
        //Variaveis via GET
        $loja_id = $request->get('loja_id');
        $consumo_local_viagem = $request->get('consumo_local_viagem');
        $endereco_selecionado = $request->get('endereco_selecionado');

        //Carrinho
        $carrinho = session()->get('carrinho', []);

        $taxa_entrega = null;

        /*
        --- Calcular Entrega ---
        */
        if($endereco_selecionado != null){

            $loja = Loja::find($loja_id);
            $cliente_endereco = ClienteEndereco::find($endereco_selecionado);

            // Variáveis para calcular distância
            $origem = $loja->cep;
            $destino = $cliente_endereco->cep; 
            $apiKey = 'AIzaSyCrR7RmCs0UkChkfbOJSoOUQ7kf9i-gcsk';

            // Obtendo a distância em metros
            $distancia = DistanciaEntregaHelper::getDistance($origem, $destino, $apiKey);

            // Taxa de entrega gratuita
            if($loja->is_taxa_entrega_free == true){
                $taxa_entrega = 0;

            // Taxa de entrega calculada por km
            }elseif($loja->taxa_por_km_entrega != null){

                // Verificar se deu certo a requisição
                if ($distancia !== false) {

                    // se distancia for maior que 1 km
                    if($distancia >= 1000){
                        $distancia_km = $distancia / 1000;
                        $taxa_entrega = $distancia_km * $loja->taxa_por_km_entrega;

                    }else{
                        $taxa_entrega = $loja->taxa_por_km_entrega;
                    
                    }

                }else{
                    $taxa_entrega = 'Erro: favor contate o suporte';
                }

            // Taxa de entrega fixa
            }elseif($loja->taxa_entrega_fixa != null){
                $taxa_entrega = $loja->taxa_entrega_fixa;
            }
        }

        // Array para passar variaveis
        $data = [
            'consumo_local_viagem' => $consumo_local_viagem,
            'loja_id' => $loja_id,
            'taxa_entrega' => $taxa_entrega,
        ];

        return view('cardapio/carrinho', compact('carrinho', 'data'));
    }

    // ADICIONAR AO CARRINHO
    public function storeCarrinho(Request $request, $produto_id){
        //Variaveis via GET
        $loja_id = $request->get('loja_id');
        $consumo_local_viagem = $request->get('consumo_local_viagem');
        $endereco_selecionado = $request->get('endereco_selecionado');
        $observacao = $request->input('observacao');
        $opcional_id = $request->input('opcionais');

        //Produto
        $produto = Produto::find($produto_id);
        //Opcional
        $opcionais = OpcionalProduto::find($opcional_id);

        //Itens do carrinho
        $itensCarrinho = [
            'opcionais' => $opcionais,
            'observacao' => $observacao,
            'produto' => $produto,
        ];

        // Adicionando o item ao carrinho na sessão
        $request->session()->push('carrinho', $itensCarrinho);

        //Redirecionando com rota laravel
        return redirect()->action([CardapioController::class, 'index'], ['loja_id' => $loja_id, 'consumo_local_viagem' => $consumo_local_viagem, 'endereco_selecionado' => $endereco_selecionado]);
    }

    // APAGAR CARRINHO
    public function destroyCarrinho(){
        Session::forget('carrinho');

        return redirect()->back();
    }

    //EXIBIR PRODUTO
    public function showProduto(Request $request){
        //Variaveis via GET
        $loja_id = $request->get('loja_id');
        $consumo_local_viagem = $request->get('consumo_local_viagem');
        $endereco_selecionado = $request->get('endereco_selecionado');
        $produto_id = $request->get('produto_id');

        //Produto
        $produto = Produto::where('id', $produto_id)
        ->with('opcional_produto', 'categoria')
        ->first();

        // Array para passar variaveis
        $data = [
            'consumo_local_viagem' => $consumo_local_viagem,
            'loja_id' => $loja_id,
            'endereco_selecionado' => $endereco_selecionado,
        ];

        $loja = Loja::find($loja_id);
        
        return view('cardapio/produto', compact('produto', 'data'))->with('loja', $loja);
    }

}