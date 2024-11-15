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

    public function index(Request $request){

        //Validação
        $validated = $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date',
            'conta_corrente_id' => 'required|numeric|min:1',
        ]);
    
        // Obtém a data de hoje no formato 'YYYY-MM-DD'
        $hoje = now()->toDateString(); 
        
        $loja_id = $request->input('loja_id');
        $conta_corrente_id = $request->input('conta_corrente_id');
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        $movimentacoes = Movimentacao::with('parcela_lancamento', 'conta_corrente', 'loja')
        ->where('data_movimentacao', '>=', $dataInicio)
        ->where('data_movimentacao', '<=', $dataFim)
        ->where('loja_id', '=', $loja_id)
        ->where('conta_corrente_id', '=', $conta_corrente_id)
        ->orderBy('data_movimentacao')
        ->get();

        //Obter Loja conectada
        $loja_id = session('lojaConectado')['id'];
        $loja = Loja::find($loja_id);

        //Obter Contas Corrente dessa loja
        $contas_corrente = ContaCorrente::where('loja_id', $loja_id)->get();

        $dados = [
            'contas_corrente' => $contas_corrente,
            'loja' => $loja,
        ];

        return view('movimentacao/listar', compact('movimentacoes', 'dados'));
    }
}
