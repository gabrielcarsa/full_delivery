<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cupom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CupomController extends Controller
{
    //LISTAGEM
    public function index(){
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para ver os cupons');
        }
        $cupons = Cupom::all();
        return view('vantagens/cupom', compact('cupons'));
    }

    //RETORNAR VIEW CADASTRO
    public function create(Request $request){
        return view('vantagens/novo_cupom');
    }

    //CADASTRAR
    public function store(Request $request){
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para ver os cupons');
        }
        $id_loja  = session('lojaConectado')['id'];

        //Definindo data para cadastrar
        date_default_timezone_set('America/Cuiaba');

        $request->merge([
            'desconto' => str_replace(['.', ','], ['', '.'], $request->input('desconto')),
        ]);
         
        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string|max:50|unique:cupom',
            'tipo_desconto' => 'required|min:1',
            'desconto' => 'required|numeric',
            'data_validade' => 'nullable|date',
            'limite_uso' => 'nullable|numeric',
            'descricao' => 'nullable|max:255',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Cadastro de Cupom
        $cupom = new Cupom();

        $cupom->codigo = $request->input('codigo');
        $cupom->tipo_desconto = $request->input('tipo_desconto');
        $cupom->desconto = $request->input('desconto');
        $cupom->data_validade = $request->input('data_validade');
        $cupom->limite_uso = $request->input('limite_uso');
        $cupom->descricao = $request->input('descricao');
        $cupom->loja_id = $id_loja;
        $cupom->is_ativo = true;
        $cupom->cadastrado_usuario_id = Auth::user()->id;

        $cupom->save();

        return redirect()->route('cupom')->with('success', 'Cadastro feito com sucesso');
    }

    //ALTERAR VIEW
    public function edit(Request $request){
        $id = $request->input('id');
        $cupom = Cupom::find($id);
        return view('vantagens/novo_cupom', compact('cupom'));
    }

    //ALTERAR
    public function update(Request $request, $id){
        
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para ver os cupons');
        }
        $id_loja  = session('lojaConectado')['id'];

        //Definindo data para cadastrar
        date_default_timezone_set('America/Cuiaba');

        $request->merge([
            'desconto' => str_replace(['.', ','], ['', '.'], $request->input('desconto')),
        ]);
        
        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'desconto' => 'required|numeric',
            'data_validade' => 'nullable|date',
            'limite_uso' => 'nullable|numeric',
            'descricao' => 'nullable|max:255',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        //Alterando produto
        $cupom = Cupom::find($id);
        $cupom->desconto = $request->input('desconto');
        $cupom->data_validade = $request->input('data_validade');
        $cupom->limite_uso = $request->input('limite_uso');
        $cupom->descricao = $request->input('descricao');
        $cupom->alterado_usuario_id = Auth::user()->id;
        $cupom->save();

        return redirect()->back()->with('success', 'Alteração feita com sucesso');
    }



}
