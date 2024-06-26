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

        $pedidos =  DB::table('pedido AS p')
        ->select(
            'p.*',
            'c.nome as cliente',
            'r.nome as restaurante',
            'forma.forma as forma_pagamento',
            'e.rua as rua',
            'e.bairro as bairro',
            'e.numero as numero',
            'e.complemento as complemento',
        ) 
        ->join('restaurante AS r', 'r.id', '=', 'p.restaurante_id')
        ->join('cliente AS c', 'c.id', '=', 'p.cliente_id')
        ->join('forma_pagamento_entrega AS forma', 'forma.id', '=', 'p.forma_pagamento_entrega_id')
        ->join('item_pedido AS i', 'i.pedido_id', '=', 'p.id')
        ->join('produto AS prod', 'prod.id', '=', 'i.produto_id')
        ->join('entrega AS e', 'e.pedido_id', '=', 'p.id')
        ->where('r.id', $id_restaurante)
        ->orderBy('p.data_pedido', 'ASC') 
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

        $pedidos =  DB::table('pedido AS p')
        ->select(
            'p.*',
            'c.nome as cliente',
            'r.nome as restaurante',
            'forma.forma as forma_pagamento',
            'e.rua as rua',
            'e.bairro as bairro',
            'e.numero as numero',
            'e.complemento as complemento',
        ) 
        ->join('restaurante AS r', 'r.id', '=', 'p.restaurante_id')
        ->join('cliente AS c', 'c.id', '=', 'p.cliente_id')
        ->join('forma_pagamento_entrega AS forma', 'forma.id', '=', 'p.forma_pagamento_entrega_id')
        ->join('item_pedido AS i', 'i.pedido_id', '=', 'p.id')
        ->join('produto AS prod', 'prod.id', '=', 'i.produto_id')
        ->join('entrega AS e', 'e.pedido_id', '=', 'p.id')
        ->where('r.id', $id_restaurante)
        ->orderBy('p.data_pedido', 'ASC') 
        ->get();
        
        $pedido = Pedido::where('id', $pedido_id)
        ->with('restaurante', 'forma_pagamento', 'item_pedido', 'produto', 'cliente', 'entrega', 'meio_pagamento')
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