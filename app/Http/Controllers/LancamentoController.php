<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LancamentoController extends Controller
{
    //Index Contas a Receber
    public function indexContasReceber(){
        return view('lancamento.contas_receber_listar');
    }
}
