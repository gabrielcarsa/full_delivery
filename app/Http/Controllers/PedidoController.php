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
use App\Models\Mesa;
use App\Models\UsoCupom;
use App\Models\FormaPagamentoEntrega;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ClienteEndereco;
use Illuminate\Support\Facades\Session;
use App\Services\IfoodService;

class PedidoController extends Controller
{
    //-------------------------
    //PAINEL DE PEDIDOS INTERNO
    //-------------------------

    //EXIBIR PEDIDOS
    public function gestor(Request $request){
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar os pedidos');
        }

        //Dados do loja
        $id_loja  = session('lojaConectado')['id'];
        $loja = Loja::where('id', $id_loja)->first();

        //Query Pedidos
        $pedidos = Pedido::where('loja_id', $id_loja)
        ->with('loja', 'forma_pagamento_foomy', 'forma_pagamento_loja', 'item_pedido', 'cliente', 'entrega')
        ->orderBy('feito_em', 'DESC');

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
    
        return view('pedido/gestor_pedidos', compact('data'));    
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
        ->with('loja', 'forma_pagamento_foomy', 'forma_pagamento_loja', 'item_pedido', 'cliente', 'entrega')
        ->orderBy('feito_em', 'DESC')
        ->get();
        
        //Pedido
        $pedido = Pedido::where('id', $pedido_id)
        ->with('loja', 'forma_pagamento_foomy', 'forma_pagamento_loja', 'item_pedido', 'cliente', 'entrega', 'uso_cupom')
        ->orderBy('feito_em', 'ASC')
        ->first();
        
        $data = [
            'loja' => $loja,
            'pedido' => $pedido,
            'pedidos' => $pedidos,
        ];

