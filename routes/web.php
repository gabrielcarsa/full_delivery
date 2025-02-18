<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\StoreOpeningHoursController;
use App\Http\Controllers\StoreUsersController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\ProductOptionCategoriesController;
use App\Http\Controllers\ProductOptionsController;
use App\Http\Controllers\ProductsController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CardapioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\ClienteAuthController;
use App\Http\Controllers\ClienteEnderecoController;
use App\Http\Controllers\FormaPagamentoController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\LancamentoController;
use App\Http\Controllers\CategoriaFinanceiroController;
use App\Http\Controllers\ParcelaLancamentoController;
use App\Http\Controllers\ContaCorrenteController;
use App\Http\Controllers\MovimentacaoController;
use App\Http\Controllers\SaldoController;


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

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

Route::get('/', function(){return view('inicio');});
Route::get('/cardapio', [CardapioController::class, 'index'])->name('cardapio');
Route::get('/carrinho', [CardapioController::class, 'indexCarrinho'])->name('cardapio.carrinho');
Route::get('/produto', [CardapioController::class, 'showProduto'])->name('cardapio.produto');
Route::post('/adicionar-carrinho/{produto_id}', [CardapioController::class, 'storeCarrinho']);
Route::get('/limpar-carrinho', [CardapioController::class, 'destroyCarrinho'])->name('cardapio.esvaziarCarrinho');
Route::get('/carrinho/remover-quantidade', [CardapioController::class, 'remover_quantidade'])->name('cardapio.remover_quantidade');
Route::get('/carrinho/adicionar-quantidade', [CardapioController::class, 'adicionar_quantidade'])->name('cardapio.adicionar_quantidade');
Route::get('/carrinho/deletar-item', [CardapioController::class, 'deletar_item'])->name('cardapio.deletar_item');

// CLIENTE CARDAPIO
Route::get('cliente/login', [ClienteAuthController::class, 'showLoginForm'])->name('cliente.login');
Route::post('cliente/login', [ClienteAuthController::class, 'login']);
Route::get('cliente/register', [ClienteAuthController::class, 'showRegistrationForm'])->name('cliente.register');
Route::post('cliente/register', [ClienteAuthController::class, 'register']);

// PEDIDO
Route::get('/pedido-cliente', [PedidoController::class, 'indexPedidosCliente'])->name('pedido.pedidoCliente');
Route::post('/pedido-cliente/cadastrar-web', [PedidoController::class, 'storeWeb'])->name('pedido.cadastrarWeb');
Route::get('/pedido-cliente/detalhes-pedido', [PedidoController::class, 'showWeb'])->name('pedido.showWeb');

// CLIENTE AREA
Route::get('cliente/area', [ClienteController::class, 'showClienteArea'])->name('cliente.area');

// CLIENTE CARDAPIO LOGADO
Route::middleware('auth:cliente')->group(function () {
    Route::get('cliente/logout', [ClienteAuthController::class, 'logout'])->name('cliente.logout');

    // ENDERECO CLIENTE
    Route::get('cliente-endereco', [ClienteEnderecoController::class, 'index'])->name('cliente_endereco.listar');
    Route::get('/cliente-endereco/novo', [ClienteEnderecoController::class, 'create'])->name('cliente_endereco.novo');
    Route::post('/cliente-endereco/cadastrar', [ClienteEnderecoController::class, 'store'])->name('cliente_endereco.cadastrar');
    Route::delete('/cliente-endereco/apagar/{id}', [ClienteEnderecoController::class, 'destroy'])->name('cliente_endereco.excluir');

});

