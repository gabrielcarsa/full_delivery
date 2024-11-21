<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParcelaLancamento;
use App\Models\Lancamento;
use App\Models\Loja;
use App\Models\ContaCorrente;
use App\Models\Movimentacao;
use App\Models\Saldo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ParcelaLancamentoController extends Controller
{
    private function validarCheckboxes($checkboxesSelecionados)
    {
        foreach($checkboxesSelecionados as $parcelaId) {
            $parcela = ParcelaLancamento::find($parcelaId);
            if($parcela && $parcela->situacao == 1) {
                return redirect()->back()->with('error', 'Selecione apenas parcelas em aberto! Dica: para alterar parcelas já pagas, estorne o pagamento!');
            }
        }
        return null;
    }

    private function redirecionarComSucesso($tipo)
    {
        $rota = $tipo == 0 ? 'contas_pagar.index' : 'contas_receber.index';
        return redirect()->route($rota)->with('success', 'Parcelas alteradas com sucesso');
    }

    //VIEW PARA ALTERAR VALOR PARCELA
    public function editValorParcela(Request $request){

        if ($request->filled('checkboxes')) {

            $checkboxesSelecionados = explode(',', $request->input('checkboxes'));
            $validacao = $this->validarCheckboxes($checkboxesSelecionados);

            if ($validacao) return $validacao;

            //Select nas parcelas
            foreach ($checkboxesSelecionados as $parcelaId) {
                $parcelas[] = ParcelaLancamento::with('lancamento')
                ->where('id', $parcelaId)
                ->get();
            }

            //Variável para ajudar identificar operação a ser feita na view
            $varOperacao = "alterarValor";

            return view('parcela_lancamento/editar', compact('parcelas', 'varOperacao'));

        }else{
            return redirect()->back()->with('error', 'Nenhuma parcela selecionada!');
        }
    }

    //SALVAR ALTERAÇÃO VALOR DAS PARCELAS
    public function updateValorParcela(Request $request){
        //Transformar em formato correto para salvar no BD e validação
        $request->merge([
            'valor_parcela' => str_replace(['.', ','], ['', '.'], $request->get('valor_parcela')),
        ]);

        $validated = $request->validate([
            'valor_parcela' => 'required|numeric|min:0.1',
        ]);

        //Pegar um lancamento ID para verificar se é Conta a Pagar ou Receber
        $lancamentoID = null;

        //IDs das parcelas a serem alteradas
        $parcelasIds = $request->get('parcela_id', []);

        foreach($parcelasIds as $p){
            $parcela = ParcelaLancamento::find($p);
            $parcela->valor = $request->input('valor_parcela');
            $parcela->save();

            $lancamentoID = $parcela->lancamento_id;
        }

        $pagarOuReceber = Lancamento::find($lancamentoID);

        return $this->redirecionarComSucesso($pagarOuReceber->tipo);
    }

    //VIEW PARA ALTERAR DATA VENCIMENTO PARCELA
    public function editVencimentoParcela(Request $request){

        if ($request->filled('checkboxes')) {
           
            $checkboxesSelecionados = explode(',', $request->input('checkboxes'));
            $validacao = $this->validarCheckboxes($checkboxesSelecionados);

            if ($validacao) return $validacao;

            //Select nas parcelas
            foreach ($checkboxesSelecionados as $parcelaId) {
                $parcelas[] = ParcelaLancamento::with('lancamento')
                ->where('id', $parcelaId)
                ->get();
            }

            //Variável para ajudar identificar operação a ser feita na view
            $varOperacao = "alterarVencimento";

            return view('parcela_lancamento/editar', compact('parcelas', 'varOperacao'));

        }else{
            return redirect()->back()->with('error', 'Nenhuma parcela selecionada!');
        }
    }

    //SALVAR ALTERAÇÃO VENCIMENTO DAS PARCELAS
    public function updateVencimentoParcela(Request $request){

        $validated = $request->validate([
            'data_vencimento' => 'required|date',
        ]);

        //Pegar um lancamento ID para verificar se é Conta a Pagar ou Receber
        $lancamentoID = null;

        //IDs das parcelas a serem alteradas
        $parcelasIds = $request->get('parcela_id', []);
        
        $data_vencimento = $request->input('data_vencimento');

        //Data formatada Carbon
        $dataCarbon = Carbon::createFromFormat('Y-m-d', $data_vencimento);

        foreach($parcelasIds as $i => $p){
            $parcela = ParcelaLancamento::find($p);

            if($i > 0){
                $parcela->data_vencimento = $dataCarbon->addMonth();
            }else{
                $parcela->data_vencimento = $data_vencimento;
            }
            $parcela->save();

            $lancamentoID = $parcela->lancamento_id;
        }

        $pagarOuReceber = Lancamento::find($lancamentoID);

        return $this->redirecionarComSucesso($pagarOuReceber->tipo);
    }

    //BAIXAR PARCELA VIEW
    public function editBaixarParcela(Request $request){

        if ($request->filled('checkboxes')) {
           
            $checkboxesSelecionados = explode(',', $request->input('checkboxes'));
            $validacao = $this->validarCheckboxes($checkboxesSelecionados);

            if ($validacao) return $validacao;

            //Select nas parcelas
            foreach ($checkboxesSelecionados as $parcelaId) {
                $parcelas[] = ParcelaLancamento::with('lancamento')
                ->where('id', $parcelaId)
                ->get();
            }

            //Obter Lançamento para obter Loja selecionada
            $lancamentoID = $parcelas[0][0]->lancamento_id;
            $lancamento = Lancamento::find($lancamentoID);
            $loja_id = $lancamento->loja_id;
            $loja = Loja::find($loja_id);

            //Obter Contas Corrente dessa loja
            $contas_corrente = ContaCorrente::where('loja_id', $loja_id)->get();

            $dados = [
                'contas_corrente' => $contas_corrente,
                'loja' => $loja,
            ];

            return view('parcela_lancamento/baixar', compact('parcelas', 'dados'));

        }else{
            return redirect()->back()->with('error', 'Nenhuma parcela selecionada!');
        }
    }

    //
    public function updateBaixarParcela(Request $request){

        //Transformar em formato correto para salvar no BD e validação
        $request->merge([
            'valor_pago' => str_replace(['.', ','], ['', '.'], $request->get('valor_pago', [])),
        ]);

        //Validação
        $validated = $request->validate([
            'data.*' => 'required|date',
            'valor_pago.*' => 'required|numeric|min:0.1',
            'conta_corrente_id' => 'required|numeric|min:1',
        ]);

        $idParcelas = $request->get('parcela_id', []);
        $valorPago = $request->get('valor_pago', []);
        $dataPagamento = $request->get('data', []);

       
        foreach ($dataPagamento as $d) {

            //Verificar para não ser possível dar baixa com datas futuras
            if (strtotime($d) > strtotime(date('Y-m-d'))) {
                return redirect()->back()->with('error', 'Não é possível baixar com datas futuras!');
            }

            //Obter última data de Movimentacao
            $ultimaMovimentacao = Movimentacao::where('data_movimentacao', '>', $d)
            ->where('conta_corrente_id', $request->input('conta_corrente_id'))
            ->get();

            //Não permitir baixa de parcelas anterior há movimentações mais recentes, pois pode dar incosistência nos Saldos
            if($ultimaMovimentacao->isNotEmpty()){
                $dataReferenciaFormatada = Carbon::parse($ultimaMovimentacao[0]->data_movimentacao)->format('d/m/Y');
                return redirect()->back()->with('error', 'Não é possível baixar com datas anteriores de '.$dataReferenciaFormatada);
            }
        }   

        $i = 0;

        foreach ($idParcelas as $id) {

            //Baixar parcela
            $parcela = ParcelaLancamento::find($id);
            $parcela->valor_pago = $valorPago[$i];
            $parcela->data_pagamento = $dataPagamento[$i];
            $parcela->data_baixa = Carbon::now()->format('Y-m-d H:i:s');
            $parcela->baixado_usuario_id = Auth::guard()->user()->id;
            $parcela->situacao = 1;
            $parcela->save();

            //Selecionar ID do Lançamento
            $lancamentoID = $parcela->lancamento_id;
        
            //Obter lançamento
            $lancamento = Lancamento::find($lancamentoID);

            //Saldo da data
            $saldo = Saldo::where('data', $dataPagamento[$i])
            ->where('conta_corrente_id', $request->input('conta_corrente_id'))
            ->first(); //First pois só pode ter um saldo para uma data

            // Verificando se Saldo existe para aquela data
            if (is_null($saldo)) {

                // Saldo anterior
                $saldo_anterior = Saldo::orderBy('data', 'desc')
                ->where('data', '<', $dataPagamento[$i])
                ->where('conta_corrente_id', '=', $request->input('conta_corrente_id'))
                ->first(); 

                $saldoAux = 0;

                //Se não existir saldo cadastrado
                if(is_null($saldo_anterior)){

                    //Conta corrente para usar valor do saldo inicial
                    $conta_corrente = ContaCorrente::find($request->input('conta_corrente_id'));

                    //Trocando valores para saldo inicial da conta corrente
                    $saldoAux = $conta_corrente->saldo_inicial;

                }else{
                    $saldoAux = $saldo_anterior->saldo;
                }

                //Cadastrando Saldo
                Saldo::create([
                    'saldo' => $lancamento->tipo == 0 ? $saldoAux - $valorPago[$i] : $saldoAux + $valorPago[$i],
                    'conta_corrente_id' => $request->input('conta_corrente_id'),
                    'data' => $dataPagamento[$i],
                ]);

            } else {

                //Atualizando valor saldo
                $saldo->saldo = $lancamento->tipo == 0 ? $saldo->saldo - $valorPago[$i] : $saldo->saldo + $valorPago[$i];
                $saldo->save();
            }

            //Criando movimentação
            Movimentacao::create([
                'data_movimentacao' => $dataPagamento[$i],
                'loja_id' => $request->input('loja_id'),
                'tipo' => $lancamento->tipo,
                'valor' => $valorPago[$i],
                'cadastrado_usuario_id' => Auth::guard()->user()->id,
                'parcela_lancamento_id' => $parcela->id,
                'conta_corrente_id' => $request->input('conta_corrente_id'),
            ]);
            
            $i++;
        }

        $pagarOuReceber = Lancamento::find($lancamentoID);

        return $this->redirecionarComSucesso($pagarOuReceber->tipo);
    }
}