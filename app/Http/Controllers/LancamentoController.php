<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaFinanceiro;
use App\Models\Lancamento;
use App\Models\ParcelaLancamento;
use App\Models\Cliente;
use App\Models\Fornecedor;
use App\Models\Loja;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class LancamentoController extends Controller
{
    //INDEX CONTAS A PAGAR
    public function indexContasReceber(){
        //Pagar(0) ou Receber(1)
        $varPagarOuReceber = 1;
        return view('lancamento.listar', compact('varPagarOuReceber'));
    }

    //LISTAGEM CONTAS A RECEBER
    public function indexAllContasReceber(){
        //Pagar(0) ou Receber(1)
        $varPagarOuReceber = 1;
        $parcelas = ParcelaLancamento::with('lancamento')
        ->whereHas('lancamento', function ($query) {
            $query->where('tipo', 1); 
        })
        ->get();

        return view('lancamento.listar', compact('parcelas', 'varPagarOuReceber'));
    }

    //INDEX CONTAS A PAGAR
    public function indexContasPagar(){
        //Pagar(0) ou Receber(1)
        $varPagarOuReceber = 0;
        return view('lancamento.listar', compact('varPagarOuReceber'));
    }

    //LISTAGEM CONTAS A PAGAR
    public function indexAllContasPagar(){
    //Pagar(0) ou Receber(1)
    $varPagarOuReceber = 0;
    $parcelas = ParcelaLancamento::with('lancamento')
    ->whereHas('lancamento', function ($query) {
        $query->where('tipo', 0); 
    })
    ->get();

    return view('lancamento.listar', compact('parcelas', 'varPagarOuReceber'));
}

    //NOVO LANÇAMENTO
    public function create(Request $request){

        //Pagar(0) ou Receber(1)
        $varPagarOuReceber = $request->input('varPagarOuReceber');

        $clientes = null;
        $fornecedores = null;

        //Verificar a pagar ou receber
        if($varPagarOuReceber == 0 ){//Pagar
            $categorias = CategoriaFinanceiro::where('tipo', 0)->orderBy('nome', 'asc')->get();
            $fornecedores = Fornecedor::orderBy('nome', 'asc')->get();

        }else{//Receber
            $categorias = CategoriaFinanceiro::where('tipo', 1)->orderBy('nome', 'asc')->get();
            $clientes = Cliente::orderBy('nome', 'asc')->get();
        }

        //Lojas
        $lojas = Loja::all();

        $data = [
            'categorias' => $categorias,
            'lojas' => $lojas,
            'clientes' => $clientes,
            'fornecedores' => $fornecedores,
        ];

        return view('lancamento.novo', compact('data', 'varPagarOuReceber'));
    }

    //SALVAR LANÇAMENTO
    public function store(Request $request){

        //Definindo data para cadastrar
        date_default_timezone_set('America/Cuiaba');  
        
        //Pagar(0) ou Receber(1)
        $varPagarOuReceber = $request->input('varPagarOuReceber');

        $qtd_parcelas = $request->input('quantidade_parcela');
        $data_vencimento = $request->input('data_vencimento'); 
        $dataVencimentoCarbon = Carbon::createFromFormat('Y-m-d', $data_vencimento);

        //Validação
        $validated = $request->validate([
            'quantidade_parcela' => 'required|numeric',
            'cliente_fornecedor_id' => 'required|numeric|min:1',
            'categoria_financeiro_id' => 'required|numeric|min:1',
            'valor_parcela' => 'required|string',
            'data_vencimento' => 'required|date',
            'valor_entrada' => 'nullable|string',
        ]);

        $request->merge([
            'valor_parcela' => str_replace(['.', ','], ['', '.'], $request->input('valor_parcela')),
            'valor_entrada' => str_replace(['.', ','], ['', '.'], $request->input('valor_entrada')),
        ]);

        $valor_entrada = $request->input('valor_entrada') == "" ? null : $request->input('valor_entrada');

        //Cadastrando lancamento
        $lancamento = Lancamento::create([
            'loja_id' => $request->input('loja_id'),
            'tipo' => $varPagarOuReceber,
            'cliente_id' => $varPagarOuReceber == 0 ? null : $request->input('cliente_fornecedor_id'),
            'fornecedor_id' => $varPagarOuReceber == 0 ? $request->input('cliente_fornecedor_id') : null,
            'categoria_financeiro_id' => $request->input('categoria_financeiro_id'),
            'quantidade_parcela' => $qtd_parcelas,
            'data_vencimento' => $dataVencimentoCarbon,
            'valor_parcela' => $request->input('valor_parcela'),
            'valor_entrada' => $valor_entrada,
            'descricao' => $request->input('descricao'),
            'cadastrado_usuario_id' => Auth::guard()->user()->id,
        ]);
    
        //Cadastrando parcelas
        for($i = 1; $i <= $qtd_parcelas; $i++){
            ParcelaLancamento::create([
                'lancamento_id' => $lancamento->id,
                'numero_parcela' => $i,
                'situacao' => 0,
                'valor' => $i < 2 && $valor_entrada != null ? $valor_entrada : $request->input('valor_parcela'),
                'cadastrado_usuario_id' => Auth::guard()->user()->id,
                'data_vencimento' => $i > 1 ? $dataVencimentoCarbon->addMonth() : $dataVencimentoCarbon,
            ]);
        }

        //Verificando tipo de lançamento pagar ou receber
        if($varPagarOuReceber == 0){
            return redirect()->route('contas_pagar.index')->with('success', 'Nova despesa cadastrada com sucesso');
        }else{
            return redirect()->route('contas_receber.index')->with('success', 'Nova receita cadastrada com sucesso');
        }
    }
}
