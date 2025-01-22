<?php

namespace App\Http\Controllers;
use App\Models\FormaPagamento;
use App\Models\FormaPagamentoLoja;
use App\Models\ContaCorrente;

use Illuminate\Http\Request;

class FormaPagamentoController extends Controller
{
    // Exibir e editar formas de pagamentos disponíveis
    public function index(){

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar pedidos');
        }

        //Dados do loja
        $loja_id  = session('lojaConectado')['id'];

        //Formas de Pagamentos 
        $formas_pagamento = FormaPagamento::all();

        //Formas de pagamento da Loja
        $formas_pagamento_loja = FormaPagamentoLoja::where('loja_id', $loja_id)->get();

        //Contas Corrente
        $contas_corrente = ContaCorrente::where('loja_id', $loja_id)->get();

        $dados = [
            'formas_pagamento' => $formas_pagamento,
            'contas_corrente' => $contas_corrente,
            'formas_pagamento_loja' => $formas_pagamento_loja,
        ];

        return view('forma_pagamento/listar', compact('dados'));
    }

    //Alterar e salvar formas de pagamento selecionadas
    public function store(Request $request){

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar pedidos');
        }

        //Dados do loja
        $loja_id  = session('lojaConectado')['id'];

        // ID das formas de pagamento selecionadas
        $forma_pagamento_id = $request->input('forma_pagamento_id');

        // Recuperar forma de pagamento para a loja
        $forma_pagamento_loja = FormaPagamentoLoja::where('loja_id', $loja_id)->where('forma_pagamento_id', $forma_pagamento_id)->first(); 
        
        //Se não houver aquela forma de pagamento da Loja
        if($forma_pagamento_loja == null){

            FormaPagamentoLoja::create([
                'loja_id' => $loja_id,
                'forma_pagamento_id' => $forma_pagamento_id,
            ]);
        }else{
            $forma_pagamento_loja->delete();
        }
        
        return redirect()->back()->with('success', 'Operação realizada com sucesso');
    }

    //VINCULAR FORMA COM CONTA CORRENTE
    public function updateVincular(Request $request){

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar pedidos');
        }

        $forma_pagamento = FormaPagamento::find($request->input('id'));
        $forma_pagamento->conta_corrente_id = $request->input('conta_corrente_id');
        $forma_pagamento->save();

        return redirect()->back()->with('success', 'Vinculado com sucesso');

    }
}