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
            $stores[] = Stores::find($storeUser->store_id);
        }
        return $stores;
    }

    //Mudar status da store conectada
    public static function updateStoreStatus(){

        //instancindo IfoodService
        $ifoodService = new IfoodService();

        //Se houver uma store conectada
        if(session('selected_store')){
            
            //Obtendo Loja
            $store = Stores::find(session('selected_store')['id']);

            if($store != null){

                //Se houver integração com iFood e se Token estiver ativo
                if($store->ifood_tokens->isNotEmpty()){
                    
                    $tokens = $store->ifood_tokens;

                    if($store->ifood_merchant_id != null && $tokens->sortByDesc('expires_at')->first()->expires_at->isFuture()){

                        $merchant = $ifoodService->getMerchantStatus($store->ifood_merchant_id);
    
                        //Verificando se está aberto no iFood
                        if($merchant[0]['state'] == 'OK' || $merchant[0]['state'] == 'WARNING'){
    
                            $store->status = $merchant[0]['state'];
                            $store->save();
    
                        }else{
    
                            $store->status = $merchant[0]['state'];
                            $store->save();
    
                        }
    
                    }
                }
                
            }
        }
    }
}