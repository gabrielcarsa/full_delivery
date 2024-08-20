<?php

namespace App\Http\Controllers;
use App\Models\FormaPagamentoLoja;

use Illuminate\Http\Request;

class FormaPagamentoLojaController extends Controller
{
    public function index(){
        //Formas de pagamento da Loja
        $formas_pagamento_loja = FormaPagamentoLoja::all();

        $data = [
            'formas_pagamento_loja' => $formas_pagamento_loja,
        ];

        return view('forma_pagamento_loja/listar', compact('data'));
    }
}
