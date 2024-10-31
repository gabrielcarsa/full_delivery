<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaFinanceiro;

class CategoriaFinanceiroController extends Controller
{
    //INDEX
    public function index(){

        //Obtendo todas categorias a receber
        $categorias_receber = CategoriaFinanceiro::where('tipo', 0)->get();

        //Obtendo todas categorias a pagar
        $categorias_pagar = CategoriaFinanceiro::where('tipo', 1)->get();

        $categorias = [
            'categorias_receber' => $categorias_receber,
            'categorias_pagar' => $categorias_pagar,
        ];

        return view('categoria_financeiro.listar', compact('categorias'));
    }
}
