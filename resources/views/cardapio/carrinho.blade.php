<x-layout-cardapio>

    <!-- NAVBAR CARRINHO -->
    <div class="d-flex p-0 fixed-top p-1 bg-light border shadow-sm">
        <a href="#" onclick="history.go(-1); return false;"
            class="btn btn-light rounded-circle d-flex align-items-center">
            <span class="material-symbols-outlined">
                arrow_back
            </span>
        </a>
        <div class="d-flex align-items-center justify-content-center" style="flex: 1;">
            <h2 class="fs-5 fw-bold">Carrinho de Compras</h2>
        </div>
    </div>
    <!-- FIM NAVBAR CARRINHO -->


    @if(empty($carrinho))

    <!-- CARRINHO VAZIO -->
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="m-5">
            <span class="material-symbols-outlined" style="font-size: 60px;">
                shopping_cart_off
            </span>
            <h3>Ops!</h3>
            <p>Parece que seu carrinho está vazio!</p>
            <a href="#" onclick="history.go(-1); return false;" class="btn btn-primary">Ir para cardápio</a>
        </div>
    </div>
    <!-- FIM CARRINHO VAZIO -->

    @else

    <!-- CARRINHO -->
    <div class="container">

        <!-- ROW CARRINHO -->
        <div class="row my-3" style="padding-top: 70px;">
            <div class="mt-3">
                <a href="{{ route('cardapio.esvaziarCarrinho') }}" class="btn btn-danger">Limpar
                    carrinho</a>
            </div>

            <!-- COLUNA CARRINHO -->
            <div class="col-md-8 p-3 bg-white">

                <h3 class="fw-bolder fs-3">Itens</h3>
                <hr>
                <!-- TABELA ITENS -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Qtd</th>
                            <th scope="col">Item</th>
                            <th scope="col">Preço unitário</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Variáveis PHP -->
                        @php
                        $valor_total = 0;

                        @endphp

                        <!-- Exibir itens do pedido -->
                        @foreach ($carrinho as $item)
                        @php
                        $valor_total += $item['produto']->preco;

                        @endphp

                        <!-- Incrementando sobre valor total -->

                        <tr class="p-0 m-0">
                            <td class="bg-white">
                                <span>
                                    1x
                                </span><br>
                                <span class="text-secondary">

                                </span>
                            </td>
                            <td class="bg-white">
                                <span class="fw-bold">
                                    {{ $item['produto']->nome }}
                                </span><br>
                                <span class="text-secondary">

                                </span>
                            </td>
                            <td class="bg-white">
                                <span>
                                    R$ {{number_format($item['produto']->preco, 2, ',', '.')}}
                                </span><br>
                                <span class="text-secondary">

                                </span>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>



                    </tfoot>

                </table>
                <!-- FIM TABELA ITENS -->

            </div>
            <!-- FIM COLUNA CARRINHO -->

            <!-- COLUNA RESUMO -->
            <div class="col-md-4 p-3 bg-light rounded">
                <h3 class="fw-bolder fs-3">Resumo</h3>
                <hr>
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingCupom" placeholder="Cupom">
                    <label for="floatingCupom">Cupom</label>
                </div>

                <div class="my-1">
                    <p class="fs-6 text-secondary m-0">
                        Total dos itens
                    </p>
                    <p class="m-0 fs-5 fw-semibold">
                        R$ {{number_format($valor_total, 2, ',', '.')}}
                    </p>
                </div>
                <div class="my-1">
                    <p class="fs-6 text-secondary m-0">
                        Entrega
                    </p>
                    <p class="m-0 fs-5 fw-semibold">
                        R$ 2,00
                    </p>
                </div>

                <div class="">
                    <a href="" class="btn btn-success">
                        Finalizar pedido
                    </a>
                </div>
            </div>
            <!-- FIM COLUNA RESUMO -->

        </div>
        <!-- FIM ROW CARRINHO -->

    </div>

    <!-- FIM CARRINHO -->

    @endif

    <!-- MENU APPBAR -->
    <x-appbar-cardapio :data="$data" />
    <!-- FIM MENU APPBAR -->

</x-layout-cardapio>