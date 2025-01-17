<?php

namespace App\Helpers;

use App\Models\Loja;
use App\Models\UserLoja;
use App\Services\IfoodService;
use Illuminate\Support\Facades\Auth;

class LojaHelper
{
    public static function getUserLoja(){

        //Usuario
        $user_id = Auth::user()->id;

        //Obter IDs de Lojas relacionadas ao usuário
        $userLojas = UserLoja::where('user_id', $user_id)->get();

        $lojas = [];

        foreach($userLojas as $userLoja){
            $lojas[] = Loja::find($userLoja->loja_id);
        }
        return $lojas;
    }

    //Mudar status da loja conectada
    public static function MudarStatusLoja(){

        //instancindo IfoodService
        $ifoodService = new IfoodService();

        //Se houver uma loja conectada
        if(session('lojaConectado')){
            
            //Obtendo Loja
            $loja = Loja::find(session('lojaConectado')['id']);

            if($loja != null){
                
                //Se houver integração com iFood e se Token estiver ativo
                if($loja->ifood_merchant_id != null && $loja->ifood_token->sortByDesc('expires_at')->first()->expires_at->isFuture()){

                    $merchant = $ifoodService->getMerchantStatus($loja->ifood_merchant_id);

                    //Verificando se está aberto no iFood
                    if($merchant[0]['state'] == 'OK' || $merchant[0]['state'] == 'WARNING'){

                        $loja->state = $merchant[0]['state'];
                        $loja->save();

                    }else{

                        $loja->state = $merchant[0]['state'];
                        $loja->save();

                    }

                }
            }
        }
    }
}