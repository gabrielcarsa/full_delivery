<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cupom;
use App\Models\UsoCupom;
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
        return view('cupom/listar', compact('cupons'));
    }

    //RETORNAR VIEW CADASTRO
    public function create(Request $request){
        return view('cupom/novo');
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
        return view('cupom/novo', compact('cupom'));
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

    //EXCLUIR
    public function destroy($id){
        $cupom = Cupom::find($id);
        $cupom->delete();
        return redirect()->back()->with('success', 'Cupom excluido com sucesso');
    }

     // ATUALIZAR STATUS 
     public function status(Request $request){
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
           return redirect('loja')->with('error', 'Selecione um loja primeiro');
       }

       //ID cupom
       $cupom_id = $request->input('id');
       
       //Cupom
       $cupom = Cupom::find($cupom_id);
       
       $status_atual = $cupom->is_ativo;

        if($status_atual){
            $cupom->is_ativo = false;
        }else{
            $cupom->is_ativo = true;
        }
       $cupom->save();
       return redirect()->back()->with('success', 'Status atualizado com sucesso');

   }

    //ALTERAR VIEW
    public function show(Request $request){
        $cupom_id = $request->input('id');

        $cupom = Cupom::where('id', $cupom_id)
        ->with('uso_cupom.pedido')
        ->first();
        
        return view('cupom/show', compact('cupom'));
    }




}
