<?php

namespace App\Http\Controllers;
use App\Models\FormaPagamento;
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

        //Formas de pagamento da Loja
        $formas_pagamento = FormaPagamento::where('loja_id', $loja_id)->get();

        //Contas Corrente
        $contas_corrente = ContaCorrente::where('loja_id', $loja_id)->get();

        $dados = [
            'formas_pagamento' => $formas_pagamento,
            'contas_corrente' => $contas_corrente,
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
        $id_loja  = session('lojaConectado')['id'];

        // IDs das formas de pagamento selecionadas
        $formas_pagamento_selecionadas = $request->input('formas_pagamento', []);
        
        // Recuperar todas as formas de pagamento para a loja
        $formas_pagamento = FormaPagamento::where('loja_id', $id_loja)->get();

        foreach ($formas_pagamento as $forma_pagamento) {
            // Verifica se a forma de pagamento foi selecionada
            if (in_array($forma_pagamento->id, $formas_pagamento_selecionadas)) {
                $forma_pagamento->is_ativo = true; // Ativar se foi selecionada
            } else {
                $forma_pagamento->is_ativo = false; // Desativar se não foi selecionada
            }

            // Salvar a atualização no banco de dados
            $forma_pagamento->save();
        }
        
        
        return redirect()->back();
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