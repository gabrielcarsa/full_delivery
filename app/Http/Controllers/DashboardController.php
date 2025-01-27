<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\StoreHelper;

class DashboardController extends Controller
{
    //
    public function dashboard(){

        //Verificar se há loja selecionada
        if(!session('selected_store')){
            return redirect()->route('store.index');
        }

        //Obter lojas do usuário
        $stores = StoreHelper::getStoreUsers();

        $data = [
            'stores' => $stores,
        ];

        return view('dashboard', compact('data'));
    }
}
