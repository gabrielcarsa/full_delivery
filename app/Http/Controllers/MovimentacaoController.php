<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loja;
use App\Models\ContaCorrente;
use App\Models\Movimentacao;

class MovimentacaoController extends Controller
{
    //FORM VIEW MOVIMENTAÇÕES
    public function showFormConsulta(){

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar os mesas');
        }

        //Obter Loja conectada
        $loja_id = session('lojaConectado')['id'];
        $loja = Loja::find($loja_id);

        //Obter Contas Corrente dessa loja
        $contas_corrente = ContaCorrente::where('loja_id', $loja_id)->get();

        $dados = [
            'contas_corrente' => $contas_corrente,
            'loja' => $loja,
        ];

        return view('movimentacao.listar', compact('dados'));
    }
}
