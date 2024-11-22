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

    //BAIXAR PARCELAS
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

            //Instaciando SaldoController para salvar Saldo
            $saldoController = new SaldoController();

            //Cadastrando Saldo
            $saldoController->store($valorPago[$i], $dataPagamento[$i], $request->input('conta_corrente_id'), $lancamento->tipo);
        
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

    // VIEW ESTORNAR PAGAMENTO OU RECEBIMENTO
    public function editEstornarPagamentoRecebimento(Request $request){

        if ($request->filled('checkboxes')) {
           
            $checkboxesSelecionados = explode(',', $request->input('checkboxes'));

            //Validar parcelas apenas pagas
            foreach($checkboxesSelecionados as $parcelaId) {
                $parcela = ParcelaLancamento::find($parcelaId);
                if($parcela && $parcela->situacao == 0) {
                    return redirect()->back()->with('error', 'Selecione apenas parcelas pagas!');
                }
            }

            //Select nas parcelas
            foreach ($checkboxesSelecionados as $parcelaId) {
                $parcelas[] = ParcelaLancamento::with('lancamento')
                ->where('id', $parcelaId)
                ->get();
            }

            $estornarPagRec = true;

            return view('parcela_lancamento/estornar', compact('parcelas', 'estornarPagRec'));

        }else{
            return redirect()->back()->with('error', 'Nenhuma parcela selecionada!');
        }
    }

    //BAIXAR PARCELAS
    public function updateEstornarPagamentoRecebimento(Request $request){

        $idParcelas = $request->get('parcela_id', []);

        //Validação estorno com data de pagamento que possui saldo mais recente
        foreach ($idParcelas as $id) {

            //Buscando parcela
            $parcela = ParcelaLancamento::find($id);

            //Saldos futuros do que o da data de pagamento
            $saldo = Saldo::orderBy('data', 'desc')
            ->where('data', '>', $parcela->data_pagamento)
            ->where('conta_corrente_id', '=', $parcela->movimentacao->conta_corrente_id)
            ->get(); 

            if($saldo->isNotEmpty()){

                $dataReferenciaFormatada = Carbon::parse($saldo[0]->data)->format('d/m/Y');

                return redirect()->back()->with('error', 'Não é possível estornar o pagamento/recebimento com datas anteriores a '. $dataReferenciaFormatada);
           
            }
        }

        $i = 0;

        foreach ($idParcelas as $id) {

            //Baixar parcela
            $parcela = ParcelaLancamento::find($id);
            $parcela->valor_pago = null;
            $parcela->data_pagamento = null;
            $parcela->data_baixa = null;
            $parcela->baixado_usuario_id = null;
            $parcela->situacao = 0;
            $parcela->save();

            //Tipo Lançamento
            $pagarOuReceber = $parcela->lancamento->tipo;

            //Buscando movimentação
            $movimentacao_id = $parcela->movimentacao->id;
            $movimentacao = Movimentacao::find($movimentacao_id);
       
            //Saldo para alterar
            $saldo = Saldo::where('data', $movimentacao->data_movimentacao)
            ->where('conta_corrente_id', '=', $movimentacao->conta_corrente_id)
            ->first(); 

            //Alterando Saldo
            $saldo->saldo = $pagarOuReceber == 0 ? $saldo->saldo + $movimentacao->valor : $saldo->saldo - $movimentacao->valor;
            $saldo->save();

            //Excluindo movimentação
            $movimentacao->delete();
            
            $i++;
        }

        return $this->redirecionarComSucesso($pagarOuReceber);
    }

     // VIEW ESTORNAR PARCELA
     public function editEstornarParcela(Request $request){

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

            return view('parcela_lancamento/estornar', compact('parcelas'));

        }else{
            return redirect()->back()->with('error', 'Nenhuma parcela selecionada!');
        }
    }

    //BAIXAR PARCELAS
    public function updateEstornarParcela(Request $request){

        $idParcelas = $request->get('parcela_id', []);

        $i = 0;

        foreach ($idParcelas as $id) {

            //Buscar parcela
            $parcela = ParcelaLancamento::find($id);

            //Selecionar ID do Lançamento
            $lancamentoID = $parcela->lancamento_id;
        
            //Obter lançamento
            $lancamento = Lancamento::find($lancamentoID);

            //Excluir Lançamento se só houver essa parcela
            if($lancamento->parcela_lancamento->count() <= 1){
                $lancamento->delete();
            }

            //Excluir parcela
            $parcela->delete();

            $i++;
        }

        $pagarOuReceber = Lancamento::find($lancamentoID);

        return $this->redirecionarComSucesso($pagarOuReceber->tipo);
    }
}