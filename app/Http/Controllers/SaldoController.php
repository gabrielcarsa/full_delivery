<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContaCorrente;
use App\Models\Saldo;
use Carbon\Carbon;

class SaldoController extends Controller
{
    public function index(Request $request){

        //Conta Corrente
        $conta_corrente_id = $request->input('conta_corrente_id');
        $conta_corrente = ContaCorrente::find($conta_corrente_id);

        //Saldos
        $saldosDaConta = Saldo::orderBy('data', 'asc')
        ->where('conta_corrente_id', '=', $conta_corrente_id)
        ->get(); 
        
        $datas = [];
        $saldos = [];

        //Adicionando Saldo Inicial
        $datas[] = (Carbon::parse($conta_corrente->created_at)->format('d/m/Y'));
        $saldos[] = $conta_corrente->saldo_inicial;

        //Populando arrays de saldos e datas respectivos
        foreach($saldosDaConta as $saldo){
            $datas[] = Carbon::parse($saldo->data)->format('d/m/Y');
            $saldos[] = $saldo->saldo;
        }

        $dados = [
            'datas' => $datas,
            'saldos' => $saldos,
            'conta_corrente' => $conta_corrente,
        ];

        return view('saldo.listar', compact('dados'));
    }
}