// ROTAS INTERNO
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
        //DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        
        //STORES
        Route::post('/selected-store', [StoresController::class, 'select'])->name('store.select');
        Route::put('/store/alterar-logo', [StoresController::class, 'update_logo'])->name('store.update_logo');
        Route::put('/store/alterar-banner', [StoresController::class, 'update_banner'])->name('store.update_banner');
        Route::get('/store/integracao-ifood', [StoresController::class, 'create_integration_ifood'])->name('store.create_integration_ifood');
        Route::post('/store/integracao-ifood', [StoresController::class, 'store_integration_ifood'])->name('store.store_integration_ifood');
        Route::resource('store', StoresController::class);
        
        //STORE OPENING HOURS
        Route::resource('store_opening_hours', StoreOpeningHoursController::class)->only(['store', 'destroy']);

        //STORE USERS
        Route::post('/store_users/invite', [StoreUsersController::class, 'invite_user'])->name('store_users.invite_user');
        Route::put('/store_users/active_disable', [StoreUsersController::class, 'active_disable'])->name('store_users.active_disable');
        Route::resource('store_users', StoreUsersController::class)->only(['edit', 'update']);
       
        //ENTREGAS LOJA
        Route::get('/entregas-taxas', [StoresController::class, 'show_entrega_taxas'])->name('store.entrega_taxas');
        Route::get('/entregas-areas', [StoresController::class, 'show_entrega_areas'])->name('store.entrega_areas');
        Route::post('/entregas/gratuita', [StoresController::class, 'taxa_entrega_free'])->name('store.taxa_entrega_free');
        Route::post('/entregas/por-km', [StoresController::class, 'taxa_por_km_entrega'])->name('store.taxa_por_km_entrega');
        Route::post('/entregas/fixa', [StoresController::class, 'taxa_entrega_fixa'])->name('store.taxa_entrega_fixa');
        Route::post('/entregas/areas-metros', [StoresController::class, 'area_entrega_metros'])->name('store.area_entrega_metros');


        //PRODUCT CATEGORIES
        Route::get('/categoria_produto/JSON', [ProductCategoriesController::class, 'indexJSON'])->name('product_categories.JSON');
        Route::get('/categoria_produto/importar-ifood', [ProductCategoriesController::class, 'importarCardapioIfood'])->name('product_categories.importarCardapioIfood');
        Route::resource('product_categories', ProductCategoriesController::class);

        //PRODUCTS
        Route::get('/produto/promocao', [ProductController::class, 'edit_promocao'])->name('products.promocao');
        Route::post('/produto/promocao/{produto_id}', [ProductController::class, 'update_promocao']);
        Route::post('/produto/destacar', [ProductController::class, 'destacar'])->name('products.destacar');
        Route::resource('products', ProductCategoriesController::class);
        
        //PRODUCT OPTION CATEGORIES
        Route::resource('product_option_categories', ProductOptionCategoriesController::class);

        //OPCIONAL PRODUTO
        Route::resource('product_options', ProductOptionsController::class);
 
        //CLIENTE
        Route::get('/cliente', [ClienteController::class, 'index'])->name('cliente');
        Route::get('/cliente/novo', [ClienteController::class, 'create'])->name('cliente.novo');
        Route::post('/cliente/cadastrar', [ClienteController::class, 'store']);
        Route::get('/cliente/editar', [ClienteController::class, 'edit'])->name('cliente.editar');
        Route::put('/cliente/alterar/{cliente_id}', [ClienteController::class, 'update']);
        Route::delete('/cliente/apagar/{id}', [ClienteController::class, 'destroy'])->name('cliente.excluir');

        //ORDERS
        Route::get('/pedido/update-status', [PedidoController::class, 'update_status'])->name('pedido.update_status');
        Route::post('/pedido/cancelar', [PedidoController::class, 'cancelar'])->name('pedido.cancelar');
        Route::post('/pedido/pagamento-mesa', [PedidoController::class, 'pagamento_mesa'])->name('pedido.pagamento');
        Route::get('/pedido/adicionar-quantidade', [PedidoController::class, 'adicionar_quantidade'])->name('pedido.adicionar_quantidade');
        Route::get('/pedido/remover-quantidade', [PedidoController::class, 'remover_quantidade'])->name('pedido.remover_quantidade');
        Route::get('/pedido/deletar-item', [PedidoController::class, 'deletar_item'])->name('pedido.deletar_item');
        Route::get('/pedido/adicionar-item', [PedidoController::class, 'adicionar_item'])->name('pedido.adicionar_item');
        Route::get('/pedidos/atualizar', [PedidoController::class, 'refresh_pedidos'])->name('pedido.atualizar');
        Route::get('/pedidos/polling-ifood', [PedidoController::class, 'polling_ifood'])->name('pedido.polling');
        Route::resource('orders', OrdersController::class)->only(['index', 'show']);


        //CUPOM
        Route::get('/cupom', [CupomController::class, 'index'])->name('cupom');
        Route::get('/cupom/novo', [CupomController::class, 'create'])->name('cupom.novo');
        Route::post('/cupom/cadastrar', [CupomController::class, 'store']);
        Route::get('/cupom/editar', [CupomController::class, 'edit'])->name('cupom.editar');
        Route::put('/cupom/alterar/{cupom_id}', [CupomController::class, 'update']);
        Route::delete('/cupom/apagar/{id}', [CupomController::class, 'destroy'])->name('cupom.excluir');
        Route::get('/cupom/status', [CupomController::class, 'status'])->name('cupom.status');
        Route::get('/cupom/detalhes', [CupomController::class, 'show'])->name('cupom.show');

        //FORMAS DE PAGAMENTO
        Route::get('/forma-pagamento', [FormaPagamentoController::class, 'index'])->name('forma_pagamento');
        Route::post('/forma-pagamento/cadastrar', [FormaPagamentoController::class, 'store'])->name('forma_pagamento.cadastrar');
        Route::get('/forma-pagamento/vincular-conta-corrente', [FormaPagamentoController::class, 'updateVincular'])->name('forma_pagamento.updateVincular');

        //MESA
        Route::get('/mesa', [MesaController::class, 'index'])->name('mesa');
        Route::get('/mesa/novo', [MesaController::class, 'create'])->name('mesa.novo');
        Route::post('/mesa/cadastrar', [MesaController::class, 'store']);
        Route::delete('/mesa/apagar/{id}', [MesaController::class, 'destroy'])->name('mesa.excluir');
        Route::put('/mesa/mudar-mesa', [MesaController::class, 'mudar_mesa'])->name('mesa.mudar_mesa');

        Route::get('/painel-mesas', [MesaController::class, 'painel'])->name('mesa.painel');
        Route::get('/painel-mesas/detalhes', [MesaController::class, 'show'])->name('mesa.show');
        
        //LANÇAMENTO
        Route::get('/contas-receber', [LancamentoController::class, 'indexContasReceber'])->name('contas_receber.index');
        Route::get('/contas-pagar', [LancamentoController::class, 'indexContasPagar'])->name('contas_pagar.index');
        Route::get('/contas-receber/listar', [LancamentoController::class, 'indexAllContasReceber'])->name('contas_receber.indexAll');
        Route::get('/contas-pagar/listar', [LancamentoController::class, 'indexAllContasPagar'])->name('contas_pagar.indexAll');
        Route::get('/lancamento/novo', [LancamentoController::class, 'create'])->name('lancamento.novo');
        Route::post('/lancamento/cadastrar', [LancamentoController::class, 'store'])->name('lancamento.store');

        //PARCELA LANÇAMENTO
        Route::get('/parcela/editar-valor', [ParcelaLancamentoController::class, 'editValorParcela'])->name('parcela.editValorParcela');
        Route::put('/parcela/alterar-valor', [ParcelaLancamentoController::class, 'updateValorParcela'])->name('parcela.updateValorParcela');
        Route::get('/parcela/editar-vencimento', [ParcelaLancamentoController::class, 'editVencimentoParcela'])->name('parcela.editVencimentoParcela');
        Route::put('/parcela/alterar-vencimento', [ParcelaLancamentoController::class, 'updateVencimentoParcela'])->name('parcela.updateVencimentoParcela');
        Route::get('/parcela/editar-baixar', [ParcelaLancamentoController::class, 'editBaixarParcela'])->name('parcela.editBaixarParcela');
        Route::put('/parcela/alterar-baixar', [ParcelaLancamentoController::class, 'updateBaixarParcela'])->name('parcela.updateBaixarParcela');
        Route::get('/parcela/estornar-pagamento-recebimento', [ParcelaLancamentoController::class, 'editEstornarPagamentoRecebimento'])->name('parcela.editEstornarPagamentoRecebimento');
        Route::put('/parcela/estornar-pagamento-recebimento', [ParcelaLancamentoController::class, 'updateEstornarPagamentoRecebimento'])->name('parcela.updateEstornarPagamentoRecebimento');
        Route::get('/parcela/estornar-parcela', [ParcelaLancamentoController::class, 'editEstornarParcela'])->name('parcela.editEstornarParcela');
        Route::put('/parcela/estornar-parcela', [ParcelaLancamentoController::class, 'updateEstornarParcela'])->name('parcela.updateEstornarParcela');
        
        //CATEGORIA FINANCEIRO
        Route::get('/categoria-financeiro', [CategoriaFinanceiroController::class, 'index'])->name('categoria_financeiro.listar');
        Route::post('/categoria-financeiro/cadastrar', [CategoriaFinanceiroController::class, 'store'])->name('categoria_financeiro.store');
        Route::put('/categoria-financeiro/editar', [CategoriaFinanceiroController::class, 'edit'])->name('categoria_financeiro.edit');
        Route::delete('/categoria-financeiro/apagar', [CategoriaFinanceiroController::class, 'destroy'])->name('categoria_financeiro.excluir');
        
        //CONTA CORRENTE
        Route::get('/conta-corrente', [ContaCorrenteController::class, 'index'])->name('conta_corrente.listar');
        Route::get('/conta-corrente/novo', [ContaCorrenteController::class, 'create'])->name('conta_corrente.novo');
        Route::post('/conta-corrente/cadastrar', [ContaCorrenteController::class, 'store'])->name('conta_corrente.store');
        Route::get('/conta-corrente/editar', [ContaCorrenteController::class, 'edit'])->name('conta_corrente.edit');
        Route::put('/conta-corrente/alterar', [ContaCorrenteController::class, 'update'])->name('conta_corrente.update');
        Route::delete('/conta-corrente/apagar', [ContaCorrenteController::class, 'destroy'])->name('conta_corrente.destroy');

        //MOVIMENTAÇÃO
        Route::get('/movimentacao', [MovimentacaoController::class, 'showFormConsulta'])->name('movimentacao.showFormConsulta');
        Route::get('/movimentacao/listar', [MovimentacaoController::class, 'index'])->name('movimentacao.index');
        Route::get('/movimentacao/novo', [MovimentacaoController::class, 'create'])->name('movimentacao.create');
        Route::post('/movimentacao/cadastrar', [MovimentacaoController::class, 'store'])->name('movimentacao.store');

        //SALDO
        Route::get('/saldo', [SaldoController::class, 'index'])->name('saldo.index');

});