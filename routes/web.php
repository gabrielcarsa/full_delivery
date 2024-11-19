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
use App\Http\Controllers\ClienteEnderecoController;
use App\Http\Controllers\CategoriaOpcionalController;
use App\Http\Controllers\FormaPagamentoLojaController;
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

Route::get('/', [CardapioController::class, 'index'])->name('cardapio');
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
        Route::get('/loja/abrir-fechar', [LojaController::class, 'abrir_fechar'])->name('loja.abrir_fechar');
       
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
        Route::get('/categoria_produto/JSON', [CategoriaProdutoController::class, 'indexJSON'])->name('categoria_produto.JSON');
        Route::get('/categoria_produto/importar-ifood', [CategoriaProdutoController::class, 'importarCardapioIfood'])->name('categoria_produto.importarCardapioIfood');

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
        
        //CATEGORIA OPCIONAL
        Route::get('/categoria_opcional', [CategoriaOpcionalController::class, 'index'])->name('categoria_opcional');
        Route::get('/categoria_opcional/novo', [CategoriaOpcionalController::class, 'create'])->name('categoria_opcional.novo');
        Route::post('/categoria_opcional/cadastrar/{produto_id}/{usuario_id}', [CategoriaOpcionalController::class, 'store']);
        Route::delete('/categoria_opcional/apagar/{id}', [CategoriaOpcionalController::class, 'destroy'])->name('categoria_opcional.excluir');

        //OPCIONAL PRODUTO
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
        Route::get('/gestor-pedidos', [PedidoController::class, 'gestor'])->name('pedido.gestor');
        Route::get('/gestor-pedidos/detalhes', [PedidoController::class, 'show'])->name('pedido.show');
        Route::get('/pedido/update-status', [PedidoController::class, 'update_status'])->name('pedido.update_status');
        Route::post('/pedido/cancelar', [PedidoController::class, 'cancelar'])->name('pedido.cancelar');
        Route::post('/pedido/pagamento-mesa', [PedidoController::class, 'pagamento_mesa'])->name('pedido.pagamento');
        Route::get('/pedido/adicionar-quantidade', [PedidoController::class, 'adicionar_quantidade'])->name('pedido.adicionar_quantidade');
        Route::get('/pedido/remover-quantidade', [PedidoController::class, 'remover_quantidade'])->name('pedido.remover_quantidade');
        Route::get('/pedido/deletar-item', [PedidoController::class, 'deletar_item'])->name('pedido.deletar_item');
        Route::get('/pedido/adicionar-item', [PedidoController::class, 'adicionar_item'])->name('pedido.adicionar_item');
        Route::get('/pedidos/atualizar', [PedidoController::class, 'refresh_pedidos'])->name('pedido.atualizar');
        Route::get('/pedidos/polling-ifood', [PedidoController::class, 'polling_ifood'])->name('pedido.polling');


        //CUPOM
        Route::get('/cupom', [CupomController::class, 'index'])->name('cupom');
        Route::get('/cupom/novo', [CupomController::class, 'create'])->name('cupom.novo');
        Route::post('/cupom/cadastrar', [CupomController::class, 'store']);
        Route::get('/cupom/editar', [CupomController::class, 'edit'])->name('cupom.editar');
        Route::put('/cupom/alterar/{cupom_id}', [CupomController::class, 'update']);
        Route::delete('/cupom/apagar/{id}', [CupomController::class, 'destroy'])->name('cupom.excluir');
        Route::get('/cupom/status', [CupomController::class, 'status'])->name('cupom.status');
        Route::get('/cupom/detalhes', [CupomController::class, 'show'])->name('cupom.show');

        //FORMAS DE PAGAMENTO LOJA
        Route::get('/forma-pagamento', [FormaPagamentoLojaController::class, 'index'])->name('forma_pagamento');
        Route::post('/forma-pagamento/cadastrar', [FormaPagamentoLojaController::class, 'store'])->name('forma_pagamento.cadastrar');

        //MESA
        Route::get('/mesa', [MesaController::class, 'index'])->name('mesa');
        Route::get('/mesa/novo', [MesaController::class, 'create'])->name('mesa.novo');
        Route::post('/mesa/cadastrar', [MesaController::class, 'store']);
        Route::delete('/mesa/apagar/{id}', [MesaController::class, 'destroy'])->name('mesa.excluir');
        Route::put('/mesa/mudar-mesa', [MesaController::class, 'mudar_mesa'])->name('mesa.mudar_mesa');

        Route::get('/gestor-mesas', [MesaController::class, 'gestor'])->name('mesa.gestor');
        Route::get('/gestor-mesas/detalhes', [MesaController::class, 'show'])->name('mesa.show');
        
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

        //SALDO
        Route::get('/saldo', [SaldoController::class, 'index'])->name('saldo.index');

});