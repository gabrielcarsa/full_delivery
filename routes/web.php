<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\CategoriaProdutoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\CardapioController;



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

Route::get('/', [CardapioController::class, 'index'])->name('cardapio');
Route::get('/carrinho', [CardapioController::class, 'carrinho'])->name('carrinho.cardapio');
Route::get('/produto', [CardapioController::class, 'produto'])->name('produto.cardapio');

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
        Route::get('/restaurante/configurar', [RestauranteController::class, 'configuracao'])->name('restaurante.configurar');
        Route::post('/restaurante/cadastrar/{usuario_id}', [RestauranteController::class, 'store']);
        Route::put('/restaurante/alterar/{usuario_id}/{restaurante_id}', [RestauranteController::class, 'update']);

        //CATEGORIA PRODUTO
        Route::get('/categoria_produto', [CategoriaProdutoController::class, 'index'])->name('categoria_produto');
        Route::get('/categoria_produto/novo', [CategoriaProdutoController::class, 'create'])->name('categoria_produto.novo');
        Route::post('/categoria_produto/cadastrar/{usuario_id}', [CategoriaProdutoController::class, 'store'])->name('categoria_produto.cadastrar');
        Route::get('/categoria_produto/editar', [CategoriaProdutoController::class, 'edit'])->name('categoria_produto.editar');
        Route::put('/categoria_produto/alterar/{usuario_id}/{categoria_id}', [CategoriaProdutoController::class, 'update']);
        Route::delete('/categoria_produto/apagar/{id}', [CategoriaProdutoController::class, 'destroy'])->name('categoria_produto.excluir');

        //PRODUTO
        Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos');
        Route::get('/produtos/pesquisar', [ProdutoController::class, 'search']);
        Route::get('/produto/novo', [ProdutoController::class, 'create'])->name('produto.novo');
        Route::post('/produto/cadastrar/{categoria_id}/{usuario_id}', [ProdutoController::class, 'store']);
        Route::get('/produto/editar', [ProdutoController::class, 'edit'])->name('produto.editar');
        Route::put('/produto/alterar/{usuario_id}/{produto_id}', [ProdutoController::class, 'update']);
        Route::delete('/produto/apagar/{id}', [ProdutoController::class, 'destroy'])->name('produto.excluir');
        

});
