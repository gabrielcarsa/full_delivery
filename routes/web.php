<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\CategoriaProdutoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\RestauranteController;



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
        
        //RESTAURANTE
        Route::get('/restaurante', [RestauranteController::class, 'index'])->name('restaurante');

        //CATEGORIA PRODUTO
        Route::get('/categoria_produto', [CategoriaProdutoController::class, 'index'])->name('categoria_produto');
        Route::get('/categoria_produto/novo', function () {return view('categoria_produto/novo');})->name('categoria_produto.novo');
        Route::post('/categoria_produto/cadastrar/{usuario_id}', [CategoriaProdutoController::class, 'store'])->name('categoria_produto.cadastrar');

        //PRODUTO
        Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos');
        Route::get('/produtos/pesquisar', [ProdutoController::class, 'pesquisar']);
        Route::get('/produto/novo', [ProdutoController::class, 'create'])->name('produto.novo');
        Route::post('/produto/cadastrar/{categoria_id}/{usuario_id}', [ProdutoController::class, 'store']);
        Route::delete('/produto/apagar/{id}', [ProdutoController::class, 'destroy'])->name('produto.excluir');
        

});
