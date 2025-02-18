<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stores;
use App\Models\StoreUsers;
use App\Models\StoreOpeningHours;
use App\Models\FinancialCategories;
use App\Models\Customers;
use App\Models\StoreDeliveries;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Services\IfoodService;
use App\Models\IfoodTokens;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class StoresController extends Controller
{
    protected $ifoodService;

    public function __construct()
    {
        //instanciando
        $this->ifoodService = new IfoodService();
    }

    //ESCOLHER RESTAURANTE
    public function index(){

        //Usuario
        $user_id = Auth::user()->id;

        //Obter IDs de Storess relacionadas ao usuário
        $storeUsers = StoreUsers::where('user_id', $user_id)->get();

        $stores = [];

        foreach($storeUsers as $storeUser){
            $stores[] = Stores::find($storeUser->store_id);
        }

        return view('stores.index', compact('stores'));
        
    }

    //ESCOLHER RESTAURANTE POST
    public function select(Request $request){

        $id = $request->input('id');

        //Buscando store
        $store = Stores::where('id', $id)->get();

        //Definindo variavel de sessão de store
        session(['selected_store' => ['id'=> $id, 'name'=> $store[0]->name]]);

        return redirect()->back()->with('success', 'Conectado como '.session('selected_store')['name']);

    }

    //EXIBIR
    public function show(Request $request){

        if(!session('selected_store')){
            return redirect()->route('stores.index')->with('error', 'Selecione uma loja!');
        }

        //Info Stores
        $id = session('selected_store')['id'];
        $store = Stores::find($id);

        if($store != null){
            //Iniciar variáveis como vazias
            $horarios = null;
            $equipe = null;
            $token = null;
            $dataUri = null;
            $events = null;
            $storeHours = null;

            //Controle para exibir conteúdo das views da Stores
            $tab = $request->get('tab') ?? 'sobre';

            if($tab == 'sobre'){

                // Link para cardápio
                $link = url('/');
                
                $builder = new Builder(
                    writer: new PngWriter(),
                    writerOptions: [],
                    validateResult: false,
                    data: $link.'?id='.$store->id,
                    encoding: new Encoding('UTF-8'),
                    errorCorrectionLevel: ErrorCorrectionLevel::High,
                    size: 300,
                    margin: 10,
                    roundBlockSizeMode: RoundBlockSizeMode::Margin,
                    logoResizeToWidth: 50,
                    logoPunchoutBackground: true,
                    labelText: $store->name,
                    labelFont: new OpenSans(20),
                    labelAlignment: LabelAlignment::Center
                );

                $result = $builder->build();
                
                // Gerando URL para exibir img
                $dataUri = $result->getDataUri();


            }elseif($tab == 'horarios'){

                $storeHours = StoreOpeningHours::where('store_id' , $id)->get();

                $dayMapping = [
                    "SUNDAY" => 0,
                    "MONDAY" => 1,
                    "TUESDAY" => 2,
                    "WEDNESDAY" => 3,
                    "THURSDAY" => 4,
                    "FRIDAY" => 5,
                    "SATURDAY" => 6
                ];

                // Criando eventos recorrentes
                $events = [];
                foreach ($storeHours as $schedule) {
                    $dayNumber = $dayMapping[$schedule["day_of_week"]] ?? null;
                    if ($dayNumber !== null) {
                        $events[] = [
                            "id" => $schedule["id"],
                            "daysOfWeek" => [$dayNumber], // Define o dia da semana
                            "startTime" => $schedule["opening_time"], // Horário de abertura
                            "endTime" => $schedule["closing_time"] // Horário de fechamento
                        ];
                    }
                }
                
            }elseif($tab == 'equipe'){

                $name_email_store_user = $request->input('name_email_store_user');
                
                // if request have filter
                if($name_email_store_user == null){
                    $equipe = StoreUsers::where('store_id', $id)->paginate(10)->appends(['tab' => $tab]); 
                }else{
                    $equipe = StoreUsers::where('store_id', $id)
                    ->whereHas('user', function ($query) use ($name_email_store_user) {
                        $query->where('name', 'like', "%$name_email_store_user%")
                            ->orWhere('email', 'like', "%$name_email_store_user%");
                    })
                    ->paginate(10)
                    ->appends(['tab' => $tab]);
                }
                
            }elseif($tab == 'planos'){
                //TODO
            }elseif($tab == 'integracoes'){

                // Obtém token mais recente
                $token = IfoodTokens::where('store_id', $id)->latest()->first();
            }

            $dados = [
                'storeHours' => $storeHours,
                'equipe' => $equipe,
                'token' => $token,
                'dataUri' => $dataUri,
                'events' => json_encode($events),
            ];
        
            return view('stores.show', compact('dados', 'store'));
        }

        // Esquecer sessão da Stores Conectada
        session()->forget('selected_store');

        return redirect()->route('stores.create')->with('error', 'Nenhuma store encontrada cadastre uma store primeiramente.');

    }

    //VIEW PARA CADASTRAR LOJA
    public function create(Request $request){

        $step = $request->get('step');
        $store_id = $request->get('store_id');

        $store = null;
        
        //Verificando se Step é maior que 1
        if($step != null && $step > 1){
            $store = Stores::find($store_id);
        }
        return view('stores.create', compact('store'));
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

            //Cadastro de store
            $store = new Stores();

            //Informações Gerais
            $store->name = $request->input('nome');
            $store->description = $request->input('descricao');
            $store->created_by_user_id = Auth::user()->id;
            $store->type = $request->input('tipo');
            $store->monthly_billing = $request->input('faturamento_mensal');
            $store->cpf = $request->input('documento') == 'cpf' ? $request->input('cpf') : NULL;
            $store->cnpj = $request->input('documento') == 'cnpj' ? $request->input('cnpj') : NULL;
            $store->save();

            //Vinculando usuário a store
            StoreUsers::create([
                'user_id' => Auth::user()->id,
                'store_id' => $store->id,
                'access_level' => 'ADMIN',
                'position' => 'DONO',
                'created_by_user_id' => Auth::user()->id,
                'is_active' => true,
            ]);

            //Criando categoria do financeiro de entrada de pedido
            FinancialCategories::create([
                'type' => 1,
                'name' => 'PEDIDOS',
                'created_by_user_id' => Auth::guard()->user()->id,
                'store_id' => $store->id,
                'is_default' => true,
            ]);

            //Criando cliente para receber pedidos quando cliente não é cadastrado
            Customers::create([
                'name' => 'CLIENTE SEM CADASTRO',
                'cpf' => '00000000000',
                'email' => 'sem_cadastro@foomy.com',
                'phone' => '67999999999',
                'store_id' => $store->id,
                'is_default_customer' => true,
            ]);

            $step = 2;

            return redirect()->route('stores.create', ['step' => $step, 'store_id' => $store->id]);

        }elseif($step == 2){

            $store_id = $request->input('store_id');

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

            $store = Stores::find($store_id);
            $store->email = $request->input('email');
            $store->updated_by_user_id = Auth::user()->id;
            $store->phone1 = $request->input('telefone1');
            $store->phone2 = $request->input('telefone2');
            $store->save();

            $step = 3;

            return redirect()->route('stores.create', ['step' => $step, 'store_id' => $store->id]);

        }elseif($step == 3){

            $store_id = $request->input('store_id');

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

            $store = Stores::find($store_id);
            $store->zip_code = $request->input('cep');
            $store->street = $request->input('rua');
            $store->neighborhood = $request->input('bairro');
            $store->city = $request->input('cidade');
            $store->state = $request->input('estado');
            $store->number = $request->input('numero');
            $store->complement = $request->input('complemento');
            $store->updated_by_user_id = Auth::user()->id;
            $store->save();

            $step = 4;

            return redirect()->route('stores.create', ['step' => $step, 'store_id' => $store->id]);

        }elseif($step == 4){

            $store_id = $request->input('store_id');

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

            StoreDeliveries::create([
                'store_id' => $store_id,
                'is_free_delivery' => $request->input('taxa_entrega') == "GRATUITA" ? true : NULL,
                'delivery_fee_per_km' => $request->input('taxa_entrega') == "KM" ? $request->input('taxa_por_km_entrega') : NULL,
                'delivery_fee' => $request->input('taxa_entrega') == "FIXA" ? $request->input('taxa_entrega_fixa') : NULL,
            ]);

            $store = Stores::find($store_id);
            $store->service_fee = $request->input('taxa_servico');
            $store->updated_by_user_id = Auth::user()->id;
            $store->save();

            //Definindo variavel de sessão de store
            session(['selected_store' => ['id'=> $store->id, 'name'=> $store->name]]);

            return redirect()->route('stores.show',['store' => $store->id,'tab' => 'planos'])->with('success', 'Cadastro da loja concluído com sucesso');

        }else{
            return redirect()->back()->with('error', 'Não autorizado');
        }
    }

    //ALTERAR
    public function update(Request $request, Stores $store){

        //Tab para verificar seleção do conteúdo
        $tab = $request->input('tab');

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
                'descricao' => 'nullable|string|max:250',
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

            //Informações Gerais
            $store->name = $request->input('nome');
            $store->description = $request->input('descricao');
            $store->email = $request->input('email');
            $store->updated_by_user_id = Auth::user()->id;
            $store->phone1 = $request->input('telefone1');
            $store->phone2 = $request->input('telefone2');
            $store->service_fee = $request->input('taxa_servico');

            //Endereço
            $store->zip_code = $request->input('cep');
            $store->street = $request->input('rua');
            $store->neighborhood = $request->input('bairro');
            $store->number = $request->input('numero');
            $store->complement = $request->input('complemento');
            $store->city = $request->input('cidade');
            $store->state = $request->input('estado');
            $store->save();

        }

        return redirect()->back()->with('success', 'Alteração feita com sucesso');
    }

    //ALTERAR LOGO
    public function update_logo(Request $request){

        $store_id = $request->input('store_id');

        if ($request->hasFile('banner')) {
            //Colocando nome único no arquivo
            $nomeArquivo = "banner";
            $request->file('banner')->storeAs('public/'.$store->nome, $nomeArquivo);
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
        
        //Alterar store
        $store = Stores::find($store_id);

        if ($request->hasFile('logo')) {
            //Colocando nome único no arquivo
            $nomeArquivo = "logo";
            $request->file('logo')->storeAs('public/'.$store->nome, $nomeArquivo);
            $store->logo = $nomeArquivo;
        }

        return redirect()->route('store')->with('success', 'Logo alterada com sucesso');
    }

    //ALTERAR LOGO
    public function update_banner(Request $request){

        $store_id = $request->input('store_id');

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            //TODO: fazer validações
            'banner' => 'required|image|mimes:jpeg,png,jpg|max:20480|dimensions:min_width=1280,min_height=720,ratio=16/9',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }  
        
        //Alterar store
        $store = Stores::find($store_id);

        if ($request->hasFile('banner')) {
            //Colocando nome único no arquivo
            $nomeArquivo = "banner";
            $request->file('banner')->storeAs('public/'.$store->nome, $nomeArquivo);
            //não estou salvando nome do arquino no BD pois só vai ter um banner
        }

        return redirect()->route('store')->with('success', 'Logo alterada com sucesso');

    }

    //LISTAGEM ENTREGAS TAXAS
    public function show_entrega_taxas(){
        //Verificar se há store selecionado
        if(!session('selected_store')){
            return redirect()->route('stores.index')->with('error', 'Selecione um store primeiro para visualizar as categorias e produtos');
        }

        //Dados do store
        $id = session('selected_store')['id'];
        $store = Stores::where('id', $id)->first();

        return view('store/entrega_taxas', compact('store'));    
    }

    //DEFINIR TAXA DE ENTREGA FREE  
    public function taxa_entrega_free(Request $request){
        $id = $request->input('id');

        //Alterando
        $store = Stores::find($id);
        $store->taxa_por_km_entrega = null; 
        $store->is_taxa_entrega_free = true; 
        $store->taxa_entrega_fixa = null; 
        $store->save();

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
        $store = Stores::find($id);
        $store->taxa_por_km_entrega = (double) $request->input('taxa_por_km_entrega'); 
        $store->is_taxa_entrega_free = false; 
        $store->taxa_entrega_fixa = null; 
        $store->save();

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
        $store = Stores::find($id);
        $store->taxa_por_km_entrega = null; 
        $store->is_taxa_entrega_free = false; 
        $store->taxa_entrega_fixa = (double) $request->input('taxa_entrega_fixa'); 
        $store->save();

        return redirect()->back()->with('success', 'Definido taxa de entrega fixa');
    }

     //LISTAGEM ENTREGAS AREAS
     public function show_entrega_areas(){
        //Verificar se há store selecionado
        if(!session('selected_store')){
            return redirect()->route('stores.index')->with('error', 'Selecione um store primeiro para visualizar as categorias e produtos');
        }

        //Dados do store
        $id = session('selected_store')['id'];
        $store = Stores::where('id', $id)->first();

        //API KEY
        $apiKey = 'AIzaSyCrR7RmCs0UkChkfbOJSoOUQ7kf9i-gcsk';
        $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json?address={$store->cep}&key={$apiKey}");
        $data = $response->json();

        if ($data['status'] == 'OK') {
            $location = $data['results'][0]['geometry']['location'];
            $latitude = $location['lat'];
            $longitude = $location['lng'];

            $data_maps = [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'cep' => $store->cep,
            ];

            return view('store/entrega_areas', compact('store', 'data_maps'));
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
        $store = Stores::find($id);
        $store->area_entrega_metros = $request->input('area_entrega_metros'); 
        $store->save();

        return redirect()->back()->with('success', 'Definido área em metros');
    }


    //RETORNA VIEW PARA INTEGRAR COM IFOOD
    public function create_integration_ifood(Request $request){

        //Verificar se há store selecionado
        if(!session('selected_store')){
            return redirect()->route('stores.index')->with('error', 'Selecione uma store primeiro');
        }

        //Info Stores
        $id = session('selected_store')['id'];
        $store = Stores::find($id);

        $userCode = null;
        $step = $request->get('step') ?? 1;


        if($store != null){

            if($step == 1){

                //Obter UserCode
                $userCode = $this->ifoodService->getUserCode();

            }
            return view('stores.integration_ifood', compact('userCode'));
        }
    }

    //SALVAR INTEGRAÇÃO IFOOD
    public function store_integration_ifood(Request $request){

        //Verificar se há store selecionado
        if(!session('selected_store')){
            return redirect()->route('stores.index')->with('error', 'Selecione uma loja primeiro');
        }

        //Step
        $step = $request->get('step') ?? 1;

        if($step == 1){

            $step = 2;
            $authorization_code_verifier = $request->input('authorization_code_verifier');

            return redirect()->route('stores.create_integration_ifood', ['step' => $step, 'authorization_code_verifier' => $authorization_code_verifier]);

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

            try{

                //Requisitando AccessToken
                $this->ifoodService->postAccessToken($authorization_code, $authorization_code_verifier);

            }catch (\Exception $e) {
                //dd($e);
                return redirect()->back()->with('error', 'Código inválido ou tempo expirado. Tente novamente!');
            }

            //Obtendo ID do Merchant do Ifood
            $merchantIfood = $this->ifoodService->getMerchants();

            //Salvar na Stores
            $id = session('selected_store')['id'];
            $store = Stores::find($id);
            $store->ifood_merchant_id = $merchantIfood[0]['id'];
            $store->save();

            return redirect()->route('stores.show',['store' => $store->id, 'tab' => 'integracoes'])->with('success', 'Integração feita com sucesso!');

        }else{
            return redirect()->back()->with('error', 'Não autorizado');
        }
    }

}