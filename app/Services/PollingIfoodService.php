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
use App\Models\CustomizacaoOpcional;
use App\Models\CustomizacaoOpcionalItem;
use App\Models\Lancamento;
use App\Models\ParcelaLancamento;
use App\Models\Movimentacao;
use App\Services\IfoodService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Entrega;
use App\Http\Controllers\SaldoController;

class PollingIfoodService
{

    private function cadastrarPedido($pedidoPolling, $order_id){

        //Usuário logado
        $usuario_id = Auth::user()->id;
        
        //Loja conectada
        $loja_id = session('lojaConectado')['id'];

        /*----------------------------
        CADASTRANDO PEDIDO
        ----------------------------*/
        $pedido = new Pedido();
        $pedido->status = 0;
        $pedido->tipo = $pedidoPolling['orderType'];
        $pedido->feito_em = Carbon::parse($pedidoPolling['createdAt'])->setTimezone('America/Cuiaba')->toDateTimeString();
        $pedido->is_simulacao = $pedidoPolling['isTest'] == true ? true : false;   
        $pedido->loja_id = $loja_id;
        $pedido->orderIdIfood = $order_id;
        $pedido->via_ifood = true;

        //Pagamentos
        foreach($pedidoPolling['payments']['methods'] as $methods){
            $pedido->total = $methods['value'];
            $pedido->is_pagamento_entrega = $methods['type'] == "ONLINE" ? false : true;
            $pedido->situacao = $methods['type'] == "ONLINE" ? 2 : 0;

            //Identificar forma de pagamento
            if($methods['method'] == "CASH"){
                $pedido->forma_pagamento_id = 1;
            }else if($methods['method'] == "DEBIT"){
                $pedido->forma_pagamento_id = 2;
            }else if($methods['method'] == "CREDIT"){
                $pedido->forma_pagamento_id = 3;
            }else if($methods['method'] == "PIX"){
                $pedido->forma_pagamento_id = 4;
            }else if($methods['method'] == "MEAL_VOUCHER" || $methods['method'] == "FOOD_VOUCHER"){
                $pedido->forma_pagamento_id = 5;
            }
        }
        
        $pedido->taxa_ifood = $pedidoPolling['total']['additionalFees'];

        //Cliente
        $pedido->nome_cliente = $pedidoPolling['customer']['name'];
        $pedido->observacao = 'Número cliente (iFood): '.$pedidoPolling['customer']['phone']['number'].'. Localizador: '.$pedidoPolling['customer']['phone']['localizer'];

        //Salvando pedido
        $pedido->save();

        /*----------------------------
        CADASTRANDO DE ENTREGA DO PEDIDO
        ----------------------------*/
        //TODO: Delivery by Merchant
        if($pedido->tipo == "DELIVERY"){
            Entrega::create([
                'pedido_id' => $pedido->id,
                'cep' => $pedidoPolling['delivery']['deliveryAddress']['postalCode'],
                'rua' => $pedidoPolling['delivery']['deliveryAddress']['streetName'],
                'bairro' => $pedidoPolling['delivery']['deliveryAddress']['neighborhood'],
                'cidade' => $pedidoPolling['delivery']['deliveryAddress']['city'],
                'estado' => $pedidoPolling['delivery']['deliveryAddress']['state'],
                'numero' => $pedidoPolling['delivery']['deliveryAddress']['streetNumber'],
                'complemento' => $pedidoPolling['delivery']['deliveryAddress']['complement'],
                'taxa_entrega' => $pedidoPolling['total']['deliveryFee'],
            ]);
        
        }


        /*----------------------------
        CADASTRANDO ITEMS DO PEDIDO
        ----------------------------*/
        foreach($pedidoPolling['items'] as $item){

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
                    
                    $categoria = CategoriaProduto::create([
                        'nome' => 'CATEGORIA CRIADA AUTOMATICAMENTE',
                        'descricao' =>  'Categoria criada por Foomy pois produto não foi importado via iFood',
                        'ordem' => null,
                        'loja_id' =>  $loja_id,
                        'cadastrado_usuario_id' => $usuario_id,
                    ]);  

                }         

                $produto = Produto::create([
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
                ]);

            }

            $item_pedido = ItemPedido::create([
                'pedido_id' => $pedido->id,
                'produto_id' => $produto->id,
                'quantidade' => $qtd_produto,
                'preco_unitario' => $item['unitPrice'],
                'subtotal' => $item['totalPrice'],
                'observacao' => $item['observations'],
            ]);

