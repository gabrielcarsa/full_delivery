<?php

namespace App\Services;

use App\Models\IfoodToken;
use Carbon\Carbon;
use GuzzleHttp\Client;

class IfoodService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
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
        // Obtém token mais recente
        $token = IfoodToken::latest()->first();

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
            $response = $this->client->post('https://merchant-api.ifood.com.br/authentication/v1.0/oauth/token', [
                'form_params' => [
                    'grantType' => 'refresh_token',
                    'clientId' => env('IFOOD_CLIENT_ID'),
                    'clientSecret' => env('IFOOD_CLIENT_SECRET'),
                    'authorizationCode' => 'RSLD-LDPV',
                    'authorizationCodeVerifier' => 'ml6xrrvn42i6x3kfuwp4dnvknqmx14pict8uc3xocofjsfhyhkv76tmymh3bsknhtgbxunjjonxjvxtfoixyb40fm5ieut21wg',
                    'refreshToken' => 'eyJraWQiOiJlZGI4NWY2Mi00ZWY5LTExZTktODY0Ny1kNjYzYmQ4NzNkOTMiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzUxMiJ9.eyJzdWIiOiIxNzllYjE5MC1iYjA1LTQzMmMtYTc1ZS1kNDQ2N2UzMjhiYmEiLCJpc3MiOiJpRm9vZCIsImV4cCI6MTcyOTAwMDE5NiwiaWF0IjoxNzI4Mzk1Mzk2LCJjbGllbnRfaWQiOiIyMWI3YTEwZi1mZDAwLTQ4MWUtOTU0My05NjRmN2UwYzUzNDEifQ.ai9wRmy1oL_SM4XwOM8EI9OtY9Rsd-DTGDMa3y-KMC6sgKRKtMhUy5bKXnxyGpVktdNGCITR1OfguhXAyS7nFgvX0eswWHVbkgxCURpyHga-AHX77KNJTI5UyCkPcCM45hQdxy4W3gsWvP0X3snQvBLk49oxn0ij1IIiHRjG228',
                ]
            ]);
        }        
        $data = json_decode($response->getBody()->getContents(), true);

        $expiresAt = Carbon::now()->addSeconds($data['expiresIn']);

        IfoodToken::create([
            'access_token' => $data['accessToken'],
            'refresh_token' => $data['refreshToken'],
            'expires_at' => $expiresAt,
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
        $token = $ifoodService->getAccessToken();
        
        // Obter cardápios iFood
        $response = $ifoodService->client->get('https://merchant-api.ifood.com.br/catalog/v2.0/merchants/'.env('IFOOD_MERCHANT_ID').'/catalogs', [
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
        $token = $ifoodService->getAccessToken();
        
        // Obter Categorias e Produtos iFood
        $response = $ifoodService->client->get('https://merchant-api.ifood.com.br/catalog/v2.0/merchants/'.env('IFOOD_MERCHANT_ID').'/catalogs/'.$catalogId.'/categories', [
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
}
