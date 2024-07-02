<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Restaurante;
use App\Models\Produto;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Entrega;
use App\Models\ItemPedido;
use App\Models\OpcionalItem;
use App\Models\OpcionalProduto;
use App\Models\FormaPagamentoEntrega;
use Carbon\Carbon;

class PedidoController extends Controller
{
    //PAINEL DE PEDIDOS
    public function painel(){
        //Verificar se há restaurante selecionado
        if(!session('restauranteConectado')){
            return redirect('restaurante')->with('error', 'Selecione um restaurante primeiro para visualizar os pedidos');
        }

        //Dados do restaurante
        $id_restaurante  = session('restauranteConectado')['id'];
        $restaurante = Restaurante::where('id', $id_restaurante)->first();

        $pedidos = Pedido::where('restaurante_id', $id_restaurante)
        ->with('restaurante', 'forma_pagamento_entrega', 'item_pedido', 'cliente', 'entrega', 'meio_pagamento_entrega')
        ->orderBy('data_pedido', 'ASC')
        ->get();
        

        $data = [
            'restaurante' => $restaurante,
            'pedidos' => $pedidos,
        ];

        return view('pedido/painel_pedidos', compact('data'));    
    }

      //RETORNAR VIEW PARA CADASTRO
      public function create(Request $request){

        //Verificar se há restaurante selecionado
        if(!session('restauranteConectado')){
            return redirect('restaurante')->with('error', 'Selecione um restaurante primeiro');
        }

        $id_restaurante  = session('restauranteConectado')['id'];
        $produtos = DB::table('produto AS p')
        ->select(
            'p.*',
        ) 
        ->join('categoria_produto AS cp', 'cp.id', '=', 'p.categoria_id')
        ->join('restaurante AS r', 'r.id', '=', 'cp.restaurante_id')
        ->where('r.id', $id_restaurante)
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

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            //todo
        ]);

        // Função calcular a distância
        function getDistance($origem, $destino, $apiKey) {
            // URL da API de Distância do Google Maps
            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origem}&destinations={$destino}&key={$apiKey}";
        
            // Fazendo a solicitação HTTP
            $response = file_get_contents($url);
            $data = json_decode($response);
        
            // Verificando se a solicitação foi bem-sucedida
            if ($data->status == 'OK') {
                // Obtendo a distância em metros
                $distance = $data->rows[0]->elements[0]->distance->value;
                return $distance;
            } else {
                return false;
            }
        }

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Verificar se há restaurante selecionado
        if(!session('restauranteConectado')){
            return redirect('restaurante')->with('error', 'Selecione um restaurante primeiro');
        }

        $id_restaurante  = session('restauranteConectado')['id'];
        $restaurante = Restaurante::where('id', $id_restaurante)->first();

        //Cadastro de pedido
        $pedido = new Pedido();
        $pedido->status = 0;
        $pedido->consumo_local_viagem_delivery = $request->input('entrega');//1. Local, 2. Viagem, 3. Delivery
        $pedido->observacao = $request->input('observacao');
        $pedido->data_pedido = Carbon::now()->format('Y-m-d H:i:s');
        $pedido->is_simulacao = true;
        $pedido->cliente_id = $request->input('cliente_id');
        $pedido->restaurante_id = $id_restaurante;
        $pedido->is_pagamento_entrega = true;
        $pedido->forma_pagamento_entrega_id = $request->input('forma_pagamento_entrega_id');
        $pedido->save();

        //Buscando produto
        $produto_id = $request->input('produto_id');
        $produto = Produto::where('id', $produto_id)->first();
        $qtd_produto = $request->input('quantidade');

        //Cadastro de item do pedido
        $item_pedido = new ItemPedido();
        $item_pedido->pedido_id = $pedido->id;
        $item_pedido->produto_id = $produto->id; 
        $item_pedido->quantidade = $qtd_produto;
        $item_pedido->preco_unitario = $produto->preco; 
        $item_pedido->subtotal = $produto->preco * $qtd_produto; 
        $item_pedido->save();

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

        }

        //Cadastro entrega
        if($pedido->consumo_local_viagem_delivery == 3){
            // Variáveis para calcular distância
            $origem = $restaurante->cep;
            $destino = $request->input('cep'); 
            $apiKey = 'AIzaSyCrR7RmCs0UkChkfbOJSoOUQ7kf9i-gcsk';

            // Obtendo a distância em metros
            $distancia = getDistance($origem, $destino, $apiKey);

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
            if($restaurante->is_taxa_entrega_free == true){
                $entrega->taxa_entrega = 0;

            // Taxa de entrega calculada por km
            }elseif($restaurante->taxa_por_km_entrega != null){
    
                // Verificar se deu certo a requisição
                if ($distancia !== false) {

                    // se distancia for maior que 1 km
                    if($distancia >= 1000){
                        $distancia_km = $distancia / 1000;
                        $entrega->taxa_entrega = $distancia_km * $restaurante->taxa_por_km_entrega;
                    }else{
                        $entrega->taxa_entrega = $restaurante->taxa_por_km_entrega;
                    
                    }
                }else{
                    return redirect('restaurante')->with('error', 'Erro ao calcular distância');
                }
    
            // Taxa de entrega fixa
            }elseif($restaurante->taxa_entrega_fixa != null){
                $entrega->taxa_entrega = $restaurante->taxa_entrega_fixa;
            }

            $entrega->save();

        }

        return redirect()->route('pedido.painel')->with('success', 'Cadastro feito com sucesso');

    }

    //PAINEL DE PEDIDOS
    public function show(Request $request){
        //Verificar se há restaurante selecionado
        if(!session('restauranteConectado')){
            return redirect('restaurante')->with('error', 'Selecione um restaurante primeiro para visualizar pedidos');
        }

        //Dados do restaurante
        $id_restaurante  = session('restauranteConectado')['id'];
        $restaurante = Restaurante::where('id', $id_restaurante)->first();

        //Dados pedido
        $pedido_id = $request->input('id');

        //Pedidos
        $pedidos = Pedido::where('restaurante_id', $id_restaurante)
        ->with('restaurante', 'forma_pagamento_entrega', 'item_pedido', 'cliente', 'entrega', 'meio_pagamento_entrega')
        ->orderBy('data_pedido', 'ASC')
        ->get();
        
        //Pedido
        $pedido = Pedido::where('id', $pedido_id)
        ->with('restaurante', 'forma_pagamento_entrega', 'item_pedido', 'cliente', 'entrega', 'meio_pagamento_entrega')
        ->orderBy('data_pedido', 'ASC')
        ->first();
        
        $data = [
            'restaurante' => $restaurante,
            'pedido' => $pedido,
            'pedidos' => $pedidos,
        ];

        return view('pedido/painel_pedidos', compact('data'));       
    }

    // ATUALIZAR STATUS PEDIDO
    public function update_status(Request $request){
         //Verificar se há restaurante selecionado
         if(!session('restauranteConectado')){
            return redirect('restaurante')->with('error', 'Selecione um restaurante primeiro');
        }

        //Dados do restaurante
        $id_restaurante  = session('restauranteConectado')['id'];
        $restaurante = Restaurante::where('id', $id_restaurante)->first();

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
        //Verificar se há restaurante selecionado
        if(!session('restauranteConectado')){
            return redirect('restaurante')->with('error', 'Selecione um restaurante primeiro');
        }

        //Dados do restaurante
        $id_restaurante  = session('restauranteConectado')['id'];
        $restaurante = Restaurante::where('id', $id_restaurante)->first();

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
        //Verificar se há restaurante selecionado
        if(!session('restauranteConectado')){
            return redirect('restaurante')->with('error', 'Selecione um restaurante primeiro');
        }

        //Dados do restaurante
        $id_restaurante  = session('restauranteConectado')['id'];
        $restaurante = Restaurante::where('id', $id_restaurante)->first();

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