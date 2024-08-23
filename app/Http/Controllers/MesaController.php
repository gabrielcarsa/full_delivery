<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Mesa;

class MesaController extends Controller
{
    //
    public function index(){
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar os pedidos');
        }

        $loja_id = session('lojaConectado')['id'];
        $mesas = Mesa::where('loja_id', $loja_id)->get();

        $data = [
            'mesas' => $mesas,
        ];

        return view('mesa/listar', compact('data'));
    }

    public function gestor(){
        return view('mesa/gestor');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'nome' => 'required'
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar os pedidos');
        }

        $loja_id = session('lojaConectado')['id'];

        $mesa = new Mesa();
        $mesa->nome = $request->input('nome');
        $mesa->loja_id = $loja_id;
        $mesa->save();

        return redirect()->back();

    }

     //EXCLUIR
     public function destroy($id){
        $mesa = Mesa::find($id);
        $mesa->delete();
        return redirect()->back()->with('success', 'Mesa excluída com sucesso');
    }
}