<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loja;
use App\Models\ContaCorrente;
use App\Models\Movimentacao;
use App\Models\Saldo;
use App\Models\Cliente;
use App\Models\Fornecedor;
use App\Models\CategoriaFinanceiro;
use App\Models\ParcelaLancamento;
use App\Models\Lancamento;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        // Saldo anterior
        $saldo_anterior = Saldo::orderBy('data', 'desc')
        ->where('data', '<', $dataInicio)
        ->where('conta_corrente_id', '=', $conta_corrente_id)
        ->first(); 

        $dados = [
            'contas_corrente' => $contas_corrente,
            'loja' => $loja,
            'saldo_anterior' => $saldo_anterior,
        ];

        return view('movimentacao/listar', compact('movimentacoes', 'dados'));
    }

    //VIEW PARA CADASTRAR MOVIMENTAÇÕES
    public function create(){

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar os mesas');
        }

        $loja = Loja::find(session('lojaConectado')['id']);

        //Cliente
        $clientes = Cliente::all();

        //Fornecedores
        $fornecedores = Fornecedor::all();

        //Obter Contas Corrente dessa loja
        $contas_corrente = ContaCorrente::where('loja_id', $loja->id)->get();

        //Categorias
        $categorias = CategoriaFinanceiro::all();

        $dados = [
            'contas_corrente' => $contas_corrente,
            'loja' => $loja,
            'clientes' => $clientes,
            'fornecedores' => $fornecedores,
            'categorias' => $categorias,
        ];

        return view('movimentacao/novo', compact('dados'));
    }

    //CADASTRAR MOVIMENTAÇÕES
    public function store(Request $request){

        //Definindo data para cadastrar
        date_default_timezone_set('America/Cuiaba');    

        //Validação
        $validated = $request->validate([
            'data' => 'required|date',
            'conta_corrente_id' => 'required|numeric|min:1',
        ]);

        //Verificar para não ser possível dar baixa com datas futuras
        if (strtotime($request->input('data')) > strtotime(date('Y-m-d'))) {
            return redirect()->back()->with('error', 'Não é possível baixar com datas futuras!');
        }

        //Obter última data de Movimentacao
        $ultimaMovimentacao = Movimentacao::where('data_movimentacao', '>', $request->input('data'))
        ->where('conta_corrente_id', $request->input('conta_corrente_id'))
        ->get();

        //Não permitir baixa de parcelas anterior há movimentações mais recentes, pois pode dar incosistência nos Saldos
        if($ultimaMovimentacao->isNotEmpty()){
            $dataReferenciaFormatada = Carbon::parse($ultimaMovimentacao[0]->data_movimentacao)->format('d/m/Y');
            return redirect()->back()->with('error', 'Não é possível baixar com datas anteriores de '.$dataReferenciaFormatada);
        }

        /* ------
        Salve as movimentações
        ------ */
        foreach ($request->input('movimentacoes') as $movimentacaoData) {
        
            $valor = str_replace(',', '.', str_replace('.', '', $movimentacaoData['valor']));

            $varPagarOuReceber = $movimentacaoData['tipo_movimentacao'] == 1 ? 0 : 1;

            //Validar
            $validated = $request->validate([
                "movimentacoes.*.tipo_movimentacao" => 'required|numeric|min:1',
                "movimentacoes.*.categoria_financeiro_id" => 'required|numeric|min:1',
                "movimentacoes.*.cliente_id" => $varPagarOuReceber == 0 ? 'nullable|numeric' : 'required|numeric|min:1',
                "movimentacoes.*.fornecedor_id" => $varPagarOuReceber == 0 ? 'required|numeric|min:1' : 'nullable|numeric',
                "movimentacoes.*.valor" => 'required|min:0.1',
                "movimentacoes.*.descricao" => 'nullable|string|max:255',
            ]);

            //Cadastrando lancamento
            $lancamento = Lancamento::create([
                'loja_id' => $request->input('loja_id'),
                'tipo' => $varPagarOuReceber,
                'cliente_id' => $varPagarOuReceber == 0 ? null : $movimentacaoData['cliente_id'],
                'fornecedor_id' => $varPagarOuReceber == 0 ? $movimentacaoData['fornecedor_id'] : null,
                'categoria_financeiro_id' => $movimentacaoData['categoria_financeiro_id'],
                'quantidade_parcela' => 1,
                'data_vencimento' => $request->input('data'),
                'valor_parcela' => $valor,
                'valor_entrada' => null,
                'descricao' => $movimentacaoData['descricao'],
                'cadastrado_usuario_id' => Auth::guard()->user()->id,
            ]);
        
            //Cadastrando parcelas
            $parcela = ParcelaLancamento::create([
                'lancamento_id' => $lancamento->id,
                'numero_parcela' => 1,
                'situacao' => 1,
                'valor' => $valor,
                'cadastrado_usuario_id' => Auth::guard()->user()->id,
                'data_vencimento' => $request->input('data'),
                'valor pago' => $valor,
                'data_baixa' => Carbon::now()->format('Y-m-d H:i:s'),
                'baixado_usuario_id' => Auth::guard()->user()->id,
            ]);

            //Instaciando SaldoController para salvar Saldo
            $saldoController = new SaldoController();

            //Cadastrando Saldo
            $saldoController->store($valor, $request->input('data'), $request->input('conta_corrente_id'), $lancamento->tipo);

            //Criando movimentação
            Movimentacao::create([
                'data_movimentacao' => $request->input('data'),
                'loja_id' => $request->input('loja_id'),
                'tipo' => $lancamento->tipo,
                'valor' => $valor,
                'cadastrado_usuario_id' => Auth::guard()->user()->id,
                'parcela_lancamento_id' => $parcela->id,
                'conta_corrente_id' => $request->input('conta_corrente_id'),
            ]);
        }
    
        return redirect()->back()->with('success', 'Movimentações cadastradas com sucesso');
    }
}