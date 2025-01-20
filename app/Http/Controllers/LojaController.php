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
use App\Services\IfoodService;

class LojaController extends Controller
{
    protected $ifoodService;

    public function __construct()
    {
        //instanciando
        $this->ifoodService = new IfoodService();
    }

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
        $loja = Loja::find($id);

        if($loja != null){
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

        // Esquecer sessão da Loja Conectada
        session()->forget('lojaConectado');

        return redirect()->route('loja.create')->with('error', 'Nenhuma loja encontrada cadastre uma loja primeiramente.');

    }

    //VIEW PARA CADASTRAR LOJA
    public function create(Request $request){

        $step = $request->get('step');
        $loja_id = $request->get('loja_id');

        $loja = null;
        
        //Verificando se Step é maior que 1
        if($step != null && $step > 1){
            $loja = Loja::find($loja_id);
        }
        return view('loja.create', compact('loja'));
    }

    //CADASTRAR
    public function store(Request $request){

        //Step
        $step = $request->get('step') ?? 1;

        if($step == 1){

             //Limpando o campo telefone
             $request->merge([
                'cpf' => str_replace(['.', '-', ' '], '', $request->input('cpf')),
                'cnpj' => str_replace(['.', '-', '/', ' '], '', $request->input('cnpj')),
            ]);

            // Validação do formulário
            $validator = Validator::make($request->all(), [
                'nome' => 'required|string|max:100',
                'descricao' => 'nullable|string|max:250',
                'documento' => 'required',
                'cnpj' => $request->input('documento') == 'cnpj' ? 'required|string|max:14' : 'nullable',
                'cpf' => $request->input('documento') == 'cpf' ? 'required|string|max:11' : 'nullable',
                'tipo' => 'required|not_in:- Selecione uma opção -',
                'faturamento_mensal' => 'required|not_in:- Selecione uma opção -',
            ]/*,[
                'faturamento_mensal.required' => 'Por favor, selecione uma opção.',
                'faturamento_mensal.not_in' => 'A opção selecionada é inválida.',
            ]*/);

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
            $loja->cadastrado_usuario_id = Auth::user()->id;
            $loja->tipo = $request->input('tipo');
            $loja->faturamento_mensal = $request->input('faturamento_mensal');
            $loja->cpf = $request->input('documento') == 'cpf' ? $request->input('cpf') : NULL;
            $loja->cnpj = $request->input('documento') == 'cnpj' ? $request->input('cnpj') : NULL;
            $loja->save();

            //Vinculando usuário a loja
            UserLoja::create([
                'user_id' => Auth::user()->id,
                'loja_id' => $loja->id,
                'nivel_acesso' => 'ADMIN',
                'cargo' => 'DONO',
                'cadastrado_usuario_id' => Auth::user()->id,
            ]);

            $step = 2;

            return redirect()->route('loja.create', ['step' => $step, 'loja_id' => $loja->id]);

        }elseif($step == 2){

            $loja_id = $request->input('loja_id');

            //Limpando o campo telefone
            $request->merge([
                'telefone1' => str_replace(['(', '-', ')', ' '], '', $request->input('telefone1')),
                'telefone2' => str_replace(['(', '-', ')', ' '], '', $request->input('telefone2')),
            ]);

            // Validação do formulário
            $validator = Validator::make($request->all(), [
                'telefone1' => 'nullable|string|max:11',
                'telefone2' => 'nullable|string|max:11',
                'email' => 'nullable|string|max:100',
            ]);

            // Se a validação falhar
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $loja = Loja::find($loja_id);
            $loja->email = $request->input('email');
            $loja->alterado_usuario_id = Auth::user()->id;
            $loja->telefone1 = $request->input('telefone1');
            $loja->telefone2 = $request->input('telefone2');
            $loja->save();

            $step = 3;

            return redirect()->route('loja.create', ['step' => $step, 'loja_id' => $loja->id]);

        }elseif($step == 3){

            $loja_id = $request->input('loja_id');

            //Limpando os campos
            $request->merge([
                'cep' => str_replace(['-', ' '], '', $request->input('cep')),
            ]);

            // Validação do formulário
            $validator = Validator::make($request->all(), [
                'cep' => 'required|string|max:8',
                'rua' => 'required|string|max:100',
                'bairro' => 'required|string|max:100',
                'cidade' => 'required|string|max:100',
                'estado' => 'required|string|max:100',
                'numero' => 'required|string|max:20',
                'complemento' => 'nullable|string|max:100',
            ]);

            // Se a validação falhar
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $loja = Loja::find($loja_id);
            $loja->cep = $request->input('cep');
            $loja->rua = $request->input('rua');
            $loja->bairro = $request->input('bairro');
            $loja->cidade = $request->input('cidade');
            $loja->estado = $request->input('estado');
            $loja->numero = $request->input('numero');
            $loja->complemento = $request->input('complemento');
            $loja->alterado_usuario_id = Auth::user()->id;
            $loja->save();

            $step = 4;

            return redirect()->route('loja.create', ['step' => $step, 'loja_id' => $loja->id]);

        }elseif($step == 4){

            $loja_id = $request->input('loja_id');

            $request->merge([
                'taxa_por_km_entrega' => str_replace(['.', ','], ['', '.'], $request->input('taxa_por_km_entrega')),
                'taxa_entrega_fixa' => str_replace(['.', ','], ['', '.'], $request->input('taxa_entrega_fixa')),
            ]);

            // Validação do formulário
            $validator = Validator::make($request->all(), [
                'taxa_entrega' => 'required',
                'taxa_entrega_fixa' => $request->input('taxa_entrega') == "FIXA" ? 'required|numeric' : 'nullable',
                'taxa_por_km_entrega' => $request->input('taxa_entrega') == "KM" ? 'required|numeric' : 'nullable',
                'taxa_servico' => 'required',
            ]);

            // Se a validação falhar
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $loja = Loja::find($loja_id);
            $loja->taxa_entrega_fixa = $request->input('taxa_entrega') == "FIXA" ? $request->input('taxa_entrega_fixa') : NULL;
            $loja->taxa_por_km_entrega = $request->input('taxa_entrega') == "KM" ? $request->input('taxa_por_km_entrega') : NULL;
            $loja->is_taxa_entrega_free = $request->input('taxa_entrega') == "GRATUITA" ? true : NULL;
            $loja->taxa_servico = $request->input('taxa_servico');
            $loja->alterado_usuario_id = Auth::user()->id;
            $loja->save();

            //Definindo variavel de sessão de loja
            session(['lojaConectado' => ['id'=> $loja->id, 'nome'=> $loja->nome]]);

            return redirect()->route('loja',['tab' => 'planos'])->with('success', 'Cadastro da loja concluído com sucesso');

        }else{
            return redirect()->back()->with('error', 'Não autorizado');
        }
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
                'complemento' => 'nullable|string|max:100',
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
    public function update_logo(Request $request){

        $loja_id = $request->input('loja_id');

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
        $loja = Loja::find($loja_id);

        if ($request->hasFile('logo')) {
            //Colocando nome único no arquivo
            $nomeArquivo = "logo";
            $request->file('logo')->storeAs('public/'.$loja->nome, $nomeArquivo);
            $loja->logo = $nomeArquivo;
        }

        return redirect()->route('loja')->with('success', 'Logo alterada com sucesso');
    }

    //ALTERAR LOGO
    public function update_banner(Request $request){

        $loja_id = $request->input('loja_id');

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            //TODO: fazer validações
            'banner' => 'required|image|mimes:jpeg,png,jpg|max:20480|dimensions:min_width=1280,min_height=720,ratio=16/9',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }  
        
        //Alterar loja
        $loja = Loja::find($loja_id);

        if ($request->hasFile('banner')) {
            //Colocando nome único no arquivo
            $nomeArquivo = "banner";
            $request->file('banner')->storeAs('public/'.$loja->nome, $nomeArquivo);
            //não estou salvando nome do arquino no BD pois só vai ter um banner
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


    //RETORNA VIEW PARA INTEGRAR COM IFOOD
    public function create_integration_ifood(Request $request){

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect()->route('loja.index')->with('error', 'Selecione uma loja primeiro');
        }

        //Info Loja
        $id = session('lojaConectado')['id'];
        $loja = Loja::find($id);

        $userCode = null;
        $step = $request->get('step') ?? 1;


        if($loja != null){

            if($step == 1){

                //Obter UserCode
                $userCode = $this->ifoodService->getUserCode();

            }
            return view('loja.integration_ifood', compact('userCode'));
        }
    }

    //SALVAR INTEGRAÇÃO IFOOD
    public function store_integration_ifood(Request $request){

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect()->route('loja.index')->with('error', 'Selecione uma loja primeiro');
        }

        //Step
        $step = $request->get('step') ?? 1;

        if($step == 1){

            $step = 2;
            $authorization_code_verifier = $request->input('authorization_code_verifier');

            return redirect()->route('loja.create_integration_ifood', ['step' => $step, 'authorization_code_verifier' => $authorization_code_verifier]);

        }elseif($step == 2){

            // Validação do formulário
            $validator = Validator::make($request->all(), [
                'authorization_code' => 'required|max:9',
            ]);

            // Se a validação falhar
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            //Variáveis necessárias para obter access token
            $authorization_code = $request->input('authorization_code');
            $authorization_code_verifier = $request->input('authorization_code_verifier');

            //Requisitando AccessToken
            $this->ifoodService->postAccessToken($authorization_code, $authorization_code_verifier);

            return redirect()->route('loja',['tab' => 'integracoes'])->with('success', 'Integração feita com sucesso!');

        }else{
            return redirect()->back()->with('error', 'Não autorizado');
        }
    }

}