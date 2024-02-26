<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\CategoriaProdutoController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {

        //RETORNAR DASHBOARD
        return view('dashboard');})->name('dashboard');

        //APENAS REGISTRO DE USUÁRIO SE ESTIVER AUTENTICADO
        Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

        //CATEGORIA PRODUTO
        Route::get('/categoria_produto',function () {return view('categoria_produto/listar');})->name('categoria_produto');
        Route::get('/categoria_produto/listar', [CategoriaProdutoController::class, 'listar'])->name('categoria_produto_listar');
        Route::get('/categoria_produto/novo', function () {return view('categoria_produto/novo');})->name('categoria_produto_novo');
        Route::post('/categoria_produto/cadastrar/{usuario_id}', [CategoriaProdutoController::class, 'cadastrar'])->name('categoria_produto_cadastrar');


        

});
