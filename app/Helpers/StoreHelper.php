<?php

namespace App\Helpers;

use App\Models\Stores;
use App\Models\StoreUsers;
use App\Services\IfoodService;
use Illuminate\Support\Facades\Auth;

class StoreHelper
{
    public static function getStoreUsers(){

        //Usuario
        $user_id = Auth::user()->id;

        //Obter IDs de Lojas relacionadas ao usuário
        $storeUsers = StoreUsers::where('user_id', $user_id)->get();

        $stores = [];

        foreach($storeUsers as $storeUser){
            $stores[] = Loja::find($storeUser->store_id);
        }
        return $stores;
    }

    //Mudar status da store conectada
    public static function MudarStatusLoja(){

        //instancindo IfoodService
        $ifoodService = new IfoodService();

        //Se houver uma store conectada
        if(session('storeConectado')){
            
            //Obtendo Loja
            $store = Loja::find(session('storeConectado')['id']);

            if($store != null){
                
                //Se houver integração com iFood e se Token estiver ativo
                if($store->ifood_merchant_id != null && $store->ifood_token->sortByDesc('expires_at')->first()->expires_at->isFuture()){

                    $merchant = $ifoodService->getMerchantStatus($store->ifood_merchant_id);

                    //Verificando se está aberto no iFood
                    if($merchant[0]['state'] == 'OK' || $merchant[0]['state'] == 'WARNING'){

                        $store->state = $merchant[0]['state'];
                        $store->save();

                    }else{

                        $store->state = $merchant[0]['state'];
                        $store->save();

                    }

                }
            }
        }
    }
}