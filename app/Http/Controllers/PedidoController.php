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
use Illuminate\Support\Facades\Auth;
use App\Models\ClienteEndereco;

class PedidoController extends Controller
{
    //-------------------------
    //PAINEL DE PEDIDOS INTERNO
    //-------------------------

    //EXIBIR PEDIDOS
    public function painel(Request $request){
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar os pedidos');
        }

        //Dados do loja
        $id_loja  = session('lojaConectado')['id'];
        $loja = Loja::where('id', $id_loja)->first();

        //Query Pedidos
        $pedidos = Pedido::where('loja_id', $id_loja)
        ->with('loja', 'forma_pagamento_entrega', 'item_pedido', 'cliente', 'entrega', 'meio_pagamento_entrega')
        ->orderBy('data_pedido', 'DESC');

        //Filtros
        $filtro = $request->input('filtro');

        // Verificando filtro e apĺicando
        if($filtro != null){
            $pedidos->where('status', $filtro);
        }

        //Executa a query
        $pedidos = $pedidos->get();
        
        $data = [
            'loja' => $loja,
            'pedidos' => $pedidos,
        ];

        return view('pedido/painel_pedidos', compact('data'));    
    }

    //EXIBIR PEDIDO
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
        ->orderBy('data_pedido', 'DESC')
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

    // CANCELAR PEDIDO
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

    //-------------------------
    // PEDIDOS PARTE DO CLIENTE
    //-------------------------


    // MOSTRAR PEDIDOS DO CLIENTE
    public function indexPedidosCliente(Request $request){
        //Variaveis via GET
        $loja_id = $request->get('loja_id');
        $consumo_local_viagem = $request->get('consumo_local_viagem');
        $endereco_selecionado = $request->get('endereco_selecionado');

        $cliente_id = null;

        if( Auth::guard('cliente')->user()){
            $cliente_id = Auth::guard('cliente')->user()->id;
        }

        $pedidos = Pedido::where('loja_id', $loja_id)
        ->with('loja', 'forma_pagamento_entrega', 'item_pedido', 'cliente', 'entrega', 'meio_pagamento_entrega')
        ->orderBy('data_pedido', 'DESC')
        ->where('cliente_id', $cliente_id)
        ->get();
        

        $data = [
            'consumo_local_viagem' => $consumo_local_viagem,
            'loja_id' => $loja_id,
            'endereco_selecionado' => $endereco_selecionado,
        ];

        return view('cardapio/pedido', compact('data', 'pedidos'));
    }

    //CADASTRAR PEDIDOS WEB
    public function storeWeb(Request $request){

        dd($request->input('forma_pagamento'));
        //Definindo data para cadastrar
        date_default_timezone_set('America/Cuiaba'); 

        // Receber dados do formulário
        $carrinho = json_decode($request->input('carrinho'), true);
        $endereco_selecionado_id = $request->input('endereco_selecionado_id');
        $taxa_entrega = $request->input('taxa_entrega');
        $loja_id = $request->input('loja_id');
        $consumo_local_viagem = $request->input('consumo_local_viagem');
        $total_geral = $request->input('total');
        $distancia = $request->input('distancia');

        $cliente_id = null;
        if( Auth::guard('cliente')->user()){
            $cliente_id = Auth::guard('cliente')->user()->id;
        }

        /*
        --- Validações ---
        */

        // Se endereço não for selecionado
        if($endereco_selecionado_id == null){
            $enderecoVazio = true;
            return redirect()->back()->withErrors(['enderecoVazio' => 'Por favor, selecione um endereço.']);
        }
        
        $validator = Validator::make($request->all(), [
            //todo
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Query da Loja selecionada
        $loja = Loja::where('id', $loja_id)->first();

        //Verificar se há loja selecionado
        if($loja == null){
            return redirect()->back()->with('error', 'Selecione um loja primeiro');
        }

        //Verificar se loja está aberta
        if($loja->is_open != true){
            $data = [
                'consumo_local_viagem' => $consumo_local_viagem,
                'loja_id' => $loja_id,
                'endereco_selecionado' => $endereco_selecionado_id,
            ];
            return view('errors-pages/loja-fechada-error',  compact('data'));
        }

        /*
        --- Cadastro de pedido ---
        */

        $pedido = new Pedido();
        $pedido->status = 0;
        $pedido->consumo_local_viagem_delivery = $consumo_local_viagem;//1. Local, 2. Viagem, 3. Delivery
        $pedido->data_pedido = Carbon::now()->format('Y-m-d H:i:s');
        $pedido->is_simulacao = false;
        $pedido->cliente_id = $cliente_id;
        $pedido->loja_id = $loja_id;
        $pedido->is_pagamento_entrega = true;
        $pedido->forma_pagamento_entrega_id = 1;
        $pedido->total = $total_geral;
        $pedido->save();


        /*
        --- Cadastro de item do pedido ---
        */
        foreach($carrinho as $item_carrinho){
            //Buscando produto
            $produto_id = $item_carrinho['produto']['id'];
            $qtd_produto = $item_carrinho['quantidade'];

            $item_pedido = new ItemPedido();
            $item_pedido->pedido_id = $pedido->id;
            $item_pedido->produto_id = $produto_id; 
            $item_pedido->quantidade = $qtd_produto;
            $item_pedido->preco_unitario = $item_carrinho['produto']['preco']; 
            $item_pedido->subtotal = $item_carrinho['produto']['preco'] * $qtd_produto; 
            $item_pedido->observacao = $item_carrinho['observacao']; 
            $item_pedido->save();

            if($item_carrinho['opcionais'] != null){
                
                foreach($item_carrinho['opcionais'] as $item_opcional){
                //Buscando opcional
                $opcional_id = $item_opcional['id'];
                $qtd_opcional = 1;

                $opcional_item_pedido = new OpcionalItem();
                $opcional_item_pedido->item_pedido_id = $item_pedido->id;
                $opcional_item_pedido->opcional_produto_id = $opcional_id;
                $opcional_item_pedido->quantidade = $qtd_opcional;
                $opcional_item_pedido->preco_unitario = $item_opcional['preco']; 
                $opcional_item_pedido->subtotal = $item_opcional['preco'] * $qtd_opcional; 
                $opcional_item_pedido->save();

                }
            } 

        }

       
        /*
        --- Cadastro de entrega ---
        */

        if($pedido->consumo_local_viagem_delivery == 3){
            $cliente_endereco = ClienteEndereco::find($endereco_selecionado_id);
            $entrega = new Entrega();
            $entrega->pedido_id = $pedido->id;
            $entrega->cep = $cliente_endereco->cep;
            $entrega->rua = $cliente_endereco->rua;
            $entrega->bairro = $cliente_endereco->bairro;
            $entrega->cidade = $cliente_endereco->cidade;
            $entrega->estado = $cliente_endereco->estado;
            $entrega->numero = $cliente_endereco->numero;
            $entrega->complemento = $cliente_endereco->complemento;
            $entrega->distancia_metros = $distancia; 
            $entrega->taxa_entrega = $taxa_entrega;
            $entrega->save();
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
            $pedido->total = $total_geral;
            $pedido->save();
        }

        return redirect()->route('pedido.pedidoCliente', ['loja_id' => $loja_id, 'consumo_local_viagem' => $consumo_local_viagem, 'endereco_selecionado' => $endereco_selecionado_id]);

    }

    //DETALHES DO PEDIDO WEB
    public function showWeb(Request $request){
        //Variaveis via GET
        $loja_id = $request->get('loja_id');
        $consumo_local_viagem = $request->get('consumo_local_viagem');
        $endereco_selecionado = $request->get('endereco_selecionado');

        //Dados pedido
        $pedido_id = $request->input('pedido_id');
        
        //Pedido
        $pedido = Pedido::where('id', $pedido_id)
        ->with('loja', 'forma_pagamento_entrega', 'item_pedido', 'cliente', 'entrega', 'meio_pagamento_entrega', 'uso_cupom')
        ->orderBy('data_pedido', 'ASC')
        ->first();
                
        $data = [
            'consumo_local_viagem' => $consumo_local_viagem,
            'loja_id' => $loja_id,
            'endereco_selecionado' => $endereco_selecionado,
            'pedido' => $pedido,
        ];

        return view('pedido/detalhes_pedido', compact('data'));       
    }
}