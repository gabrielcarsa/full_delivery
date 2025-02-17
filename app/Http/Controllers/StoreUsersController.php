<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\StoreUsers;
use App\Models\Stores;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\StoreUserInvitations;
use Illuminate\Support\Facades\Auth;
use Exception;

class StoreUsersController extends Controller
{
    /**
     * Send email to invite user
     */
    public function invite_user(Request $request)
    {
        // form validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'username' => 'required|string|max:100',
            'position' => 'required|string|max:100',
            'access_level' => 'required|string|max:50',
        ]/*,[
            'faturamento_mensal.required' => 'Por favor, selecione uma opção.',
            'faturamento_mensal.not_in' => 'A opção selecionada é inválida.',
        ]*/);

        // if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // store ID
        $store_id = $request->get('store_id');

        $user = Users::where('email', $request->input('email'))->first();

        // if the user alredy exists
        if($user != null){
            
            StoreUsers::create([
                'user_id' => $user->id,
                'store_id' => $store_id,
                'access_level' => $request->input('access_level'),
                'position' => $request->input('position'), 
                'created_by_user_id' => Auth::user()->id,
            ]);
            
            return redirect()->back()->with('success', 'Usuário adicionado com sucesso - '.$request->input('email'));
            
        }else{
            
            // Store
            $store = Stores::findOrFail($store_id);

            $data = [
                'store' => $store,
                'email' => $request->input('email'),
                'username' => $request->input('username'),
                'position' => $request->input('position'),
                'access_level' => $request->input('access_level'),

            ];
            
            // try send email and return 
            try {
                Mail::to($data['email'])->send(new StoreUserInvitations($data));

                return redirect()->back()->with('success', 'Convite enviado com sucesso para '.$data['email']);
                
            } catch (Exception $e) {
                
                return redirect()->back()->with('error', 'Erro ao enviar email: '.$e->getMessage());
                
            }
        }

    }
    
   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StoreUsers $store_user)
    {
        return view('store_user.edit', compact('store_user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUsers $store_user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'position' => 'required|string|max:100',
            'access_level' => 'required|string|max:50|in:ADMIN,MANAGER,FINANCE,USER',
        ]/*,[
            'faturamento_mensal.required' => 'Por favor, selecione uma opção.',
            'faturamento_mensal.not_in' => 'A opção selecionada é inválida.',
        ]*/);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $store_user-> access_level= $request->input('access_level');
        $store_user->position = $request->input('position');
        $store_user->save();

        return redirect()->route('store.show', ['store' => $store_user->store, 'tab' => 'equipe'])->with('success', 'Alterações feitas com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}