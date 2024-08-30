<?php

namespace App\Http\Controllers;
use App\Models\Cliente;
use App\Models\Loja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClienteAuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        //Variaveis via GET
        $loja_id = $request->get('loja_id');
        $consumo_local_viagem_delivery = $request->get('consumo_local_viagem_delivery');

        // Se já houver escolhido a loja e o consumo
        if($loja_id != null && $consumo_local_viagem_delivery != null){

            //Loja
            $loja = Loja::find($loja_id);

            $data = [
                'loja_id' => $loja_id,
                'consumo_local_viagem_delivery' => $consumo_local_viagem_delivery,
                'loja' => $loja
            ];
            return view('cliente.login', compact('data'));

        }

        return view('cliente.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('cliente')->attempt($credentials)) {
            //Variaveis via GET
            $loja_id = $request->get('loja_id');
            $consumo_local_viagem_delivery = $request->get('consumo_local_viagem_delivery');

            // Se já houver escolhido a loja e o consumo
            if($loja_id != null && $consumo_local_viagem_delivery != null){

                return redirect()->route('cardapio', [
                    'loja_id' => $loja_id,
                    'consumo_local_viagem_delivery' => $consumo_local_viagem_delivery,
                ]);

            }
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('cliente')->logout();
        return redirect()->route('cardapio');
    }

    public function showRegistrationForm()
    {
        return view('cliente.register');
    }

    public function register(Request $request)
    
    {
        $request->merge([
            'telefone' => str_replace(['(', '-', ')', ' '], '', $request->input('telefone')),
        ]);

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:cliente',
            'telefone' => 'required|string|max:100',
            'senha' => 'required|string|min:8|confirmed',
        ]);

        $cliente = Cliente::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'senha' => Hash::make($request->senha),
        ]);

        Auth::guard('cliente')->login($cliente);

        return redirect()->route('cardapio');
    }
}