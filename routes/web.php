<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\CategoriaProdutoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\CardapioController;
use App\Http\Controllers\OpcionalProdutoController;
use App\Http\Controllers\ClienteController;



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
Route::get('/carrinho', [CardapioController::class, 'indexCarrinho'])->name('cardapio.carrinho');
Route::get('/produto', [CardapioController::class, 'showProduto'])->name('cardapio.produto');
Route::post('/adicionar-carrinho/{produto_id}', [CardapioController::class, 'storeCarrinho']);
Route::get('/limpar-carrinho', [CardapioController::class, 'destroyCarrinho'])->name('cardapio.esvaziarCarrinho');


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
        Route::post('/escolher-restaurante/{id}', [RestauranteController::class, 'choose']);
        Route::get('/restaurante', [RestauranteController::class, 'index'])->name('restaurante');
        Route::get('/restaurante/configurar', [RestauranteController::class, 'configuracao'])->name('restaurante.configurar');
        Route::post('/restaurante/cadastrar/{usuario_id}', [RestauranteController::class, 'store']);
        Route::put('/restaurante/alterar/{usuario_id}/{restaurante_id}', [RestauranteController::class, 'update']);
        Route::put('/restaurante/alterar-logo/{restaurante_id}', [RestauranteController::class, 'update_logo']);

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
        Route::get('/produto/promocao', [ProdutoController::class, 'edit_promocao'])->name('produto.promocao');
        Route::post('/produto/promocao/{produto_id}', [ProdutoController::class, 'update_promocao']);
        Route::post('/produto/destacar', [ProdutoController::class, 'destacar'])->name('produto.destacar');
        
        //OPCIONAL PRODUTO
        Route::get('/opcional_produto', [OpcionalProdutoController::class, 'index'])->name('opcional_produto');
        Route::get('/opcional_produto/novo', [OpcionalProdutoController::class, 'create'])->name('opcional_produto.novo');
        Route::post('/opcional_produto/cadastrar/{produto_id}/{usuario_id}', [OpcionalProdutoController::class, 'store']);
        Route::delete('/opcional_produto/apagar/{id}', [OpcionalProdutoController::class, 'destroy'])->name('opcional_produto.excluir');
        Route::get('/opcional_produto/editar', [OpcionalProdutoController::class, 'edit'])->name('opcional_produto.editar');
        Route::put('/opcional_produto/alterar/{usuario_id}/{produto_id}', [OpcionalProdutoController::class, 'update']);
 
        //CLIENTE
        Route::get('/cliente', [ClienteController::class, 'index'])->name('cliente');
        Route::get('/cliente/novo', [ClienteController::class, 'create'])->name('cliente.novo');
        Route::post('/cliente/cadastrar', [ClienteController::class, 'store']);
        Route::get('/cliente/editar', [ClienteController::class, 'edit'])->name('cliente.editar');
        Route::put('/cliente/alterar/{cliente_id}', [ClienteController::class, 'update']);
        Route::delete('/cliente/apagar/{id}', [ClienteController::class, 'destroy'])->name('cliente.excluir');

         
});
