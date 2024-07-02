<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loja;
use App\Models\HorarioFuncionamento;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class LojaController extends Controller
{
     //ESCOLHER RESTAURANTE
     public function choose(Request $request, $id){
        //Buscando loja
        $loja = Loja::where('id', $id)->get();

        //Definindo variavel de sessão de loja
        session(['lojaConectado' => ['id'=> $id, 'nome'=> $loja[0]->nome]]);

        return redirect()->route('loja')->with('success', 'Conectado como '.session('lojaConectado')['nome']);
    }

    //LISTAGEM
    public function index(){
        //dd(session('lojaConectado')['nome']);
        $lojas = Loja::all();
        $horarios_funcionamento = HorarioFuncionamento::all();
        return view('loja/listar', compact('lojas', 'horarios_funcionamento'));
    }

    //RETORNAR VIEW PARA CONFIGURAÇÕES
    public function configuracao(Request $request){
        $id = $request->input('id');
        if($id != null){
            $loja = Loja::where('id' , $id)->first();
            $horarios = HorarioFuncionamento::where('loja_id' , $id)->get();
            return view('loja.configuracao', compact('loja', 'horarios'));
        }else{
            return view('loja.configuracao');
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

        //Cadastro de loja
        $loja = new Loja();

        //Informações Gerais
        $loja->nome = $request->input('nome');
        $loja->descricao = $request->input('descricao');
        $loja->area_entrega_metros = 5000; // valor padrão
        $loja->is_taxa_entrega_free = true;
        $loja->cadastrado_usuario_id = $usuario_id;
        if ($request->hasFile('imagem')) {
            //Colocando nome único no arquivo
            $nomeArquivo = "logo";
            $request->file('imagem')->storeAs('public/'.$loja->nome, $nomeArquivo);
            $loja->logo = $nomeArquivo;
        }

        //Endereço
        $loja->cep = $request->input('cep');
        $loja->rua = $request->input('rua');
        $loja->bairro = $request->input('bairro');
        $loja->numero = $request->input('numero');
        $loja->complemento = $request->input('complemento');
        $loja->cidade = $request->input('cidade');
        $loja->estado = $request->input('estado');
        $loja->save();

        //Horario Funcionamento
        $i = 0;
        for($i; $i < 7; $i++){
            $horario_funcionamento = new HorarioFuncionamento();
            $horario_funcionamento->loja_id = $loja->id;
            $horario_funcionamento->dia_semana = $i;
            $horario_funcionamento->hora_abertura = $request->input($i.'_abertura'); 
            $horario_funcionamento->hora_fechamento = $request->input($i.'_fechamento'); 
            $horario_funcionamento->save();

        }


        return redirect()->route('loja')->with('success', 'Cadastro feito com sucesso');
    }

    //ALTERAR
    public function update(Request $request, $usuario_id, $loja_id){
        
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

        //Alterar loja
        $loja = Loja::where('id', $loja_id)->first();

        //Informações Gerais
        $loja->nome = $request->input('nome');
        $loja->descricao = $request->input('descricao');
        $loja->cadastrado_usuario_id = $usuario_id;

        //Endereço
        $loja->cep = $request->input('cep');
        $loja->rua = $request->input('rua');
        $loja->bairro = $request->input('bairro');
        $loja->numero = $request->input('numero');
        $loja->complemento = $request->input('complemento');
        $loja->cidade = $request->input('cidade');
        $loja->estado = $request->input('estado');
        $loja->save();

        //Horario Funcionamento
        $i = 0;
        for($i; $i < 7; $i++){
            $horario_funcionamento = HorarioFuncionamento::where('loja_id', $loja_id)->where('dia_semana', $i)->first();
            $horario_funcionamento->loja_id = $loja->id;
            $horario_funcionamento->dia_semana = $i;
            $horario_funcionamento->hora_abertura = $request->input($i.'_abertura'); 
            $horario_funcionamento->hora_fechamento = $request->input($i.'_fechamento'); 
            $horario_funcionamento->save();

        }


        return redirect()->route('loja')->with('success', 'Alteração feita com sucesso');
    }

    //ALTERAR LOGO
    public function update_logo(Request $request, $loja_id){
         // Validação do formulário
         $validator = Validator::make($request->all(), [
            //TODO: fazer validações
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:20480|dimensions:min-width=300,min-height=300',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }  
        
        //Alterar loja
        $loja = Loja::find($loja_id)->first();

        if ($request->hasFile('logo')) {
            //Colocando nome único no arquivo
            $nomeArquivo = "logo";
            $request->file('logo')->storeAs('public/logo', $nomeArquivo);
            $loja->logo = $nomeArquivo;
        }

        return redirect()->route('loja')->with('success', 'Logo alterada com sucesso');

    }

    //LISTAGEM ENTREGAS TAXAS
    public function show_entrega_taxas(){
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar as categorias e produtos');
        }

        //Dados do loja
        $id = session('lojaConectado')['id'];
        $loja = Loja::where('id', $id)->first();

        return view('loja/entrega_taxas', compact('loja'));    
    }

    //DEFINIR TAXA DE ENTREGA FREE  
    public function taxa_entrega_free(Request $request){
        $id = $request->input('id');

        //Alterando
        $loja = Loja::find($id);
        $loja->taxa_por_km_entrega = null; 
        $loja->is_taxa_entrega_free = true; 
        $loja->taxa_entrega_fixa = null; 
        $loja->save();

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
        $loja = Loja::find($id);
        $loja->taxa_por_km_entrega = (double) $request->input('taxa_por_km_entrega'); 
        $loja->is_taxa_entrega_free = false; 
        $loja->taxa_entrega_fixa = null; 
        $loja->save();

        return redirect()->back()->with('success', 'Definido taxa de entrega por km');
    }

    //DEFINIR TAXA DE ENTREGA FIXA  
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
        $loja = Loja::find($id);
        $loja->taxa_por_km_entrega = null; 
        $loja->is_taxa_entrega_free = false; 
        $loja->taxa_entrega_fixa = (double) $request->input('taxa_entrega_fixa'); 
        $loja->save();

        return redirect()->back()->with('success', 'Definido taxa de entrega fixa');
    }

     //LISTAGEM ENTREGAS AREAS
     public function show_entrega_areas(){
        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar as categorias e produtos');
        }

        //Dados do loja
        $id = session('lojaConectado')['id'];
        $loja = Loja::where('id', $id)->first();

        //API KEY
        $apiKey = 'AIzaSyCrR7RmCs0UkChkfbOJSoOUQ7kf9i-gcsk';
        $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json?address={$loja->cep}&key={$apiKey}");
        $data = $response->json();

        if ($data['status'] == 'OK') {
            $location = $data['results'][0]['geometry']['location'];
            $latitude = $location['lat'];
            $longitude = $location['lng'];

            $data_maps = [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'cep' => $loja->cep,
            ];

            return view('loja/entrega_areas', compact('loja', 'data_maps'));
        } else {
            return "CEP não encontrado.";
        }
    }

     //DEFINIR AREA DE ENTREGA POR METROS
     public function area_entrega_metros(Request $request){
        $id = $request->input('id');
            
        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'area_entrega_metros' => 'required|numeric',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Alterando
        $loja = Loja::find($id);
        $loja->area_entrega_metros = $request->input('area_entrega_metros'); 
        $loja->save();

        return redirect()->back()->with('success', 'Definido área em metros');
    }

}