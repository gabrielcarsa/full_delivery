<?php

namespace App\Http\Controllers;
use App\Models\FormaPagamentoLoja;

use Illuminate\Http\Request;

class FormaPagamentoLojaController extends Controller
{
    // Exibir e editar formas de pagamentos disponíveis
    public function index(){

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar pedidos');
        }

        //Dados do loja
        $id_loja  = session('lojaConectado')['id'];

        //Formas de pagamento da Loja
        $formas_pagamento_loja = FormaPagamentoLoja::where('loja_id', $id_loja)->get();

        $data = [
            'formas_pagamento_loja' => $formas_pagamento_loja,
        ];

        return view('forma_pagamento_loja/listar', compact('data'));
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
        $formas_pagamento_selecionadas = $request->input('formas_pagamento_loja', []);
        
        // Recuperar todas as formas de pagamento para a loja
        $formas_pagamento = FormaPagamentoLoja::where('loja_id', $id_loja)->get();

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
}