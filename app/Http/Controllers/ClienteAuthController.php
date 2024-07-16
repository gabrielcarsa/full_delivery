<?php

namespace App\Http\Controllers;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClienteAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('cliente.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('cliente')->attempt($credentials)) {
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('cliente')->logout();
        return redirect()->route('cliente.login');
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

