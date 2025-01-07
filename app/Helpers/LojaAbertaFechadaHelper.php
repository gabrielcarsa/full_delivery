<?php

namespace App\Helpers;

use App\Models\Loja;
use App\Services\IfoodService;

class LojaAbertaFechadaHelper
{
    public static function getLojaStatus(){

        //instancindo IfoodService
        $ifoodService = new IfoodService();

        //Se houver uma loja conectada
        if(session('lojaConectado')){
            
            //Obtendo Loja
            $loja = Loja::where('id', session('lojaConectado')['id'])->first();

            //Se houver integração com iFood e se Token estiver ativo
            if($loja->ifood_merchant_id != null && $loja->ifood_token->sortByDesc('expires_at')->first()->expires_at->isFuture()){

                $merchant = $ifoodService->getMerchantStatus($loja->ifood_merchant_id);

                //Verificando se está aberto no iFood
                if($merchant[0]['state'] == 'OK' || $merchant[0]['state'] == 'WARNING'){

                    $loja->state = $merchant[0]['state'];
                    $loja->save();

                    return true;
                }else{

                    $loja->state = $merchant[0]['state'];
                    $loja->save();

                    return false;
                }

            }else{

                //Verificar se loja está aberta 
                if($loja->state == "OK" || $loja->state == "WARNING"){
                    return true;
                }else{
                    return false;
                }
            }
        }
        //Se não houver loja conectada
        return null;
    }
}