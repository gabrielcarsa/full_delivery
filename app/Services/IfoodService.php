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
        
        $loja_id = $this->getIdlojaConectada();

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

        return $this->postAccessToken(null, null);
    }

    //AccessToken
    public function postAccessToken($authorization_code, $authorization_code_verifier)
    {
        //Obter Loja ID
        $loja_id = $this->getIdlojaConectada();
        
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
                    'authorizationCode' => $authorization_code,
                    'authorizationCodeVerifier' => $authorization_code_verifier,
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

    //Obter UserCode
    public function getUserCode(){
        
        try {
            // Exemplo de requisição à API do iFood com form-urlencoded
            $response = $this->client->post('https://merchant-api.ifood.com.br/authentication/v1.0/oauth/userCode', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept'       => 'application/json',
                ],
                'form_params' => [
                    'clientId' => '21b7a10f-fd00-481e-9543-964f7e0c5341',
                ],
            ]);
    
            $data = json_decode($response->getBody()->getContents(), true);
    
            return $data;
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }

    //Obter Merchants
    public function getMerchants(){

        $token = $this->getAccessToken();
        
        // Exemplo de requisição à API do iFood
        $response = $this->client->get('https://merchant-api.ifood.com.br/merchant/v1.0/merchants', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }

    public function getMerchant($id){

        $token = $this->getAccessToken();
        
        // Exemplo de requisição à API do iFood
        $response = $this->client->get('https://merchant-api.ifood.com.br/merchant/v1.0/merchants/'.$id, [
            'headers' => [
                'Authorization' => "Bearer $token",
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }

    public function getMerchantStatus($id){

        $token = $this->getAccessToken();
        
        // Exemplo de requisição à API do iFood
        $response = $this->client->get('https://merchant-api.ifood.com.br/merchant/v1.0/merchants/'.$id.'/status', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }

    //Obter Catalogs
    public function getCatalogs(){

        //Obter accessToken
        $token = $this->getAccessToken();

        //Obter MerchantID
        $merchantID = $this->getMerchantIdFoomy();
        
        // Obter cardápios iFood
        $response = $this->client->get('https://merchant-api.ifood.com.br/catalog/v2.0/merchants/'.$merchantID.'/catalogs', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }

    //Obter Categorias e produtos
    public function getCategories($catalogId){

        //Obter accessToken
        $token = $this->getAccessToken();

       //Obter MerchantID
       $merchantID = $this->getMerchantIdFoomy();
        
        // Obter Categorias e Produtos iFood
        $response = $this->client->get('https://merchant-api.ifood.com.br/catalog/v2.0/merchants/'.$merchantID.'/catalogs/'.$catalogId.'/categories', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }

    //Obter Pollings
    public function getPollings(){

        $token = $this->getAccessToken();
        
        $response = $this->client->get('https://merchant-api.ifood.com.br/events/v1.0/events:polling', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        
        return $data;
    }

    //Obter detalhes do pedido
    public function getOrder($pedido_id){

        $token = $this->getAccessToken();
        
        $response = $this->client->get('https://merchant-api.ifood.com.br/order/v1.0/orders/'.$pedido_id, [
            'headers' => [
                'Authorization' => "Bearer $token",
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        
        return $data;
    }

    //Acknowledgment evento polling
    public function postAcknowledgment($acknowledgment_id){

        $token = $this->getAccessToken();
        
        $response = $this->client->post('https://merchant-api.ifood.com.br/events/v1.0/events/acknowledgment', [
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

    //Confirmar pedido
    public function postConfirm($pedido_id){

        $token = $this->getAccessToken();
        
        $response = $this->client->post('https://merchant-api.ifood.com.br/order/v1.0/orders/'.$pedido_id.'/confirm', [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    //Pedido pronto para retirar
    public function postReadyToPickUp($pedido_id){

        $token = $this->getAccessToken();
        
        $response = $this->client->post('https://merchant-api.ifood.com.br/order/v1.0/orders/'.$pedido_id.'/readyToPickup', [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    //Pedido dispachado
    public function postDispatch($pedido_id){

        $token = $this->getAccessToken();
        
        $response = $this->client->post('https://merchant-api.ifood.com.br/order/v1.0/orders/'.$pedido_id.'/dispatch', [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    //Solicitar cancelamento pedido
    public function requestCancellation($pedido_id, $reason, $cancellationCode){

        $token = $this->getAccessToken();
        
        $response = $this->client->post('https://merchant-api.ifood.com.br/order/v1.0/orders/'.$pedido_id.'/requestCancellation', [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                [
                    'reason' => $reason,
                    'cancellationCode'=> $cancellationCode,
                ],
            ]
        ]);
    }

}
