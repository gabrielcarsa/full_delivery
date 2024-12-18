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

            //Se houver integração com iFood
            if($loja->ifood_merchant_id != null){

                $merchant = $ifoodService->getMerchantStatus($loja->ifood_merchant_id);

                //Verificando se está aberto no iFood
                if($merchant[0]['state'] == 'OK' || $merchant[0]['state'] == 'WARNING'){

                    $loja->is_open = true;
                    $loja->save();

                    return true;
                }else{

                    $loja->is_open = false;
                    $loja->save();

                    return false;
                }

            }else{

                //Verificar se loja está aberta 
                if($loja->is_open == true){
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