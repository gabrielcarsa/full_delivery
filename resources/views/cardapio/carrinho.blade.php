<x-layout-cardapio>

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
    <div class="container vh-100">

        <!-- ROW ENDEREÇO -->
        <h4 class="m-0 fs-5 fw-bold pt-3">Entrega em</h4>
        <div class="d-flex">
            <!-- ICONE LOCALIZACAO -->
            <div>
                <span class="material-symbols-outlined text-secondary">
                    location_on
                </span>
            </div>
            <!-- FIM ICONE LOCALIZACAO -->

            <!-- DROPDOWN ENDERECOS -->
            <div class="dropdown mb-2">
                <a class="text-secondary text-decoration-none dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <!--SE HOUVER ENDEREÇO SELECIONADO-->
                    @if($data['endereco_selecionado'] == null)

                    Selecione endereço entrega

                    <!--SE NÃO HOUVER ENDEREÇO SELECIONADO-->
                    @else

                    <!--EXIBIR APENAS SELECIONADO-->
                    @foreach($data['cliente_enderecos'] as $endereco)
                    @if($endereco->id == $data['endereco_selecionado'])

                    {{$endereco->rua}}, {{$endereco->numero}}

                    @endif
                    @endforeach
                    <!--FIM EXIBIR APENAS SELECIONADO-->

                    @endif
                    <!--FIM SE HOUVER ENDEREÇO SELECIONADO-->
                </a>

                <ul class="dropdown-menu" style="font-size: 13px">
                    @foreach($data['cliente_enderecos'] as $endereco)
                    @if($endereco != $data['endereco_selecionado'])
                    <li>
                        <a class="dropdown-item"
                            href="{{ route('cardapio', ['loja_id' => $data['loja_id'], 'consumo_local_viagem' => 3, 'endereco_selecionado' => $endereco->id]) }}">
                            <span class="fw-bold">
                                {{$endereco->nome}}
                            </span> - {{$endereco->rua}}
                            {{$endereco->numero}}
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
            <!-- FIM DROPDOWN ENDERECOS -->

        </div>
        <!-- FIM ENDEREÇO -->

        <!-- ROW CARRINHO -->
        <div class="row my-3">

            <!-- COLUNA CARRINHO -->
            <div class="col-md-8 p-3 bg-white">

                <div class="row">
                    <h3 class="fw-bolder fs-3">Itens</h3>
                    <div class="">
                        <a href="{{ route('cardapio.esvaziarCarrinho') }}" class="btn btn-danger">
                            Limpar carrinho
                        </a>
                    </div>
                </div>
                <hr>
                <!-- TABELA ITENS -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Qtd</th>
                            <th scope="col">Item</th>
                            <th scope="col">Preço</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Variáveis PHP -->
                        @php
                        $subtotal = 0;

                        @endphp

                        <!-- Exibir itens do pedido -->
                        @foreach ($carrinho as $item)
                        @php
                        $subtotal += $item['produto']->preco;

                        @endphp

                        <!-- Incrementando sobre valor total -->

                        <tr class="p-0 m-0">
                            <td class="bg-white">
                                <span>
                                    {{ $item['quantidade'] }}x
                                </span>
                            </td>
                            <td class="bg-white">
                                <span class="fw-bold text-trucante">
                                    {{ $item['produto']->nome }}
                                </span><br>
                                <span class="text-secondary">
                                    @foreach($item['opcionais'] as $opcional)
                                    <p class="m-0">
                                        {{$opcional->nome}}
                                    </p>
                                    @endforeach
                                </span>
                                <span class="text-secondary">
                                    <p class="m-0">
                                        OBS.: {{$item['observacao']}}
                                    </p>
                                </span>
                            </td>
                            <td class="bg-white">
                                <span>
                                    R$ {{number_format($item['produto']->preco, 2, ',', '.')}}
                                </span><br>
                                <span class="text-secondary">
                                    @foreach($item['opcionais'] as $opcional)
                                    @php
                                    $subtotal += $opcional->preco;
                                    @endphp
                                    <p class="m-0">
                                        R$ {{number_format($opcional->preco, 2, ',', '.')}}
                                    </p>
                                    @endforeach
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
                        Subtotal
                    </p>
                    <p class="m-0 fs-6 fw-medium">
                        R$ {{number_format($subtotal, 2, ',', '.')}}
                    </p>
                </div>
                <div class="my-1">
                    <p class="fs-6 text-secondary m-0">
                        Entrega
                    </p>
                    <p class="m-0 fs-6 fw-medium">
                        R$ {{number_format($data['taxa_entrega'], 2, ',', '.')}}
                    </p>
                </div>
                <div class="my-1">
                    <p class="fs-6 text-dark m-0">
                        Total
                    </p>
                    <p class="m-0 fs-5 fw-bold">
                        R$ {{number_format($data['taxa_entrega'] + $subtotal, 2, ',', '.')}}
                    </p>
                </div>

                <div class="my-2">
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