<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MesaController extends Controller
{
    //
    public function painel(){
        return view('mesa/painel');
    }
}