            //Se existir opcionais
            if(!empty($item['options'])){

                foreach($item['options'] as $item_opcional){

                    //Buscando opcional
                    $opcional_ifood_id = $item_opcional['id'];
                    $qtd_opcional = $item_opcional['quantity'];

                    //Verificando se opcional existe
                    $opcional_produto = OpcionalProduto::where('productIdIfood', $opcional_ifood_id)->first();

                    //Se não houver opcional cadastrado
                    if($opcional_produto == null){

                        //Buscar categoria de Opcional
                        $categoria_opcional = CategoriaOpcional::where('nome', $item_opcional['groupName'])->first();

                        //Cadastrando categoria automatica para produtos iFood não importados
                        if($categoria_opcional == null){
                        
                            //Cadastrando categoria opcional
                            $categoria_opcional = CategoriaOpcional::create([
                                'nome' => $item_opcional['groupName'],
                                'limite' => 1,
                                'produto_id' => $produto->id,
                                'cadastrado_usuario_id' => $usuario_id,
                                'is_required' => false,
                            ]);
                  
                        }     
                        
                        //Cadastro de opcional
                        $opcional_produto = OpcionalProduto::create([
                            'nome' => $item_opcional['name'],
                            'categoria_opcional_id' => $categoria_opcional->id,
                            'cadastrado_usuario_id' => $usuario_id,
                            'productIdIfood' => $item_opcional['id'],
                            'preco' => $item_opcional['unitPrice'],
                        ]);

                    }
    
                    //Salvando Opcional Item
                    $opcional_item_pedido = OpcionalItem::create([
                        'item_pedido_id' => $item_pedido->id,
                        'opcional_produto_id' => $opcional_produto->id,
                        'quantidade' => $qtd_opcional,
                        'preco_unitario' => $item_opcional['unitPrice'],
                        'subtotal' => $item_opcional['price'],
                    ]);

                    //Customização Opcional
                    if(!empty($item_opcional['customizations'])){

                        foreach($item_opcional['customizations'] as $customizacao){

                            //Buscando customizacao
                            $customizacao_ifood_id = $customizacao['id'];
                            $qtd_customizacao = $customizacao['quantity'];

                            //Verificando se customizacao existe
                            $customizacaoOpcional = CustomizacaoOpcional::where('productIdIfood', $customizacao_ifood_id)->first();

                            //Se não houver customizacao opcional cadastrado
                            if($customizacaoOpcional == null){

                                //Cadastro de opcional
                                $customizacaoOpcional = CustomizacaoOpcional::create([
                                    'nome' => $customizacao['name'],
                                    'opcional_produto_id' => $opcional_produto->id,
                                    'cadastrado_usuario_id' => $usuario_id,
                                    'productIdIfood' => $customizacao['id'],
                                    'preco' => $customizacao['unitPrice'],
                                ]);

                            }
            
                            //Salvando Customizacao Opcional Item
                            $customizacao_opcional_item = CustomizacaoOpcionalItem::create([
                                'opcional_item_id' => $opcional_item_pedido->id,
                                'customizacao_opcional_id' => $customizacaoOpcional->id,
                                'quantidade' =>  $qtd_customizacao,
                                'preco_unitario' => $customizacao['unitPrice'],
                                'subtotal' => $customizacao['price'],
                            ]);

                        }
                    } 

                }
            } 
        }

        /*----------------------------
        CADASTRANDO FINANCEIRO
        ----------------------------*/

        //Cadastrando lancamento
        $lancamento = Lancamento::create([
            'loja_id' => $loja_id,
            'tipo' => 1,
            'cliente_id' => 1, //cliente genérico
            'fornecedor_id' => null,
            'categoria_financeiro_id' => 1, //categoria de Pedido
            'quantidade_parcela' => 1,
            'data_vencimento' => $pedido->feito_em,
            'valor_parcela' => $pedido->total,
            'valor_entrada' => null,
            'descricao' => 'Pedido via iFood',
            'cadastrado_usuario_id' => Auth::guard()->user()->id,
        ]);
    
        //Cadastrando parcelas
        $parcela = ParcelaLancamento::create([
            'lancamento_id' => $lancamento->id,
            'numero_parcela' => 1,
            'situacao' => $pedido->situacao == 2 ? 1 : 0,
            'valor' => $pedido->total,
            'cadastrado_usuario_id' => Auth::guard()->user()->id,
            'data_vencimento' => $pedido->feito_em,
            'valor_pago' => $pedido->situacao == 2 ? $pedido->total : null,
            'data_baixa' => $pedido->situacao == 2 ? Carbon::now()->format('Y-m-d H:i:s') : null,
            'baixado_usuario_id' => $pedido->situacao == 2 ? Auth::guard()->user()->id : null,
        ]);

        //Se houver pagamento efetuado
        if($pedido->situacao == 2){

            //Instaciando SaldoController para salvar Saldo
            $saldoController = new SaldoController();

            //Cadastrando Saldo
            $saldoController->store($pedido->total, $pedido->feito_em, $pedido->forma_pagamento->conta_corrente->id, 1);

            //Criando movimentação
            Movimentacao::create([
                'data_movimentacao' => $pedido->feito_em,
                'loja_id' => $loja_id,
                'tipo' => 1,
                'valor' => $pedido->total,
                'cadastrado_usuario_id' => Auth::guard()->user()->id,
                'parcela_lancamento_id' => $parcela->id,
                'conta_corrente_id' => $pedido->forma_pagamento->conta_corrente->id,
            ]);

        }

        //Salvar Pedido novamente com Lancamento ID
        $pedido->lancamento_id = $lancamento->id;
        $pedido->save();
    }

    public function polling($polling){

        //instancindo IfoodService
        $ifoodService = new IfoodService();


        /*----------------------------
        ------------------------------
        SALVANDO POLLING
        ------------------------------
        ----------------------------*/
        foreach($polling as $evento){

            //Evento polling ID
            $eventoId = $evento['id']; 
      
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

                    //Salvando Pedido e suas dependências
                    $this->cadastrarPedido($pedidoPolling, $order_id);
                   
                }
            }

            //Acknowledgment do polling
            $ifoodService->postAcknowledgment($eventoId);
        }
    }
}