    <!-- MENU APPBAR -->
    <div class="fixed-bottom bg-white border-top p-2">
        <ul class="nav justify-content-around">

            <!-- ITEM APPBAR -->
            <li class="nav-item">
                <a class="m-0 p-0 nav-link d-flex flex-column align-items-center {{ request()->routeIs('cardapio') ? 'text-reset' : 'text-secondary'}}"
                    href="{{ route('cardapio', ['loja_id' => request('loja_id'), 'consumo_local_viagem_delivery' => request('consumo_local_viagem_delivery'), 'endereco_selecionado' =>  request('endereco_selecionado')]) }}" style="font-size:13px">
                    <span class="material-symbols-outlined">
                        menu_book
                    </span>
                    <span>
                        Cardápio
                    </span>
                </a>
            </li>
            <!-- FIM ITEM APPBAR -->

            <!-- ITEM APPBAR -->
            <li class="nav-item">
                <a class="m-0 p-0 nav-link d-flex flex-column align-items-center {{ request()->routeIs('cardapio.carrinho') ? 'text-reset' : 'text-secondary'}}"
                    href="{{ route('cardapio.carrinho', ['loja_id' => request('loja_id'), 'consumo_local_viagem_delivery' => request('consumo_local_viagem_delivery'), 'endereco_selecionado' =>  request('endereco_selecionado'), 'endereco_selecionado' =>  request('endereco_selecionado')]) }}" style="font-size:13px">
                    <span class="material-symbols-outlined">
                        shopping_cart
                    </span>
                    <span>
                        Carrinho
                    </span>
                </a>
            </li>
            <!-- FIM ITEM APPBAR -->

            <!-- ITEM APPBAR -->
            <li class="nav-item">
                <a class="m-0 p-0 nav-link d-flex flex-column align-items-center {{ request()->routeIs('pedido.pedidoCliente') ? 'text-reset' : 'text-secondary'}}"
                    href="{{ route('pedido.pedidoCliente', ['loja_id' => request('loja_id'), 'consumo_local_viagem_delivery' => request('consumo_local_viagem_delivery'), 'endereco_selecionado' =>  request('endereco_selecionado'), 'endereco_selecionado' =>  request('endereco_selecionado')]) }}" style="font-size:13px">
                    <span class="material-symbols-outlined">
                        receipt_long
                    </span>
                    <span>
                        Pedidos
                    </span>
                </a>
            </li>
            <!-- FIM ITEM APPBAR -->

            <!-- ITEM APPBAR -->
            <li class="nav-item">
                <a class="m-0 p-0 nav-link d-flex flex-column align-items-center {{ request()->routeIs('cliente.area') ? 'text-reset' : 'text-secondary'}}"
                    href="{{ route('cliente.area', ['loja_id' => request('loja_id'), 'consumo_local_viagem_delivery' => request('consumo_local_viagem_delivery'), 'endereco_selecionado' =>  request('endereco_selecionado')]) }}" style="font-size:13px">
                    <span class="material-symbols-outlined">
                        account_circle
                    </span>
                    <span>
                        Conta
                    </span>
                </a>
            </li>
            <!-- FIM ITEM APPBAR -->

        </ul>
    </div>
    <!-- FIM MENU APPBAR -->