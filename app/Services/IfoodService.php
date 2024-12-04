<?php

namespace App\Services;

use App\Models\IfoodToken;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Loja;

class IfoodService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    //Obter Loja Conectada
    private function getIdlojaConectada(){

        //Verificar se há loja selecionado
        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro');
        }
        //ID loja
        $loja_id  = session('lojaConectado')['id'];

        return $loja_id;
    }

    //Obter código do iFood Merchant
    public function getMerchantIdFoomy(){
        
        $ifoodService = new IfoodService();
        $loja_id = $ifoodService->getIdlojaConectada();

        //Obter código do MERCHANT
        $loja = Loja::find($loja_id);

        return $loja->ifood_merchant_id;
    }

    //Obter AccessToken
    public function getAccessToken()
    {
        // Obtém token mais recente
        $token = IfoodToken::latest()->first();

        if ($token && $token->expires_at->isFuture()) {
            return $token->access_token;
        }

        return $this->refreshAccessToken();
    }

    //Atualizar AccessToken
    public function refreshAccessToken()
    {
        //Obter Loja ID
        $ifoodService = new IfoodService();
        $loja_id = $ifoodService->getIdlojaConectada();
        
        // Obtém token mais recente
        $token = IfoodToken::where('loja_id', $loja_id)->latest()->first();

        if($token != null){
            $response = $this->client->post('https://merchant-api.ifood.com.br/authentication/v1.0/oauth/token', [
                'form_params' => [
                    'grantType' => 'refresh_token',
                    'clientId' => env('IFOOD_CLIENT_ID'),
                    'clientSecret' => env('IFOOD_CLIENT_SECRET'),
                    'authorizationCode' => 'RSLD-LDPV',
                    'authorizationCodeVerifier' => 'ml6xrrvn42i6x3kfuwp4dnvknqmx14pict8uc3xocofjsfhyhkv76tmymh3bsknhtgbxunjjonxjvxtfoixyb40fm5ieut21wg',
                    'refreshToken' => $token->refresh_token,
                ]
            ]);
        }else{
            //Para instalar pela primeira vez o token
            $response = $this->client->post('https://merchant-api.ifood.com.br/authentication/v1.0/oauth/token', [
                'form_params' => [
                    'grantType' => 'authorization_code',
                    'clientId' => env('IFOOD_CLIENT_ID'),
                    'clientSecret' => env('IFOOD_CLIENT_SECRET'),
                    'authorizationCode' => 'FKSD-ZFML',
                    'authorizationCodeVerifier' => 'kaui9ii32ve1qd5uogrglzecypsu1796h2e3umgcouv70ofkrc0to20yankl4ypgv0mi7w8nxfcdwa1y568x2tho5y4k5zh3xrk',
                    //'refreshToken' => 'eyJraWQiOiJlZGI4NWY2Mi00ZWY5LTExZTktODY0Ny1kNjYzYmQ4NzNkOTMiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzUxMiJ9.eyJzdWIiOiIxNzllYjE5MC1iYjA1LTQzMmMtYTc1ZS1kNDQ2N2UzMjhiYmEiLCJpc3MiOiJpRm9vZCIsImV4cCI6MTcyOTAwMDE5NiwiaWF0IjoxNzI4Mzk1Mzk2LCJjbGllbnRfaWQiOiIyMWI3YTEwZi1mZDAwLTQ4MWUtOTU0My05NjRmN2UwYzUzNDEifQ.ai9wRmy1oL_SM4XwOM8EI9OtY9Rsd-DTGDMa3y-KMC6sgKRKtMhUy5bKXnxyGpVktdNGCITR1OfguhXAyS7nFgvX0eswWHVbkgxCURpyHga-AHX77KNJTI5UyCkPcCM45hQdxy4W3gsWvP0X3snQvBLk49oxn0ij1IIiHRjG228',
                ]
            ]);
        }        
        $data = json_decode($response->getBody()->getContents(), true);

        $expiresAt = Carbon::now()->addSeconds($data['expiresIn']);

        IfoodToken::create([
            'access_token' => $data['accessToken'],
            'refresh_token' => $data['refreshToken'],
            'expires_at' => $expiresAt,
            'loja_id' => $loja_id,
        ]);

        return $data['accessToken'];
    }

    //Obter Merchants
    public function getMerchants(){

        $ifoodService = new IfoodService();
        $token = $ifoodService->getAccessToken();
        
        // Exemplo de requisição à API do iFood
        $response = $ifoodService->client->get('https://merchant-api.ifood.com.br/merchant/v1.0/merchants', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }

    //Obter Catalogs
    public function getCatalogs(){

        $ifoodService = new IfoodService();

        //Obter accessToken
        $token = $ifoodService->getAccessToken();

        //Obter MerchantID
        $merchantID = $ifoodService->getMerchantIdFoomy();
        
        // Obter cardápios iFood
        $response = $ifoodService->client->get('https://merchant-api.ifood.com.br/catalog/v2.0/merchants/'.$merchantID.'/catalogs', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }

    //Obter Categorias e produtos
    public function getCategories($catalogId){

        $ifoodService = new IfoodService();

        //Obter accessToken
        $token = $ifoodService->getAccessToken();

       //Obter MerchantID
       $merchantID = $ifoodService->getMerchantIdFoomy();
        
        // Obter Categorias e Produtos iFood
        $response = $ifoodService->client->get('https://merchant-api.ifood.com.br/catalog/v2.0/merchants/'.$merchantID.'/catalogs/'.$catalogId.'/categories', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }

    //Obter Pollings
    public function getPollings(){

        $ifoodService = new IfoodService();
        $token = $ifoodService->getAccessToken();
        
        $response = $ifoodService->client->get('https://merchant-api.ifood.com.br/events/v1.0/events:polling', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        
        return $data;
    }

    //Obter detalhes do pedido
    public function getOrder($pedido_id){

        $ifoodService = new IfoodService();
        $token = $ifoodService->getAccessToken();
        
        $response = $ifoodService->client->get('https://merchant-api.ifood.com.br/order/v1.0/orders/'.$pedido_id, [
            'headers' => [
                'Authorization' => "Bearer $token",
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        
        return $data;
    }

    //Acknowledgment evento polling
    public function postAcknowledgment($acknowledgment_id){
        $ifoodService = new IfoodService();
        $token = $ifoodService->getAccessToken();
        
        $response = $ifoodService->client->post('https://merchant-api.ifood.com.br/events/v1.0/events/acknowledgment', [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                [
                    'id' => $acknowledgment_id,
                ],
            ]
        ]);
    }

}
