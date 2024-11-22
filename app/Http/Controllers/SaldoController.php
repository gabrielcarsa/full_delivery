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

    //SALVAR SALDO
    public function store($valor, $data, $conta_corrente_id, $tipo){

        //Saldo da data
        $saldo = Saldo::where('data', $data)
        ->where('conta_corrente_id', $conta_corrente_id)
        ->first(); //First pois só pode ter um saldo para uma data

        // Verificando se Saldo existe para aquela data
        if (is_null($saldo)) {

            // Saldo anterior
            $saldo_anterior = Saldo::orderBy('data', 'desc')
            ->where('data', '<', $data)
            ->where('conta_corrente_id', '=', $conta_corrente_id)
            ->first(); 

            $saldoAux = 0;

            //Se não existir saldo cadastrado
            if(is_null($saldo_anterior)){

                //Conta corrente para usar valor do saldo inicial
                $conta_corrente = ContaCorrente::find($conta_corrente_id);

                //Trocando valores para saldo inicial da conta corrente
                $saldoAux = $conta_corrente->saldo_inicial;

            }else{
                $saldoAux = $saldo_anterior->saldo;
            }

            //Cadastrando Saldo
            Saldo::create([
                'saldo' => $tipo == 0 ? $saldoAux - $valor : $saldoAux + $valor,
                'conta_corrente_id' => $conta_corrente_id,
                'data' => $data,
            ]);

        } else {

            //Atualizando valor saldo
            $saldo->saldo = $tipo == 0 ? $saldo->saldo - $valor : $saldo->saldo + $valor;
            $saldo->save();
        }

    }
}
