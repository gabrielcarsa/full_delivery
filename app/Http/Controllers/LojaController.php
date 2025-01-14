<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loja;
use App\Models\UserLoja;
use App\Models\HorarioFuncionamento;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class LojaController extends Controller
{
    //ESCOLHER RESTAURANTE GET
    public function index(){

        //Usuario
        $user_id = Auth::user()->id;

        //Obter IDs de Lojas relacionadas ao usuário
        $userLojas = UserLoja::where('user_id', $user_id)->get();

        $lojas = [];

        foreach($userLojas as $userLoja){
            $lojas[] = Loja::find($userLoja->loja_id);
        }

        return view('loja.escolher', compact('lojas'));
        
    }

    //ESCOLHER RESTAURANTE POST
    public function choose(Request $request){

        $id = $request->input('id');

        //Buscando loja
        $loja = Loja::where('id', $id)->get();

        //Definindo variavel de sessão de loja
        session(['lojaConectado' => ['id'=> $id, 'nome'=> $loja[0]->nome]]);

        return redirect()->back()->with('success', 'Conectado como '.session('lojaConectado')['nome']);

    }

    //EXIBIR
    public function show(Request $request){

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect()->route('loja.index')->with('error', 'Selecione uma loja primeiro');
        }

        //Info Loja
        $id = session('lojaConectado')['id'];
        $loja = Loja::where('id' , $id)->first();

        //Iniciar variáveis como vazias
        $horarios = null;
        $equipe = null;

        //Controle para exibir conteúdo das views da Loja
        $tab = $request->get('tab') ?? 'sobre';

        if($tab == 'horarios'){
            $horarios = HorarioFuncionamento::where('loja_id' , $id)->get();
        }elseif($tab == 'equipe'){
            $equipe = UserLoja::where('loja_id', $id)->get();
        }elseif($tab == 'planos'){
            //TODO
        }elseif($tab == 'integracoes'){
            //TODO
        }


        $dados = [
            'horarios' => $horarios,
            'equipe' => $equipe,
        ];
       
        return view('loja.show', compact('dados', 'loja'));

    }

    //CADASTRAR
    public function store(Request $request){

        //Limpando o campo telefone
        $request->merge([
            'telefone1' => str_replace(['(', '-', ')', ' '], '', $request->input('telefone1')),
            'telefone2' => str_replace(['(', '-', ')', ' '], '', $request->input('telefone2')),
        ]);

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'logo' => 'image|mimes:jpeg,png,jpg|max:20480|dimensions:min-width=300,min-height=300',
            'banner' => 'image|mimes:jpeg,png,jpg|max:20480|dimensions:min-width=800,min-height=400',
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:255',
            'taxa_servico' => 'required|numeric',
            'cep' => 'required|string|max:100',
            'rua' => 'required|string|max:100',
            'bairro' => 'required|string|max:100',
            'numero' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|max:100',
            'telefone1' => 'nullable|string|max:11',
            'telefone2' => 'nullable|string|max:11',
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
        $loja->telefone1 = $request->input('telefone1');
        $loja->telefone2 = $request->input('telefone2');
        $loja->area_entrega_metros = 5000; // valor padrão
        $loja->taxa_servico = $request->input('taxa_servico');
        $loja->is_taxa_entrega_free = true;
        $loja->cadastrado_usuario_id = $usuario_id;

        if ($request->hasFile('logo')) {
            //Colocando nome único no arquivo
            $nomeArquivo = "logo";
            $request->file('logo')->storeAs('public/'.$loja->nome, $nomeArquivo);
            $loja->logo = $nomeArquivo;
        }
        if ($request->hasFile('banner')) {
            //Colocando nome único no arquivo
            $nomeArquivo = "banner";
            $request->file('banner')->storeAs('public/'.$loja->nome, $nomeArquivo);
            //não estou salvando nome do arquino no BD pois só vai ter um banner
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
    public function update(Request $request){

        //Tab para verificar seleção do conteúdo
        $tab = $request->input('tab');

        $loja_id = $request->input('loja_id');

        //Salvando seção SOBRE
        if($tab == "sobre" || $tab == null){

            //Limpando o campo telefone
            $request->merge([
                'telefone1' => str_replace(['(', '-', ')', ' '], '', $request->input('telefone1')),
                'telefone2' => str_replace(['(', '-', ')', ' '], '', $request->input('telefone2')),
            ]);

            // Validação do formulário
            $validator = Validator::make($request->all(), [
                //'logo' => 'image|mimes:jpeg,png,jpg|max:20480|dimensions:min-width=300,min-height=300',
                //'banner' => 'image|mimes:jpeg,png,jpg|max:20480|dimensions:min-width=800,min-height=400',
                'nome' => 'required|string|max:100',
                'descricao' => 'required|string|max:250',
                'email' => 'nullable|email|max:100',
                'taxa_servico' => 'required|numeric',
                'cep' => 'required|string|max:20',
                'rua' => 'required|string|max:100',
                'bairro' => 'required|string|max:100',
                'numero' => 'required|string|max:100',
                'complemento' => 'required|string|max:100',
                'cidade' => 'required|string|max:100',
                'estado' => 'required|string|max:100',
                'telefone1' => 'nullable|string|max:11',
                'telefone2' => 'nullable|string|max:11',
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
            $loja->email = $request->input('email');
            $loja->alterado_usuario_id = Auth::user()->id;
            $loja->telefone1 = $request->input('telefone1');
            $loja->telefone2 = $request->input('telefone2');
            $loja->taxa_servico = $request->input('taxa_servico');

            //Endereço
            $loja->cep = $request->input('cep');
            $loja->rua = $request->input('rua');
            $loja->bairro = $request->input('bairro');
            $loja->numero = $request->input('numero');
            $loja->complemento = $request->input('complemento');
            $loja->cidade = $request->input('cidade');
            $loja->estado = $request->input('estado');
            $loja->save();

        }elseif($tab == "horarios"){
            
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
        }

        return redirect()->route('loja')->with('success', 'Alteração feita com sucesso');
    }

    //ALTERAR LOGO
    public function update_logo(Request $request, $loja_id){
        if ($request->hasFile('banner')) {
            //Colocando nome único no arquivo
            $nomeArquivo = "banner";
            $request->file('banner')->storeAs('public/'.$loja->nome, $nomeArquivo);
            //não estou salvando nome do arquino no BD pois só vai ter um banner
        }
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
            return redirect('loja.index')->with('error', 'Selecione um loja primeiro para visualizar as categorias e produtos');
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
            return redirect('loja.index')->with('error', 'Selecione um loja primeiro para visualizar as categorias e produtos');
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