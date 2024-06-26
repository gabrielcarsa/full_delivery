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
            return redirect('restaurante')->with('error', 'Selecione um restaurante primeiro para visualizar as categorias e produtos');
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
            return redirect('restaurante')->with('error', 'Selecione um restaurante primeiro para visualizar as categorias e produtos');
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

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Verificar se há restaurante selecionado
        if(!session('restauranteConectado')){
            return redirect('restaurante')->with('error', 'Selecione um restaurante primeiro para visualizar as categorias e produtos');
        }

        $id_restaurante  = session('restauranteConectado')['id'];

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
            $qtd_opcional = $request->input('quantidade');

            $opcional_item_pedido = new OpcionalItem();
            $opcional_item_pedido->item_pedido_id = $item_pedido->id;
            $opcional_item_pedido->opcional_produto_id = $request->input('opcional_produto_id');
            $opcional_item_pedido->quantidade = $request->input('quantidade_opcional');
            $opcional_item_pedido->quantidade = $qtd_opcional;
            $opcional_item_pedido->preco_unitario = $opcional->preco; 
            $opcional_item_pedido->subtotal = $opcional->preco * $qtd_opcional; 
            $opcional_item_pedido->save();

        }

        //Cadastro entrega
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
            $entrega->save();
        }

        return redirect()->route('pedido.painel')->with('success', 'Cadastro feito com sucesso');

    }

    //PAINEL DE PEDIDOS
    public function show(Request $request){
        //Verificar se há restaurante selecionado
        if(!session('restauranteConectado')){
            return redirect('restaurante')->with('error', 'Selecione um restaurante primeiro para visualizar as categorias e produtos');
        }

        //Dados do restaurante
        $id_restaurante  = session('restauranteConectado')['id'];
        $restaurante = Restaurante::where('id', $id_restaurante)->first();

        //Dados pedido
        $pedido_id = $request->input('id');

        $pedidos = Pedido::where('restaurante_id', $id_restaurante)
        ->with('restaurante', 'forma_pagamento_entrega', 'item_pedido', 'cliente', 'entrega', 'meio_pagamento_entrega')
        ->orderBy('data_pedido', 'ASC')
        ->get();
        
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
}