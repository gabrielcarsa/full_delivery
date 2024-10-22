<?php

namespace App\Services;
use App\Models\Loja;
use App\Models\CategoriaProduto;
use App\Models\Produto;
use App\Models\CategoriaOpcional;
use App\Models\OpcionalProduto;
use App\Models\Pedido;
use App\Models\ItemPedido;
use App\Models\OpcionalItem;
use App\Services\CardapioService;
use App\Services\IfoodService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Entrega;

class PollingIfoodService
{
    public function polling($polling){

        //Usuário logado
        $usuario_id = Auth::user()->id;

        //instancindo IfoodService
        $ifoodService = new IfoodService();

        //Loja conectada
        $loja_id = session('lojaConectado')['id'];

        //Salvando polling
        foreach($polling as $evento){
      
            //Tipo de grupo do evento
            if($evento['code'] == "PLC"){
                
                //Armazenando pedido ID
                $order_id = $evento['orderId'];

                //Verificar se já não existe o ID
                $order = Pedido::where('orderIdIfood', $order_id)->first();

                //Se não existir order
                if($order == null){
                    
                    //Obtendo detalhes do pedido
                    $pedidoPolling = $ifoodService->getOrder($order_id);

                    //Salvar pedido
                    $pedido = new Pedido();
                    $pedido->status = 0;
                    $pedido->consumo_local_viagem_delivery = $pedidoPolling['orderType'] == 'DELIVERY' ? 3 : 2;//1. Local, 2. Viagem, 3. Delivery
                    $pedido->feito_em = Carbon::parse($pedidoPolling['createdAt'])->toDateTimeString();
                    $pedido->is_simulacao = $pedidoPolling['isTest'] == true ? true : false;   
                    $pedido->loja_id = $loja_id;
                    $pedido->orderIdIfood = $order_id;
                    $pedido->via_ifood = true;

                    //Pagamentos
                    foreach($pedidoPolling['payments']['methods'] as $methods){
                        $pedido->total = $methods['value'];
                        $pedido->is_pagamento_entrega = $methods['type'] == "ONLINE" ? false : true;
                        $pedido->situacao = $methods['type'] == "ONLINE" ? 2 : 0;
                    }
                    $pedido->taxa_ifood = $pedidoPolling['total']['additionalFees'];

                    //Cliente
                    $pedido->nome_cliente = $pedidoPolling['customer']['name'];
                    $pedido->observacao = 'Número cliente (iFood): '.$pedidoPolling['customer']['phone']['number'].'. Localizador: '.$pedidoPolling['customer']['phone']['localizer'];

                    //Salvando pedido
                    $pedido->save();

                    /*
                    --- Cadastro de entrega ---
                    */

                    //TODO: Delivery by Merchant
                    if($pedido->consumo_local_viagem_delivery == 3){
                        $entrega = new Entrega();
                        $entrega->pedido_id = $pedido->id;
                        $entrega->cep = $pedidoPolling['delivery']['deliveryAddress']['postalCode'];
                        $entrega->rua = $pedidoPolling['delivery']['deliveryAddress']['streetName'];
                        $entrega->bairro = $pedidoPolling['delivery']['deliveryAddress']['neighborhood'];
                        $entrega->cidade = $pedidoPolling['delivery']['deliveryAddress']['city'];
                        $entrega->estado = $pedidoPolling['delivery']['deliveryAddress']['state'];
                        $entrega->numero = $pedidoPolling['delivery']['deliveryAddress']['streetNumber'];
                        $entrega->complemento = $pedidoPolling['delivery']['deliveryAddress']['complement'];
                        $entrega->taxa_entrega = $pedidoPolling['total']['deliveryFee'];
                        $entrega->save();
                    }
            
            
                    /*
                    --- Cadastro de item do pedido ---
                    */
                    foreach($pedidoPolling['items'] as $item){

                        //instanciando CardapioService
                        $cardapioService = new CardapioService();

                        //Buscando produto
                        $produto_ifood_id = $item['id'];
                        $qtd_produto = $item['quantity'];

                        //Verificando se produto existe
                        $produto = Produto::where('productIdIfood', $produto_ifood_id)->first();
                
                        //Se não houver produto cadastrado
                        if($produto == null){

                            //Buscar categoria
                            $categoria = CategoriaProduto::where('nome', 'CATEGORIA CRIADA AUTOMATICAMENTE')->first();

                            //Cadastrando categoria automatica para produtos iFood não importados
                            if($categoria == null){
                                
                                $categoria_aux = [
                                    'nome' => 'CATEGORIA CRIADA AUTOMATICAMENTE',
                                    'descricao' =>  'Categoria criada por Foomy pois produto não foi importado via iFood',
                                    'ordem' => null,
                                    'loja_id' =>  $loja_id,
                                    'cadastrado_usuario_id' => $usuario_id,
                                ];  

                                $categoria = $cardapioService->storeCategoria($categoria_aux);
                            }         
    
                            $produto_aux = [
                                'nome' => $item['name'],
                                'descricao' => 'Produto cadastrado automaticamente via Foomy - Gestor de Pedidos. Produto não importado do iFood anteriormente.',
                                'disponibilidade' => false,
                                'tempo_preparo_min_minutos' => 5,
                                'tempo_preparo_max_minutos' => 10,
                                'preco' => $item['unitPrice'],
                                'categoria_produto_id' => $categoria->id,
                                'cadastrado_usuario_id' => $usuario_id,
                                'productIdIfood' => $item['id'],
                                'imagemIfood' => $item['imageUrl'],
                                'quantidade_pessoa' => 1,
                            ];

                            $produto = $cardapioService->storeProduto($produto_aux);

                        }
            
                        $item_pedido = new ItemPedido();
                        $item_pedido->pedido_id = $pedido->id;
                        $item_pedido->produto_id = $produto->id; 
                        $item_pedido->quantidade = $qtd_produto;
                        $item_pedido->preco_unitario = $item['unitPrice']; 
                        $item_pedido->subtotal = $item['totalPrice']; 
                        $item_pedido->observacao = $item['observations']; 
                        $item_pedido->save();

            
                        //Se existir opcionais
                        if($item['options'] != null){
                            
                            foreach($item['options'] as $item_opcional){

                                //Buscando opcional
                                $opcional_ifood_id = $item_opcional['id'];
                                $qtd_opcional = $item_opcional['quantity'];

                                //Verificando se produto existe
                                $opcional_produto = OpcionalProduto::where('productIdIfood', $opcional_ifood_id)->first();

                                //Se não houver opcional cadastrado
                                if($opcional_produto == null){

                                    //Buscar categoria de Opcional
                                    $categoria_opcional = CategoriaOpcional::where('nome', $item_opcional['groupName'])->first();

                                    //Cadastrando categoria automatica para produtos iFood não importados
                                    if($categoria_opcional == null){
                                    
                                        //Cadastrando categoria opcional
                                        $categoria_opcional = new CategoriaOpcional();
                                        $categoria_opcional->nome = $item_opcional['groupName'];
                                        $categoria_opcional->limite = 1;
                                        $categoria_opcional->produto_id = $produto->id;
                                        $categoria_opcional->cadastrado_usuario_id = $usuario_id;
                                        $categoria_opcional->is_required = false;
                                        $categoria_opcional->save();
                                    }     
                                    
                                    //Cadastro de opcional
                                    $opcional_produto = new OpcionalProduto();
                                    $opcional_produto->nome = $item_opcional['name'];
                                    $opcional_produto->categoria_opcional_id = $categoria_opcional->id;
                                    $opcional_produto->cadastrado_usuario_id = $usuario_id;
                                    $opcional_produto->productIdIfood = $item_opcional['id'];
                                    $opcional_produto->preco = $item_opcional['unitPrice'];
                                    $opcional_produto->save();
                                }
                
                                //Salvando Opcional Item
                                $opcional_item_pedido = new OpcionalItem();
                                $opcional_item_pedido->item_pedido_id = $item_pedido->id;
                                $opcional_item_pedido->opcional_produto_id = $opcional_produto->id;
                                $opcional_item_pedido->quantidade = $qtd_opcional;
                                $opcional_item_pedido->preco_unitario = $item_opcional['unitPrice']; 
                                $opcional_item_pedido->subtotal = $item_opcional['price']; 
                                $opcional_item_pedido->save();
            
                            }
                        } 
            
                    }
                }

            }
        }
    }
}