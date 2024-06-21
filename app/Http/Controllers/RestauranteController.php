<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurante;
use App\Models\HorarioFuncionamento;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RestauranteController extends Controller
{
     //ESCOLHER RESTAURANTE
     public function choose(Request $request, $id){
        //Buscando restaurante
        $restaurante = Restaurante::where('id', $id)->get();

        //Definindo variavel de sessão de restaurante
        session(['restauranteConectado' => ['id'=> $id, 'nome'=> $restaurante[0]->nome]]);

        return redirect()->route('restaurante')->with('success', 'Conectado como '.session('restauranteConectado')['nome']);
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
            'imagem' => 'required|image|mimes:jpeg,png,jpg|max:20480|dimensions:min-width=300,min-height=300',
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:500',
            'cep' => 'required|string|max:100',
            'rua' => 'required|string|max:100',
            'bairro' => 'required|string|max:500',
            'numero' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|max:100',
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
        $restaurante->is_taxa_entrega_free = true;
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
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:500',
            'cep' => 'required|string|max:100',
            'rua' => 'required|string|max:100',
            'bairro' => 'required|string|max:500',
            'numero' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|max:100',
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

    //LISTAGEM
    public function show_entrega(){
        //Verificar se há restaurante selecionado
        if(!session('restauranteConectado')){
            return redirect('restaurante')->with('error', 'Selecione um restaurante primeiro para visualizar as categorias e produtos');
        }

        //Dados do restaurante
        $id = session('restauranteConectado')['id'];
        $restaurante = Restaurante::where('id', $id)->first();

        //API KEY
        $apiKey = 'AIzaSyCrR7RmCs0UkChkfbOJSoOUQ7kf9i-gcsk';
        $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json?address={$restaurante->cep}&key={$apiKey}");
        $data = $response->json();

        if ($data['status'] == 'OK') {
            $location = $data['results'][0]['geometry']['location'];
            $latitude = $location['lat'];
            $longitude = $location['lng'];

            $data_maps = [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'cep' => $restaurante->cep,
            ];

            return view('restaurante/entrega', compact('restaurante', 'data_maps'));
        } else {
            return "CEP não encontrado.";
        }
    }

    //DEFINIR TAXA DE ENTREGA FREE  
    public function taxa_entrega_free(Request $request){
        $id = $request->input('id');

        //Alterando
        $restaurante = Restaurante::find($id);
        $restaurante->taxa_por_km_entrega = null; 
        $restaurante->is_taxa_entrega_free = true; 
        $restaurante->taxa_entrega_fixa = null; 
        $restaurante->save();

        return redirect()->back()->with('success', 'Definido taxa de entrega gratuita');
    }

    //DEFINIR TAXA DE ENTREGA POR KM  
    public function taxa_por_km_entrega(Request $request){
        $id = $request->input('id');

        $request->merge([
            'taxa_por_km_entrega' => str_replace(['.', ','], ['', '.'], $request->input('taxa_por_km_entrega')),
        ]);

            
        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'taxa_por_km_entrega' => 'required|numeric',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Alterando
        $restaurante = Restaurante::find($id);
        $restaurante->taxa_por_km_entrega = (double) $request->input('taxa_por_km_entrega'); 
        $restaurante->is_taxa_entrega_free = false; 
        $restaurante->taxa_entrega_fixa = null; 
        $restaurante->save();

        return redirect()->back()->with('success', 'Definido taxa de entrega por km');
    }

    //DEFINIR TAXA DE ENTREGA POR KM  
    public function taxa_entrega_fixa(Request $request){
        $id = $request->input('id');

        $request->merge([
            'taxa_entrega_fixa' => str_replace(['.', ','], ['', '.'], $request->input('taxa_entrega_fixa')),
        ]);
            
        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'taxa_entrega_fixa' => 'required|numeric',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Alterando
        $restaurante = Restaurante::find($id);
        $restaurante->taxa_por_km_entrega = null; 
        $restaurante->is_taxa_entrega_free = false; 
        $restaurante->taxa_entrega_fixa = (double) $request->input('taxa_entrega_fixa'); 
        $restaurante->save();

        return redirect()->back()->with('success', 'Definido taxa de entrega fixa');
    }

}