<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContaCorrente;

class ContaCorrenteController extends Controller
{
    //LISTAR CONTAS
    public function index(){

        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar as categorias e produtos');
        }

        //Sessão do loja que está conectado
        $lojaIdConectado = session('lojaConectado')['id'];

        $contas_corrente = ContaCorrente::where('loja_id', $lojaIdConectado)
        ->with('loja', 'usuarioCadastrador')
        ->get();

        return view('conta_corrente/listar', compact('contas_corrente'));
    }
}