        return view('pedido/gestor_pedidos', compact('data'));       
    }

    public function refresh_pedidos(Request $request){

        $id_loja = session('lojaConectado')['id'];

        $id_selecionado = $request->get('id_selecionado');

        $pedidos = Pedido::where('loja_id', $id_loja)
            ->with('loja', 'forma_pagamento_foomy', 'forma_pagamento_loja', 'item_pedido', 'cliente', 'entrega')
            ->orderBy('feito_em', 'DESC')
            ->get();

        return view('components.pedido-card-gestor', compact('pedidos', 'id_selecionado'));
    }

    //PEDIDOS IFOOD NO BANCO DE DADOS
    public function ifood_pedidos(){
        //instancindo IfoodService
        $ifoodService = new IfoodService();

        //Obter catálogos
        $polling = $ifoodService->getPollings();
        dd($polling);

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

        //Se for pedido pra consumo no local e ele estiver em preparo o próximo passo é ser concluído e não ir para a entrega
        if($pedido->consumo_local_viagem_delivery == 1 && $status_atual == 1){
            $pedido->status = $status_atual + 2;
        }else{
            $pedido->status++;
        }

        //Concluir pedido
        if($pedido->consumo_local_viagem_delivery == 3){
            if($pedido->status == 3 || $pedido->status == 4 || $pedido->status == 5 ){
                $pedido->situacao = 2;
            }
        }

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

    // ADICIONAR QTD PEDIDO
    public function adicionar_quantidade(Request $request){
        //IDs
        $item_pedido_id = $request->input('item_id');
        $pedido_id = $request->input('pedido_id');

        //Item Pedido
        $item_pedido = ItemPedido::find($item_pedido_id);
        $item_pedido->subtotal += $item_pedido->preco_unitario; 
        $item_pedido->quantidade += 1; 
        $item_pedido->save(); 

        //Pedido
        $pedido = Pedido::find($pedido_id);
        $pedido->total += $item_pedido->preco_unitario;
        $pedido->save(); 
        return redirect()->back();
    }

     // REMOVER QTD PEDIDO
     public function remover_quantidade(Request $request){
        //IDs
        $item_pedido_id = $request->input('item_id');
        $pedido_id = $request->input('pedido_id');

        //Item Pedido
        $item_pedido = ItemPedido::find($item_pedido_id);
        $item_pedido->subtotal -= $item_pedido->preco_unitario; 
        $item_pedido->quantidade -= 1; 
        $item_pedido->save(); 

        //Pedido
        $pedido = Pedido::find($pedido_id);
        $pedido->total -= $item_pedido->preco_unitario;
        $pedido->save(); 
        return redirect()->back();
    }

    // ADICIONAR ITEM
    public function adicionar_item(Request $request){
        //IDs
        $produto_id = $request->input('produto_id');
        $pedido_id = $request->input('pedido_id');

        //Produto
        $produto = Produto::find($produto_id);

        //Pedido
        $pedido = Pedido::find($pedido_id);
        $pedido->total = $pedido->total + $produto->preco;
        $pedido->save(); 

        $item_pedido = new ItemPedido();
        $item_pedido->pedido_id = $pedido->id;
        $item_pedido->produto_id = $produto_id; 
        $item_pedido->quantidade = 1;
        $item_pedido->preco_unitario = $produto->preco;; 
        $item_pedido->subtotal = $produto->preco;; 
        $item_pedido->observacao = "#".$pedido->id.$produto_id." adicionado por operador."; 
        $item_pedido->save();
        return redirect()->back();

    }

    // EXCLUIR ITEM
    public function deletar_item(Request $request){
        //IDs
        $item_pedido_id = $request->input('item_id');
        $pedido_id = $request->input('pedido_id');

        //Item Pedido
        $item_pedido = ItemPedido::find($item_pedido_id);

        //Pedido
        $pedido = Pedido::find($pedido_id);

        //Total pedido
        $total_pedido = $pedido->total;

        // Verifica e exclui opcionais associados ao item de pedido
        $opcionais = OpcionalItem::where('item_pedido_id', $item_pedido_id)->get();
        if ($opcionais->isNotEmpty()) {
            foreach ($opcionais as $opcional) {
                $total_pedido = $total_pedido - ($opcional->preco_unitario * $opcional->quantidade);

                $opcional->delete();
            }
        }

        $total_pedido = $total_pedido - ($item_pedido->preco_unitario * $item_pedido->quantidade);
        $pedido->total = $total_pedido;

        $pedido->save(); 
        $item_pedido->delete(); 

        return redirect()->back();
    }

    // PAGAMENTO DO PEDIDO MESA
    public function pagamento_mesa(Request $request){
        
        //Definindo data para cadastrar
        date_default_timezone_set('America/Cuiaba'); 
        
        $mesa_id = $request->input('mesa_id');
        $valorPagar = $request->input('valorPagar');
        $pedidoIds = json_decode($request->input('pedidos'));
        $total_geral = $request->input('total_geral');
        $taxa_servico = $request->input('taxa_servico');
        $sem_taxa_servico = $request->input('sem_taxa_servico');
        $valor_pago_parcial = $request->input('valor_pago_parcial');
        $itens_pedido_id = $request->input('item_pedido_id');

        //Convertendo em float para salvar BD
        $valorPagar = floatval(str_replace(',', '.', str_replace('.', '', $valorPagar)));

        //Valor em aberto
        $valorEmAberto = floatval($total_geral - $valor_pago_parcial);

        //Dados mesa
        $mesa = Mesa::find($mesa_id);

        // Verificar se mesa já pagou a taxa de serviço
        if($mesa->is_taxa_paga == true){
            //Se já pagou, pagamento será sem taxa
            $sem_taxa_servico = true;
        }
        
        // Recuperar os pedidos do banco de dados
        $pedidos = Pedido::whereIn('id', $pedidoIds)->get();

        // Definir epsilon (margem de erro para comparação de floats)
        $epsilon = 0.00001;


        // Se não for selecionado nenhum item
        if($itens_pedido_id != null){

            foreach($itens_pedido_id as $item_pedido_id){
                // Item Pedido
                $item_pedido = ItemPedido::find($item_pedido_id);
                $item_pedido->situacao = 1;
                $item_pedido->save();

            }

        }

        //Verificar sem ou com taxa de serviço
        if($sem_taxa_servico == true){

            //Verificar receber maior valor
            if (($valorPagar - $valorEmAberto) > $epsilon) {
                $valorPagoMaior = true;
                return redirect()->back()->withErrors(['valorPagoMaior' => 'Erro: Valor inserido é maior que o valor em aberto. Tente novamente!']);
            }

            //Verificar se foi pago valor todo devido
            if(abs($valorPagar - $valorEmAberto) < $epsilon){
                //Mesa livre
                $mesa->is_ocupada = false;
                $mesa->hora_abertura = null;
                $mesa->valor_pago_parcial = 0;
                $mesa->is_taxa_paga = false;
                $mesa->save();

                //Fechando pedido (s)
                foreach($pedidos as $pedido){
                    $pedido->fechado_em = Carbon::now()->format('Y-m-d H:i:s');
                    $pedido->situacao = 2;
                    $pedido->save();
                }

            }else{ //Pagamento parcial

                //Mesa valor pago parcial
                $mesa->valor_pago_parcial += $valorPagar;
                $mesa->save();

                //Fechando pedido (s)
                foreach($pedidos as $pedido){
                    $pedido->situacao = 1;
                    $pedido->save();
                }
            }

        }else{// Com taxa de serviço

            //Verificar receber maior valor
            if(($valorPagar - ($valorEmAberto + $taxa_servico)) > $epsilon){
                $valorPagoMaior = true;
                return redirect()->back()->withErrors(['valorPagoMaior' => 'Erro: Valor inserido é maior que o valor em aberto. Tente novamente!']);
            }

            //Verificar se foi pago valor todo devido
            if(abs($valorPagar - ($valorEmAberto + $taxa_servico)) < $epsilon){
                //Mesa livre
                $mesa->is_ocupada = false;
                $mesa->hora_abertura = null;
                $mesa->valor_pago_parcial = 0;
                $mesa->is_taxa_paga = false;
                $mesa->save();

                //Fechando pedido (s)
                foreach($pedidos as $pedido){
                    $pedido->fechado_em = Carbon::now()->format('Y-m-d H:i:s');
                    $pedido->situacao = 2;
                    $pedido->save();
                }

            }else{ //Pagamento parcial

                //Mesa valor pago parcial
                $mesa->valor_pago_parcial += ($valorPagar - $taxa_servico);
                $mesa->is_taxa_paga = true;
                $mesa->save();

                //Fechando pedido (s)
                foreach($pedidos as $pedido){
                    $pedido->situacao = 1;
                    $pedido->save();
                }
            }

        }
        

        return redirect()->back();

    }

    //-------------------------
    // PEDIDOS PARTE DO CLIENTE
    //-------------------------


    // MOSTRAR PEDIDOS DO CLIENTE
    public function indexPedidosCliente(Request $request){
        //Variaveis via GET
        $loja_id = $request->get('loja_id');
        $consumo_local_viagem_delivery = $request->get('consumo_local_viagem_delivery');
        $endereco_selecionado = $request->get('endereco_selecionado');

        $cliente_id = null;

        if( Auth::guard('cliente')->user()){
            $cliente_id = Auth::guard('cliente')->user()->id;

            $pedidos = Pedido::where('loja_id', $loja_id)
            ->with('loja', 'forma_pagamento_foomy', 'forma_pagamento_loja', 'item_pedido', 'cliente', 'entrega', 'mesa')
            ->orderBy('feito_em', 'DESC')
            ->where('cliente_id', $cliente_id)
            ->get();
        }else{

            //Cliente não logado pegar mesa
            $clienteNaoLogado = $request->session()->get('clienteNaoLogado');
            
            if($clienteNaoLogado != null){
                $pedidos = Pedido::where('loja_id', $loja_id)
                ->with('loja', 'forma_pagamento_foomy', 'forma_pagamento_loja', 'item_pedido', 'cliente', 'entrega', 'mesa')
                ->orderBy('feito_em', 'DESC')
                ->where('mesa_id', $clienteNaoLogado['mesa_id'])
                ->where('nome_cliente', $clienteNaoLogado['nome_cliente'])
                ->get();
            }else{
                $pedidos = collect();
            }
            
        }        

        $data = [
            'consumo_local_viagem_delivery' => $consumo_local_viagem_delivery,
            'loja_id' => $loja_id,
            'endereco_selecionado' => $endereco_selecionado,
        ];

        return view('cardapio/pedido', compact('data', 'pedidos'));
    }

    //CADASTRAR PEDIDOS WEB
    public function storeWeb(Request $request){
        //Definindo data para cadastrar
        date_default_timezone_set('America/Cuiaba'); 

        // Receber dados do formulário
        $carrinho = json_decode($request->input('carrinho'), true);
        $endereco_selecionado_id = $request->input('endereco_selecionado_id');
        $taxa_entrega = $request->input('taxa_entrega');
        $loja_id = $request->input('loja_id');
        $consumo_local_viagem_delivery = $request->input('consumo_local_viagem_delivery');
        $total_geral = $request->input('total');
        $distancia = $request->input('distancia');
        $nome_cliente = $request->input('nome_cliente');
        $mesa_id = $request->input('mesa_id');
        $tempo_preparo_min = 0;
        $tempo_preparo_max = 0;


        $cliente_id = null;

        //Se cliente estiver logado
        if( Auth::guard('cliente')->user()){
            $cliente_id = Auth::guard('cliente')->user()->id;
        }

        /*
        --- Validações ---
        */

        // Se endereço não for selecionado
        if($consumo_local_viagem_delivery == 3 && $endereco_selecionado_id == null){
            $enderecoVazio = true;
            return redirect()->back()->withErrors(['enderecoVazio' => 'Por favor, selecione um endereço.']);
        }

        //Se mesa ou nome cliente não foi selecionado
        if($consumo_local_viagem_delivery == 1 && !Auth::guard('cliente')->check()){
            $validator = Validator::make($request->all(), [
                'nome_cliente' => 'required|string|max:100',
                'mesa_id' => 'required|min:1',
            ]);

            // Se a validação falhar
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }elseif ($consumo_local_viagem_delivery == 1 && Auth::guard('cliente')->check()) {
            $validator = Validator::make($request->all(), [
                'mesa_id' => 'required|min:1',
            ]);

            // Se a validação falhar
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        
        //Verificar se foi selecionado forma de pagamento 
        if($consumo_local_viagem_delivery == 3){
            $validator = Validator::make($request->all(), [
                'forma_pagamento' => 'required',
            ]);
            // Se a validação falhar
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
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
                'consumo_local_viagem_delivery' => $consumo_local_viagem_delivery,
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
        $pedido->consumo_local_viagem_delivery = $consumo_local_viagem_delivery;//1. Local, 2. Viagem, 3. Delivery
        $pedido->feito_em = Carbon::now()->format('Y-m-d H:i:s');
        $pedido->is_simulacao = false;   
        $pedido->loja_id = $loja_id;
        $pedido->situacao = 0;
        $pedido->is_pagamento_entrega = true;
        $pedido->total = $total_geral;

        //Verificar cliente logado
        if (Auth::guard('cliente')->check()) {
            $pedido->cliente_id = $cliente_id;
        } else {
            $pedido->nome_cliente = $nome_cliente;

            //Para cliente não logado armazenar como sessão mesa e nome cliente para posteriormente exibir pedidos
            $clienteNaoLogado = [
                'mesa_id' => $mesa_id,
                'nome_cliente' => $nome_cliente,
            ];

            // Adicionando o cliente na sessão
            $request->session()->put('clienteNaoLogado', $clienteNaoLogado);
        }

        // Verificar local de consumo
        if($consumo_local_viagem_delivery == 1){ // Verificar comer local
            $pedido->mesa_id = $mesa_id;

            //Mudando status mesa
            $mesa = Mesa::find($mesa_id);
            if($mesa->is_ocupada == false){
                $mesa->is_ocupada = true;
                $mesa->hora_abertura = Carbon::now()->format('Y-m-d H:i:s');
                $mesa->save();
            }

        }elseif($consumo_local_viagem_delivery == 3){ //Verificar delivery
            $pedido->forma_pagamento_loja_id = $request->input('forma_pagamento');
        }

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

            //Definindo tempo de preparo por produto
            $produto_item = Produto::find($produto_id);
            $tempo_preparo_min += $produto_item->tempo_preparo_min_minutos;
            $tempo_preparo_max += $produto_item->tempo_preparo_max_minutos;

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

            $distancia_km = $distancia / 1000;
            $entrega->tempo_min = $tempo_preparo_min + (2 * $distancia_km);
            $entrega->tempo_max = $tempo_preparo_max + (5 * $distancia_km);
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

        // Apagando carrinho
        Session::forget('carrinho');

        return redirect()->route('pedido.pedidoCliente', ['loja_id' => $loja_id, 'consumo_local_viagem_delivery' => $consumo_local_viagem_delivery, 'endereco_selecionado' => $endereco_selecionado_id]);

    }

    //DETALHES DO PEDIDO WEB
    public function showWeb(Request $request){
        //Variaveis via GET
        $loja_id = $request->get('loja_id');
        $consumo_local_viagem_delivery = $request->get('consumo_local_viagem_delivery');
        $endereco_selecionado = $request->get('endereco_selecionado');

        //Dados pedido
        $pedido_id = $request->input('pedido_id');
        
        //Pedido
        $pedido = Pedido::where('id', $pedido_id)
        ->with('loja', 'forma_pagamento_loja', 'forma_pagamento_foomy', 'item_pedido', 'cliente', 'entrega', 'uso_cupom')
        ->orderBy('feito_em', 'ASC')
        ->first();
                
        $data = [
            'consumo_local_viagem_delivery' => $consumo_local_viagem_delivery,
            'loja_id' => $loja_id,
            'endereco_selecionado' => $endereco_selecionado,
            'pedido' => $pedido,
        ];

        return view('pedido/detalhes_pedido', compact('data'));       
    }

}