<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClienteEndereco;
use Illuminate\Support\Facades\Validator;

class ClienteEnderecoController extends Controller
{
    //
    public function index(Request $request){
        //Variaveis GET
        $cliente_id = $request->input('cliente_id');

        $enderecos = ClienteEndereco::where('cliente_id', $cliente_id)->get();

        return view('cliente_endereco.listar', compact('enderecos'));
    }

    public function create(Request $request){
        return view('cliente_endereco.novo');
    }

    public function store(Request $request){
        //Variaveis GET
        $cliente_id = $request->input('cliente_id');

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:50',
            'cep' => 'required|string|max:100',
            'rua' => 'required|string|max:100',
            'bairro' => 'required|string|max:100',
            'numero' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|max:100',
            'complemento' => 'nullable|string|max:100',
        ]);
          
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Cadastro
        $endereco = new ClienteEndereco();
        $endereco->nome = $request->input('nome');
        $endereco->cep = $request->input('cep');
        $endereco->rua = $request->input('rua');
        $endereco->bairro = $request->input('bairro');
        $endereco->numero = $request->input('numero');
        $endereco->complemento = $request->input('complemento');
        $endereco->cidade = $request->input('cidade');
        $endereco->estado = $request->input('estado');
        $endereco->cliente_id = $cliente_id;
        $endereco->save();

        return redirect()->route('cliente_endereco.listar', ['cliente_id' => $cliente_id])->with('success', 'Cadastro feito com sucesso');
    }

    //EXCLUIR
    public function destroy($id){
        $endereco = ClienteEndereco::find($id);
        $endereco->delete();
        return redirect()->back()->with('success', 'Endereço excluido com sucesso');
    }
}