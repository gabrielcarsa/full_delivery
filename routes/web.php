<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\CategoriaProdutoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\LojaController;
use App\Http\Controllers\CardapioController;
use App\Http\Controllers\OpcionalProdutoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\ClienteAuthController;

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

Route::middleware('auth:cliente')->group(function () {

});

Route::get('cliente/login', [ClienteAuthController::class, 'showLoginForm'])->name('cliente.login');
Route::post('cliente/login', [ClienteAuthController::class, 'login']);
Route::post('cliente/logout', [ClienteAuthController::class, 'logout'])->name('cliente.logout');
Route::get('cliente/register', [ClienteAuthController::class, 'showRegistrationForm'])->name('cliente.register');
Route::post('cliente/register', [ClienteAuthController::class, 'register']);



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
        Route::post('/escolher-loja/{id}', [LojaController::class, 'choose']);
        Route::get('/loja', [LojaController::class, 'index'])->name('loja');
        Route::get('/loja/configurar', [LojaController::class, 'configuracao'])->name('loja.configurar');
        Route::post('/loja/cadastrar/{usuario_id}', [LojaController::class, 'store']);
        Route::put('/loja/alterar/{usuario_id}/{loja_id}', [LojaController::class, 'update']);
        Route::put('/loja/alterar-logo/{loja_id}', [LojaController::class, 'update_logo']);
       
        //ENTREGAS RESTAURANTE
        Route::get('/entregas-taxas', [LojaController::class, 'show_entrega_taxas'])->name('loja.entrega_taxas');
        Route::get('/entregas-areas', [LojaController::class, 'show_entrega_areas'])->name('loja.entrega_areas');
        Route::post('/entregas/gratuita', [LojaController::class, 'taxa_entrega_free'])->name('loja.taxa_entrega_free');
        Route::post('/entregas/por-km', [LojaController::class, 'taxa_por_km_entrega'])->name('loja.taxa_por_km_entrega');
        Route::post('/entregas/fixa', [LojaController::class, 'taxa_entrega_fixa'])->name('loja.taxa_entrega_fixa');
        Route::post('/entregas/areas-metros', [LojaController::class, 'area_entrega_metros'])->name('loja.area_entrega_metros');


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
        Route::get('/opcional_produto/listar/{produto_id}', [OpcionalProdutoController::class, 'opcionais']);
 
        //CLIENTE
        Route::get('/cliente', [ClienteController::class, 'index'])->name('cliente');
        Route::get('/cliente/novo', [ClienteController::class, 'create'])->name('cliente.novo');
        Route::post('/cliente/cadastrar', [ClienteController::class, 'store']);
        Route::get('/cliente/editar', [ClienteController::class, 'edit'])->name('cliente.editar');
        Route::put('/cliente/alterar/{cliente_id}', [ClienteController::class, 'update']);
        Route::delete('/cliente/apagar/{id}', [ClienteController::class, 'destroy'])->name('cliente.excluir');

        //PEDIDO
        Route::get('/pedido', [PedidoController::class, 'painel'])->name('pedido.painel');
        Route::get('/pedido/novo-simulador', [PedidoController::class, 'create'])->name('pedido.novo');
        Route::post('/pedido/cadastrar', [PedidoController::class, 'store'])->name('pedido.cadastrar');
        Route::get('/pedido/detalhes', [PedidoController::class, 'show'])->name('pedido.show');
        Route::get('/pedido/update-status', [PedidoController::class, 'update_status'])->name('pedido.update_status');
        Route::post('/pedido/rejeitar', [PedidoController::class, 'rejeitar'])->name('pedido.rejeitar');
        Route::post('/pedido/cancelar', [PedidoController::class, 'cancelar'])->name('pedido.cancelar');

        //CUPOM
        Route::get('/cupom', [CupomController::class, 'index'])->name('cupom');
        Route::get('/cupom/novo', [CupomController::class, 'create'])->name('cupom.novo');
        Route::post('/cupom/cadastrar', [CupomController::class, 'store']);
        Route::get('/cupom/editar', [CupomController::class, 'edit'])->name('cupom.editar');
        Route::put('/cupom/alterar/{cupom_id}', [CupomController::class, 'update']);
        Route::delete('/cupom/apagar/{id}', [CupomController::class, 'destroy'])->name('cupom.excluir');
        Route::get('/cupom/status', [CupomController::class, 'status'])->name('cupom.status');
        Route::get('/cupom/detalhes', [CupomController::class, 'show'])->name('cupom.show');


});
