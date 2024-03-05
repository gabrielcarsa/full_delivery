<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurante;
use App\Models\HorarioFuncionamento;
use Illuminate\Support\Facades\Validator;

class RestauranteController extends Controller
{
    //LISTAGEM
    public function index(){
        $restaurantes = Restaurante::all();

        return view('restaurante/listar', compact('restaurantes'));
    }

    //RETORNAR VIEW PARA CONFIGURAÇÕES
    public function configuracao(Request $request){
        return view('restaurante.configuracao');
    }

    //CADASTRAR
    public function store(Request $request, $usuario_id){
        // Validação do formulário
        $validator = Validator::make($request->all(), [
            //TODO: fazer validações
            'imagem' => 'required|image|mimes:jpeg,png,jpg|max:20480|dimensions:min_width=300,min_height=275',
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:500',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Cadastro de categoria
        $restaurante = new Restaurante();

        //Informações Gerais
        $restaurante->nome = $request->input('nome');
        $restaurante->descricao = $request->input('descricao');
        $restaurante->cadastrado_usuario_id = $usuario_id;
        if ($request->hasFile('imagem')) {
            //Colocando nome único no arquivo
            $nomeArquivo = "logo";
            $request->file('imagem')->storeAs('public/logo', $nomeArquivo);
            $restaurante->imagem = $nomeArquivo;
        }

        //Endereço
        $restaurante->cep = $request->input('cep');
        $restaurante->rua = $request->input('rua');
        $restaurante->bairro = $request->input('bairro');
        $restaurante->numero = $request->input('numero');
        $restaurante->complemento = $request->input('complemento');
        $restaurante->cidade = $request->input('cidade');
        $restaurante->estado = $request->input('estado');
        $restaurante->save();

        //Horario Funcionamento
        $i = 0;
        for($i; $i < 7; $i++){
            $horario_funcionamento = new HorarioFuncionamento();
            $horario_funcionamento->id = $restaurante->id;
            $horario_funcionamento->hora_abertura = $request->input($i.'_abertura'); 
            $horario_funcionamento->hora_fechamento = $request->input($i.'_fechamento'); 
            $horario_funcionamento->save();

        }


        return redirect()->route('restaurante')->with('success', 'Cadastro feito com sucesso');
    }

    //ALTERAR VIEW

    //ALTERAR

}