<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cupom;

class CupomController extends Controller
{
    //LISTAGEM
    public function index(){
        $cupons = Cupom::all();
        return view('vantagens/cupom', compact('cupons'));
    }

}
