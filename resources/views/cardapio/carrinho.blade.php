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
    <div class="container">

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

        <!-- ITENS -->
        <div class="my-3">
            <h3 class="fw-bolder fs-3">Itens</h3>

            <!-- LISTA -->
            <ul class="list-group list-group-flush my-3">

                <!-- Variáveis PHP -->
                @php
                $subtotal = 0;
                @endphp

                <!-- ITEM -->
                @foreach ($carrinho as $item)

                <!-- Incrementando sobre valor total -->
                @php
                $subtotal += $item['produto']->preco * $item['quantidade'];
                @endphp

                <!-- ITEM -->
                <li class="list-group-item">

                    <!-- PRODUTO -->
                    <div class="d-flex">
                        <div class="">
                            <p class="m-0 fw-semibold">
                                {{ $item['produto']->nome }}
                            </p>
                            <p class="m-0 text-secondary text-truncate" style="max-width: 200px;">
                                {{ $item['produto']->descricao }}
                            </p>
                            <p class="m-0 fw-semibold">
                                R$ {{number_format($item['produto']->preco, 2, ',', '.')}}
                            </p>
                        </div>
                        <div class="d-flex justify-content-end w-100">
                            <p class="m-0 fw-semibold">{{$item['quantidade']}}x</p>
                        </div>
                    </div>
                    <!-- FIM PRODUTO -->

                    <!-- OPCIONAIS -->
                    @if($item['opcionais'] != null)
                    <div class="p-0 m-0 bg-light p-2 rounded">
                        @foreach($item['opcionais'] as $opcional)
                        <div class="d-flex m-0">
                            <div class="d-flex align-items-center">
                                <span class="material-symbols-outlined fs-5" style="color: #FD0146 !important">
                                    add
                                </span>
                            </div>
                            <p class="m-0 d-flex align-items-center text-secondary">
                                {{$opcional->nome}}
                            </p>
                            <p class="text-secondary d-flex align-items-center justify-content-end w-100 m-0">
                                @php
                                $subtotal += $opcional->preco;
                                @endphp

                                R$ {{number_format($opcional->preco, 2, ',', '.')}}
                            </p>
                        </div>

                        @endforeach
                    </div>
                    @endif
                    <!-- FIM OPCIONAIS -->

                    <!-- OBSERVAÇÃO -->
                    @if($item['observacao'] != null)
                    <p class="">
                        OBS.: {{$item['observacao']}}
                    </p>
                    @endif
                    <!-- FIM OBSERVAÇÃO -->

                </li>

                @endforeach
                <!-- FIM ITEM -->


            </ul>
            <!-- FIM LISTA -->

        </div>
        <!-- ITENS -->


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