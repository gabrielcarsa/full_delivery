<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Mesa;
use App\Models\Pedido;
use App\Models\Loja;

class MesaController extends Controller
{
    // EXIBIR MESAS PARA VIEW CADASTRO DE MESAS
    public function index(){
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar os mesas');
        }

        $loja_id = session('lojaConectado')['id'];
        $mesas = Mesa::where('loja_id', $loja_id)->get();

        $data = [
            'mesas' => $mesas,
        ];

        return view('mesa/listar', compact('data'));
    }

    //CADASTRAR MESA
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'nome' => 'required'
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar os mesas');
        }

        $loja_id = session('lojaConectado')['id'];

        $mesa = new Mesa();
        $mesa->nome = $request->input('nome');
        $mesa->loja_id = $loja_id;
        $mesa->save();

        return redirect()->back();

    }

    //EXCLUIR MESA
    public function destroy($id){
        $mesa = Mesa::find($id);
        $mesa->delete();
        return redirect()->back()->with('success', 'Mesa excluída com sucesso');
    }

    // GESTOR DE MESAS
    public function gestor(){

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar os mesas');
        }

        $loja_id = session('lojaConectado')['id'];

        //Mesas
        $mesas = Mesa::with('loja', 'pedido')
        ->where('loja_id', $loja_id)->get();

        $data = [
            'mesas' => $mesas,
        ];
        return view('mesa/gestor', compact('data'));
    }

    //EXIBIR MESA DETALHES - GESTOR MESAS
    public function show(Request $request){
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar mesas');
        }

        //Dados do loja
        $loja_id  = session('lojaConectado')['id'];

        //Dados mesa
        $mesa_id = $request->input('id');

        //Mesas
        $mesas = Mesa::where('loja_id', $loja_id)->get();
        
        //Mesa
        $mesa = Mesa::with('loja', 'pedido')
        ->where('id', $mesa_id)
        ->first();
       
        //Pedidos da mesa
        $pedidos = Pedido::with('loja', 'forma_pagamento_foomy', 'forma_pagamento_loja', 'item_pedido', 'cliente', 'entrega', 'mesa')
        ->orderBy('feito_em', 'DESC')
        ->where('mesa_id', $mesa_id)
        ->where('situacao', '!=', 2)
        ->get();

        $data = [
            'mesa' => $mesa,
            'mesas' => $mesas,
            'pedidos' => $pedidos,
        ];

        return view('mesa/gestor', compact('data'));       
    }

    // Mudar de mesa
    public function mudar_mesa(Request $request){
        //Dados 
        $mesa_atual_id = $request->input('mesa_atual_id');
        $mesa_nova_id = $request->input('mesa_nova_id');

        //Alterar mesa nos pedidos
        $pedidos_mesa = Pedido::where('mesa_id',$mesa_atual_id)->get();

        foreach($pedidos_mesa as $pedido){
            $pedido->mesa_id = $mesa_nova_id;
            $pedido->save();
        }

        $mesa_atual = Mesa::find($mesa_atual_id);
        $mesa_nova = Mesa::find($mesa_nova_id);

        // Definindo mesa nova com dados mesa atual
        $mesa_nova->is_ocupada = $mesa_atual->is_ocupada;
        $mesa_nova->hora_abertura = $mesa_atual->hora_abertura;
        $mesa_nova->valor_pago_parcial = $mesa_atual->valor_pago_parcial;
        $mesa_nova->is_taxa_paga = $mesa_atual->is_taxa_paga;
        $mesa_nova->save();

        // Resetando mesa atual
        $mesa_atual->is_ocupada = false;
        $mesa_atual->hora_abertura = null;
        $mesa_atual->valor_pago_parcial = 0;
        $mesa_atual->is_taxa_paga = false;
        $mesa_atual->save();

        return redirect()->back();
    }
}