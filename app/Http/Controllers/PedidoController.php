<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurante;
use App\Models\Pedido;

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
        $pedidos = Pedido::where('restaurante_id', $restaurante->id)->first();

        $data = [
            'restaurante' => $restaurante,
            'pedidos' => $pedidos,
        ];

        return view('pedido/painel_pedidos', compact('data'));    
    }
}