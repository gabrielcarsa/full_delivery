<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClienteEndereco;

class ClienteEnderecoController extends Controller
{
    //
    public function index(Request $request){
        //Variaveis GET
        $cliente_id = $request->input('cliente_id');

        $enderecos = ClienteEndereco::where('cliente_id', $cliente_id)->get();

        return view('cliente_endereco.listar', compact('enderecos'));
    }
}
