<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParcelaLancamento;
use App\Models\Lancamento;
use Carbon\Carbon;

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
}