<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
     //LISTAGEM
     public function index(){
        $clientes = Cliente::all();
        return view('cliente/listar', compact('clientes'));
    }

    //RETORNAR VIEW CADASTRO
    public function create(Request $request){
        return view('cliente.novo');
    }

    //CADASTRAR
    public function store(Request $request){
        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|max:20',
            'email' => 'required|string|max:100',
            'telefone' => 'nullable|string|max:100',
            'cep' => 'nullable|max:100',
            'rua' => 'nullable|max:100',
            'bairro' => 'nullable|max:100',
            'numero' => 'nullable|max:100',
            'cidade' => 'nullable|max:100',
            'estado' => 'nullable|max:100',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Cadastro de cliente
        $cliente = new Cliente();

        //Informações Gerais
        $cliente->nome = $request->input('nome');
        $cliente->cpf = $request->input('cpf');
        $cliente->email = $request->input('email');
        $cliente->telefone = $request->input('telefone');

        //Endereço
        $cliente->cep = $request->input('cep');
        $cliente->rua = $request->input('rua');
        $cliente->bairro = $request->input('bairro');
        $cliente->numero = $request->input('numero');
        $cliente->complemento = $request->input('complemento');
        $cliente->cidade = $request->input('cidade');
        $cliente->estado = $request->input('estado');
        $cliente->save();

        return redirect()->route('cliente')->with('success', 'Cadastro feito com sucesso');
    }


    //ALTERAR VIEW
    public function edit(Request $request){
        $id = $request->input('id');
        $cliente = Cliente::find($id);
        return view('cliente/novo', compact('cliente'));
    }

    //ALTERAR
    public function update(Request $request, $cliente_id){
        
        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|max:20',
            'email' => 'required|string|max:100',
            'telefone' => 'nullable|string|max:100',
            'cep' => 'nullable|max:100',
            'rua' => 'nullable|max:100',
            'bairro' => 'nullable|max:100',
            'numero' => 'nullable|max:100',
            'cidade' => 'nullable|max:100',
            'estado' => 'nullable|max:100',
        ]);
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Alterar cliente
        $cliente = Cliente::where('id', $cliente_id)->first();

        //Informações Gerais
        $cliente->nome = $request->input('nome');
        $cliente->cpf = $request->input('cpf');
        $cliente->email = $request->input('email');
        $cliente->telefone = $request->input('telefone');

        //Endereço
        $cliente->cep = $request->input('cep');
        $cliente->rua = $request->input('rua');
        $cliente->bairro = $request->input('bairro');
        $cliente->numero = $request->input('numero');
        $cliente->complemento = $request->input('complemento');
        $cliente->cidade = $request->input('cidade');
        $cliente->estado = $request->input('estado');
        $cliente->save();


        return redirect()->route('cliente')->with('success', 'Alteração feita com sucesso');
    }

    //EXCLUIR
    public function destroy($id){
        $cliente = Cliente::find($id);
        $cliente->delete();
        return redirect()->back()->with('success', 'Cliente excluido com sucesso');
    }
}