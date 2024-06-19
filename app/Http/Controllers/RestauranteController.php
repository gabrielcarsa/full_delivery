<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurante;
use App\Models\HorarioFuncionamento;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RestauranteController extends Controller
{
     //ESCOLHER RESTAURANTE
     public function choose(Request $request, $id){
        //Buscando restaurante
        $restaurante = Restaurante::where('id', $id)->get();

        //Definindo variavel de sessão de restaurante
        session(['restauranteConectado' => ['id'=> $id, 'nome'=> $restaurante[0]->nome]]);

        return redirect()->route('restaurante')->with('success', 'Conectado como ');
    }

    //LISTAGEM
    public function index(){
        //dd(session('restauranteConectado')['nome']);
        $restaurantes = Restaurante::all();
        $horarios_funcionamento = HorarioFuncionamento::all();
        return view('restaurante/listar', compact('restaurantes', 'horarios_funcionamento'));
    }

    //RETORNAR VIEW PARA CONFIGURAÇÕES
    public function configuracao(Request $request){
        $id = $request->input('id');
        if($id != null){
            $restaurante = Restaurante::where('id' , $id)->first();
            $horarios = HorarioFuncionamento::where('restaurante_id' , $id)->get();
            return view('restaurante.configuracao', compact('restaurante', 'horarios'));
        }else{
            return view('restaurante.configuracao');
        }
    }

    //CADASTRAR
    public function store(Request $request, $usuario_id){
        // Validação do formulário
        $validator = Validator::make($request->all(), [
            //TODO: fazer validações
            'imagem' => 'required|image|mimes:jpeg,png,jpg|max:20480|dimensions:min-width=300,min-height=300',
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:500',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Cadastro de restaurante
        $restaurante = new Restaurante();

        //Informações Gerais
        $restaurante->nome = $request->input('nome');
        $restaurante->descricao = $request->input('descricao');
        $restaurante->cadastrado_usuario_id = $usuario_id;
        if ($request->hasFile('imagem')) {
            //Colocando nome único no arquivo
            $nomeArquivo = "logo";
            $request->file('imagem')->storeAs('public/'.$restaurante->nome, $nomeArquivo);
            $restaurante->logo = $nomeArquivo;
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
            $horario_funcionamento->restaurante_id = $restaurante->id;
            $horario_funcionamento->dia_semana = $i;
            $horario_funcionamento->hora_abertura = $request->input($i.'_abertura'); 
            $horario_funcionamento->hora_fechamento = $request->input($i.'_fechamento'); 
            $horario_funcionamento->save();

        }


        return redirect()->route('restaurante')->with('success', 'Cadastro feito com sucesso');
    }

    //ALTERAR
    public function update(Request $request, $usuario_id, $restaurante_id){
        
        // Validação do formulário
        $validator = Validator::make($request->all(), [
            //TODO: fazer validações
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:500',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Alterar restaurante
        $restaurante = Restaurante::where('id', $restaurante_id)->first();

        //Informações Gerais
        $restaurante->nome = $request->input('nome');
        $restaurante->descricao = $request->input('descricao');
        $restaurante->cadastrado_usuario_id = $usuario_id;

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
            $horario_funcionamento = HorarioFuncionamento::where('restaurante_id', $restaurante_id)->where('dia_semana', $i)->first();
            $horario_funcionamento->restaurante_id = $restaurante->id;
            $horario_funcionamento->dia_semana = $i;
            $horario_funcionamento->hora_abertura = $request->input($i.'_abertura'); 
            $horario_funcionamento->hora_fechamento = $request->input($i.'_fechamento'); 
            $horario_funcionamento->save();

        }


        return redirect()->route('restaurante')->with('success', 'Alteração feita com sucesso');
    }

    //ALTERAR LOGO
    public function update_logo(Request $request, $restaurante_id){
         // Validação do formulário
         $validator = Validator::make($request->all(), [
            //TODO: fazer validações
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:20480|dimensions:min-width=300,min-height=300',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }  
        
        //Alterar restaurante
        $restaurante = Restaurante::find($restaurante_id)->first();

        if ($request->hasFile('logo')) {
            //Colocando nome único no arquivo
            $nomeArquivo = "logo";
            $request->file('logo')->storeAs('public/logo', $nomeArquivo);
            $restaurante->logo = $nomeArquivo;
        }

        return redirect()->route('restaurante')->with('success', 'Logo alterada com sucesso');

    }

}