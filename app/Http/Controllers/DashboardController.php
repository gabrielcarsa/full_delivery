<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\LojaHelper;

class DashboardController extends Controller
{
    //
    public function dashboard(){

        //Obter lojas do usuário
        $lojas = LojaHelper::getUserLoja();

        $dados = [
            'lojas' => $lojas,
        ];

        return view('dashboard', compact('dados'));
    }
}
