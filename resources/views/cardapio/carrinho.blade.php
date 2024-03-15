<x-layout-cardapio>
    <div class="container">
        <h1 class="mt-5 mb-4">Carrinho de Compras</h1>
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        Itens no Carrinho
                    </div>
                    <div class="card-body">
                        <!-- Aqui você pode adicionar itens dinamicamente do seu backend -->
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Item 1
                                <span class="badge badge-primary badge-pill">1</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Item 2
                                <span class="badge badge-primary badge-pill">2</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Item 3
                                <span class="badge badge-primary badge-pill">1</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        Resumo do Pedido
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total
                                <span class="badge badge-primary badge-pill">$50.00</span>
                            </li>
                        </ul>
                        <button class="btn btn-success btn-block mt-3">Finalizar Compra</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="app-bar fixed-bottom bg-white border-top p-2">
        <div class="container">
            <ul class="nav justify-content-around">
                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center {{ request()->routeIs('cardapio') ? 'text-reset' : 'text-secondary'}}"
                        href="{{ route('cardapio', ['restaurante_id' => request('restaurante_id')]) }}">
                        <i class="fa-solid fa-book-open"></i> <span>Cardápio</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center {{ request()->routeIs('pedidos') ? 'text-reset' : 'text-secondary'}}"
                        href="#">
                        <i class="fa-solid fa-receipt"></i><span>Pedidos</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center {{ request()->routeIs('conta') ? 'text-reset' : 'text-secondary'}}"
                        href="#">
                        <i class="fa-solid fa-user"></i><span>Conta</span></a>

                </li>
            </ul>
        </div>
    </div>
    
</x-layout-cardapio>