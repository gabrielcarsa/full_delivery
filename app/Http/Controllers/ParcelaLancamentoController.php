<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParcelaLancamento;
use App\Models\Lancamento;

class ParcelaLancamentoController extends Controller
{
    //VIEW PARA ALTERAR VALOR PARCELA
    public function editValorParcela(Request $request){

        // Verifique se a chave 'checkboxes' está presente na requisição
        if ($request->has('checkboxes') && $request->filled('checkboxes')) {
            // Recupere os valores dos checkboxes da consulta da URL
            $checkboxesSelecionados = $request->input('checkboxes');

            // Converta os valores dos checkboxes em um array
            $checkboxesSelecionados = explode(',', $checkboxesSelecionados); 

            //Verificar se há parcelas pagas
            foreach($checkboxesSelecionados as $parcelaId) {
                $parcela = ParcelaLancamento::find($parcelaId);

                //Se houver parcelas pagas redireciona de volta
                if($parcela->situacao == 1){
                    return redirect()->back()->with('error', 'Selecione apenas parcelas em aberto! Dica: para alterar parcelas já pagas estornar o pagamento!');
                }
            }

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

        if($pagarOuReceber->tipo == 0){
            return redirect()->route('contas_pagar.index')->with('success', 'Parcelas alteradas com sucesso');   
        }else{
            return redirect()->route('contas_receber.index')->with('success', 'Parcelas alteradas com sucesso');   
        }
             
    }
}