<?php

namespace App\Helpers;

use App\Models\Loja;

class LojaAbertaFechadaHelper
{
    public static function getLojaStatus(){
        //Se houver uma loja conectada
        if(session('lojaConectado')){
            $loja = Loja::where('id', session('lojaConectado')['id'])->first();

            //Verificar se loja está aberta 
            if($loja->is_open == true){
                return true;
            }else{
                return false;
            }
        }
        //Se não houver loja conectada
        return null;
    }
}