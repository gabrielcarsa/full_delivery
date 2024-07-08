<?php

namespace App\Http\Controllers;
use App\Helpers\DistanciaEntregaHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Loja;
use App\Models\Produto;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Entrega;
use App\Models\ItemPedido;
use App\Models\OpcionalItem;
use App\Models\OpcionalProduto;
use App\Models\Cupom;
use App\Models\UsoCupom;
use App\Models\FormaPagamentoEntrega;
use Carbon\Carbon;

class PedidoController extends Controller
{
    //PAINEL DE PEDIDOS
    public function painel(){
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar os pedidos');
        }

        //Dados do loja
        $id_loja  = session('lojaConectado')['id'];
        $loja = Loja::where('id', $id_loja)->first();

        $pedidos = Pedido::where('loja_id', $id_loja)
        ->with('loja', 'forma_pagamento_entrega', 'item_pedido', 'cliente', 'entrega', 'meio_pagamento_entrega')
        ->orderBy('data_pedido', 'ASC')
        ->get();
        

        $data = [
            'loja' => $loja,
            'pedidos' => $pedidos,
        ];

        return view('pedido/painel_pedidos', compact('data'));    
    }

      //RETORNAR VIEW PARA CADASTRO
      public function create(Request $request){

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro');
        }

        $id_loja  = session('lojaConectado')['id'];
        $produtos = DB::table('produto AS p')
        ->select(
            'p.*',
        ) 
        ->join('categoria_produto AS cp', 'cp.id', '=', 'p.categoria_id')
        ->join('loja AS r', 'r.id', '=', 'cp.loja_id')
        ->where('r.id', $id_loja)
        ->orderBy('p.nome', 'ASC') 
        ->get();
        
        $clientes = Cliente::all();

        $forma_pagamento_entrega = FormaPagamentoEntrega::all();

        $data = [
            'produtos' => $produtos,
            'clientes' => $clientes,
            'forma_pagamento_entrega' => $forma_pagamento_entrega,

        ];

        return view('pedido/novo_simulador', compact('data'));
    }

    //CADASTRAR
    public function store(Request $request){
        //Definindo data para cadastrar
        date_default_timezone_set('America/Cuiaba');   

        /*
        --- Validação do formulário ---
        */
        
        $validator = Validator::make($request->all(), [
            //todo
        ]);
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro');
        }

        $id_loja  = session('lojaConectado')['id'];
        $loja = Loja::where('id', $id_loja)->first();

        //Total pedido
        $total_geral = 0;

        /*
        --- Calcular Entrega ---
        */

        // Variáveis para calcular distância
        $origem = $loja->cep;
        $destino = $request->input('cep'); 
        $apiKey = 'AIzaSyCrR7RmCs0UkChkfbOJSoOUQ7kf9i-gcsk';

        // Obtendo a distância em metros
        $distancia = DistanciaEntregaHelper::getDistance($origem, $destino, $apiKey);


        /*
        --- Cadastro de pedido ---
        */

        $pedido = new Pedido();
        $pedido->status = 0;
        $pedido->consumo_local_viagem_delivery = $request->input('entrega');//1. Local, 2. Viagem, 3. Delivery
        $pedido->observacao = $request->input('observacao');
        $pedido->data_pedido = Carbon::now()->format('Y-m-d H:i:s');
        $pedido->is_simulacao = true;
        $pedido->cliente_id = $request->input('cliente_id');
        $pedido->loja_id = $id_loja;
        $pedido->is_pagamento_entrega = true;
        $pedido->forma_pagamento_entrega_id = $request->input('forma_pagamento_entrega_id');
        $pedido->save();


        /*
        --- Cadastro de item do pedido ---
        */

        //Buscando produto
        $produto_id = $request->input('produto_id');
        $produto = Produto::where('id', $produto_id)->first();
        $qtd_produto = $request->input('quantidade');

        $item_pedido = new ItemPedido();
        $item_pedido->pedido_id = $pedido->id;
        $item_pedido->produto_id = $produto->id; 
        $item_pedido->quantidade = $qtd_produto;
        $item_pedido->preco_unitario = $produto->preco; 
        $item_pedido->subtotal = $produto->preco * $qtd_produto; 
        $item_pedido->save();

        //Total pedido
        $total_geral += $item_pedido->subtotal;

        if($request->input('opcional_produto_id') != 0){
            //Buscando opcional
            $opcional_id = $request->input('opcional_produto_id');
            $opcional = OpcionalProduto::where('id', $opcional_id)->first();
            $qtd_opcional = $request->input('quantidade_opcional');

            $opcional_item_pedido = new OpcionalItem();
            $opcional_item_pedido->item_pedido_id = $item_pedido->id;
            $opcional_item_pedido->opcional_produto_id = $request->input('opcional_produto_id');
            $opcional_item_pedido->quantidade = $qtd_opcional;
            $opcional_item_pedido->preco_unitario = $opcional->preco; 
            $opcional_item_pedido->subtotal = $opcional->preco * $qtd_opcional; 
            $opcional_item_pedido->save();

            //Total pedido
            $total_geral += $opcional_item_pedido->subtotal;
        } 

        /*
        --- Cadastro de entrega ---
        */

        if($pedido->consumo_local_viagem_delivery == 3){

            $entrega = new Entrega();
            $entrega->pedido_id = $pedido->id;
            $entrega->cep = $request->input('cep');
            $entrega->rua = $request->input('rua');
            $entrega->bairro = $request->input('bairro');
            $entrega->cidade = $request->input('cidade');
            $entrega->estado = $request->input('estado');
            $entrega->numero = $request->input('numero');
            $entrega->complemento = $request->input('complemento'); 
            $entrega->distancia_metros = $distancia; 
       
            // Taxa de entrega gratuita
            if($loja->is_taxa_entrega_free == true){
                $entrega->taxa_entrega = 0;

            // Taxa de entrega calculada por km
            }elseif($loja->taxa_por_km_entrega != null){
    
                // Verificar se deu certo a requisição
                if ($distancia !== false) {

                    // se distancia for maior que 1 km
                    if($distancia >= 1000){
                        $distancia_km = $distancia / 1000;
                        $entrega->taxa_entrega = $distancia_km * $loja->taxa_por_km_entrega;

                    }else{
                        $entrega->taxa_entrega = $loja->taxa_por_km_entrega;
                    
                    }

                }else{
                    return redirect('loja')->with('error', 'Erro ao calcular distância');
                }
    
            // Taxa de entrega fixa
            }elseif($loja->taxa_entrega_fixa != null){
                $entrega->taxa_entrega = $loja->taxa_entrega_fixa;
            }

            $entrega->save();

            //Total pedido
            $total_geral += $entrega->taxa_entrega;

        }

        /*
        --- Verificando Cupom ---
        */

        $cupom = Cupom::where('codigo', $request->input('cupom'))->first();
        if($cupom && $cupom->is_ativo == true){

            if($cupom->tipo_desconto == 1){//valor fixo
                //Total pedido
                $total_geral -= $cupom->desconto;
            }elseif($cupom->tipo_desconto == 2){
                $valor_desconto = ($total_geral * $cupom->desconto)/100;
                //Total pedido
                $total_geral -= $valor_desconto;
            }

            $uso_cupom = new UsoCupom();
            $uso_cupom->pedido_id = $pedido->id;
            $uso_cupom->cliente_id = $request->input('cliente_id');
            $uso_cupom->cupom_id = $cupom->id;
            $uso_cupom->data_uso = Carbon::now()->format('Y-m-d H:i:s');
            $uso_cupom->save();

            $uso_cupom_atual = $cupom->usos;
            $cupom->usos = $uso_cupom_atual++;
            $cupom->save();
            $pedido->total_sem_desconto = $pedido->total;
        }

        $pedido->total = $total_geral;
        $pedido->save();

        return redirect()->route('pedido.painel')->with('success', 'Cadastro feito com sucesso');

    }

    //PAINEL DE PEDIDOS
    public function show(Request $request){
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar pedidos');
        }

        //Dados do loja
        $id_loja  = session('lojaConectado')['id'];
        $loja = Loja::where('id', $id_loja)->first();

        //Dados pedido
        $pedido_id = $request->input('id');

        //Pedidos
        $pedidos = Pedido::where('loja_id', $id_loja)
        ->with('loja', 'forma_pagamento_entrega', 'item_pedido', 'cliente', 'entrega', 'meio_pagamento_entrega')
        ->orderBy('data_pedido', 'ASC')
        ->get();
        
        //Pedido
        $pedido = Pedido::where('id', $pedido_id)
        ->with('loja', 'forma_pagamento_entrega', 'item_pedido', 'cliente', 'entrega', 'meio_pagamento_entrega', 'uso_cupom')
        ->orderBy('data_pedido', 'ASC')
        ->first();
        
        $data = [
            'loja' => $loja,
            'pedido' => $pedido,
            'pedidos' => $pedidos,
        ];

        return view('pedido/painel_pedidos', compact('data'));       
    }

    // ATUALIZAR STATUS PEDIDO
    public function update_status(Request $request){
         //Verificar se há loja selecionado
         if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro');
        }

        //Dados do loja
        $id_loja  = session('lojaConectado')['id'];
        $loja = Loja::where('id', $id_loja)->first();

        //Dados pedido
        $pedido_id = $request->input('id');
        
        //Pedido
        $pedido = Pedido::find($pedido_id);
        
        $status_atual = $pedido->status;

        $pedido->status = $status_atual + 1;
        $pedido->save();
        return redirect()->back()->with('success', 'Status atualizado com sucesso');

    }

    // REJEITAR PEDIDO
    public function rejeitar(Request $request){
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro');
        }

        //Dados do loja
        $id_loja  = session('lojaConectado')['id'];
        $loja = Loja::where('id', $id_loja)->first();

        //Dados pedido
        $pedido_id = $request->input('id');
        
        //Pedido
        $pedido = Pedido::find($pedido_id);
        $pedido->status = 4;
        $pedido->mensagem_cancelamento_rejeicao = $request->input('motivo');
        $pedido->save();
        return redirect()->back()->with('error', 'Pedido rejeitado');

    }

    // REJEITAR PEDIDO
    public function cancelar(Request $request){
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro');
        }

        //Dados do loja
        $id_loja  = session('lojaConectado')['id'];
        $loja = Loja::where('id', $id_loja)->first();

        //Dados pedido
        $pedido_id = $request->input('id');
        
        //Pedido
        $pedido = Pedido::find($pedido_id);
        $pedido->status = 5;
        $pedido->mensagem_cancelamento_rejeicao = $request->input('motivo');
        $pedido->save();
        return redirect()->back()->with('error', 'Pedido cancelado');

    }
}