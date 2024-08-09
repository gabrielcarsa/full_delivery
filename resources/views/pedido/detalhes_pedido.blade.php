<x-layout-cardapio>

    <!-- NAVBAR PRODUTO -->
    <div class="d-flex bg-white fixed-top p-2">
        <a href="#" onclick="history.go(-1); return false;"
            class="text-dark text-decoration-none d-flex align-items-center m-0">
            <span class="material-symbols-outlined">
                arrow_back
            </span>
        </a>
        <div class="d-flex align-items-center justify-content-center" style="flex: 1;">
            <h2 class="fs-6 fw-bold">Detalhes do pedido</h2>
        </div>
    </div>
    <!-- FIM NAVBAR PRODUTO -->

    <!-- CONTAINER -->
    <div class="container my-5">

        <!-- PREVISÃO -->
        <div class="py-3">
            <p class="text-secondary m-0">
                Previsão de entrega
            </p>
            <p class="text-black m-0 fs-5">
                12:30 - 13:20
            </p>
        </div>
        <!-- FIM PREVISÃO -->

        <!--  LOJA -->
        <div class="d-flex border p-3 rounded">
            <div class="d-flex align-items-center justify-content-center">
                <img src="{{ asset('storage/' . $data['pedido']->loja->nome . '/' . $data['pedido']->loja->logo) }}"
                    class="rounded-circle" style="max-width: 50px;">
            </div>
            <div class="ml-2">
                <p class="m-0 fw-semibold">{{$data['pedido']->loja->nome}}</p>
                <p class="m-0 text-secondary texto-truncate-100w text-truncate">{{$data['pedido']->loja->rua}},
                    {{$data['pedido']->loja->numero}}</p>
            </div>
        </div>
        <!--  FIM LOJA -->


        <!-- ETAPAS STATUS -->
        <div class="d-flex align-items-center bg-light rounded mb-3 mt-5 justify-content-between" style="height: 20px">

            <!-- PEDIDO PENDENTE -->
            <div class="bg-light rounded-circle"
                style="height: 70px; width: 70px; background-color: #FD0146 !important">
                <div class="m-0 d-flex align-items-center justify-content-center" style="height: 70px; width: 70px">
                    <span class="material-symbols-outlined fs-1 text-white">
                        {{ $data['pedido']->status > 0 ? 'check_circle' : 'hourglass_top' }}
                    </span>
                </div>
                <p class="text-truncate d-flex align-items-center justify-content-center"
                    style="font-size: 13px; max-width: 100px">
                    Pendente
                </p>
            </div>
            <!-- FIM PEDIDO PENDENTE -->

            <!-- PEDIDO PREPARANDO -->
            @if($data['pedido']->status >= 1)
            <div class="bg-light rounded-circle"
                style="height: 70px; width: 70px; background-color: #FD0146 !important">
                <div class="m-0 d-flex align-items-center justify-content-center" style="height: 70px; width: 70px">
                    <span class="material-symbols-outlined fs-1 text-white">
                        {{ $data['pedido']->status > 1 ? 'check_circle' : 'skillet' }}
                    </span>
                </div>
                <p class="text-truncate d-flex align-items-center justify-content-center"
                    style="font-size: 13px; max-width: 100px">Preparando</p>
            </div>
            @else
            <div class="bg-light rounded-circle" style="height: 70px; width: 70px">
                <div class="m-0 d-flex align-items-center justify-content-center" style="height: 70px; width: 70px">
                    <span class="material-symbols-outlined fs-1">
                        skillet
                    </span>
                </div>
                <p class="text-truncate d-flex align-items-center justify-content-center"
                    style="font-size: 13px; max-width: 100px">Preparando</p>
            </div>
            @endif
            <!-- FIM PEDIDO PREPARANDO -->

            <!-- PEDIDO ENTREGA -->
            @if($data['pedido']->status >= 2)
            <div class="bg-light rounded-circle"
                style="height: 70px; width: 70px; background-color: #FD0146 !important">
                <div class="m-0 d-flex align-items-center justify-content-center" style="height: 70px; width: 70px">
                    <span class="material-symbols-outlined fs-1 text-white">
                        {{ $data['pedido']->status > 2 ? 'check_circle' : 'sports_motorsports' }}
                    </span>
                </div>
                <p class="text-truncate d-flex align-items-center justify-content-center"
                    style="font-size: 13px; max-width: 100px">A caminho</p>
            </div>
            @else
            <div class="bg-light rounded-circle" style="height: 70px; width: 70px">
                <div class="m-0 d-flex align-items-center justify-content-center" style="height: 70px; width: 70px">
                    <span class="material-symbols-outlined fs-1">
                        sports_motorsports
                    </span>
                </div>
                <p class="text-truncate d-flex align-items-center justify-content-center"
                    style="font-size: 13px; max-width: 100px">A caminho</p>
            </div>
            @endif
            <!-- FIM PEDIDO ENTREGA -->

            <!-- PEDIDO CONCLUIDO -->
            @if($data['pedido']->status >= 3)
            <div class="bg-success rounded-circle" style="height: 70px; width: 70px">
                <div class="m-0 d-flex align-items-center justify-content-center" style="height: 70px; width: 70px">
                    <span class="material-symbols-outlined fs-1 text-white">
                        {{ $data['pedido']->status > 3 ? 'check_circle' : 'check_circle' }}
                    </span>
                </div>
                <p class="text-truncate d-flex align-items-center justify-content-center"
                    style="font-size: 13px; max-width: 100px">Concluído</p>
            </div>
            @else
            <div class="bg-light rounded-circle" style="height: 70px; width: 70px">
                <div class="m-0 d-flex align-items-center justify-content-center" style="height: 70px; width: 70px">
                    <span class="material-symbols-outlined fs-1">
                        check_circle
                    </span>
                </div>
                <p class="text-truncate d-flex align-items-center justify-content-center"
                    style="font-size: 13px; max-width: 100px">Concluído</p>
            </div>
            @endif
            <!-- FIM PEDIDO ENTREGA -->
        </div>
        <!--  FIM ETAPAS STATUS -->

        <!-- ENTREGA -->
        <div class="" style="margin: 70px 0 0 0">
            <h3 class="fw-bolder fs-6">Endereço de entrega</h3>
            <p class="text-black m-0">
                {{$data['pedido']->entrega->rua}}, {{$data['pedido']->entrega->numero}}.
            </p>
            <p class="text-black m-0">
                {{$data['pedido']->entrega->bairro}} - {{$data['pedido']->entrega->cidade}}
                {{$data['pedido']->entrega->estado}}
            </p>
            <p class="text-black m-0">
                {{$data['pedido']->entrega->complemento}}
            </p>
        </div>
        <!-- FIM ENTREGA -->

        <!-- LISTA -->
        <ul class="list-group list-group-flush my-3">

            <!-- TITULO -->
            <div class="">
                <h3 class="fw-bolder fs-6">Itens</h3>
            </div>
            <!-- FIM TITULO -->

            <!-- Variáveis PHP -->
            @php
            $subtotal = 0;
            @endphp

            <!-- ITEM -->
            @foreach ($data['pedido']->item_pedido as $item)

            <!-- Incrementando sobre valor total -->
            @php
            $subtotal += $item['produto']->preco * $item['quantidade'];
            @endphp

            <!-- ITEM -->
            <li class="list-group-item m-0">

                <!-- PRODUTO -->
                <div class="row">
                    <div class="col">
                        <div class="d-flex">
                            <!-- IMAGEM PRODUTO -->
                            <div class="d-flex align-items-center ">
                                <img src="{{ asset('storage/'.$item['pedido']->loja->nome.'/imagens_produtos/'.$item['produto']->imagem) }}"
                                    class="rounded" alt="{{$item['produto']->nome}}"
                                    style="min-width: 50px !important; max-width: 50px !important">
                            </div>
                            <!-- FIM IMAGEM PRODUTO -->
                            <div class="mx-2">
                                <p class="m-0 fw-semibold">
                                    {{ $item['produto']->nome }}
                                </p>
                                <p class="m-0">
                                    R$ {{number_format($item['produto']->preco, 2, ',', '.')}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col d-flex justify-content-end w-100">
                        <p class="m-0 fw-semibold">{{$item['quantidade']}}x</p>
                    </div>
                </div>
                <!-- FIM PRODUTO -->

                <!-- SE HOUVER OPCIONAIS -->
                @if(!$item['produto']->categoria_opcional->isEmpty())
                <div class="p-0 m-0 bg-light p-2 rounded">

                    <!-- CATEGORIAS DE OPCIONAIS -->
                    @foreach($item['produto']->categoria_opcional as $categoria_opcional)

                    <!-- OPCIONAIS -->
                    @foreach($categoria_opcional->opcional_produto as $opcional)
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
                    <!-- FIM SE HOUVER OPCIONAIS -->

                    @endforeach
                    <!-- FIM CATEGORIAS DE OPCIONAIS -->

                </div>
                @endif
                <!-- FIM OPCIONAIS -->

                <!-- OBSERVAÇÃO -->
                @if($item['observacao'] != null)
                <p class="">
                    Obs.: {{$item['observacao']}}
                </p>
                @endif
                <!-- FIM OBSERVAÇÃO -->

            </li>

            @endforeach
            <!-- FIM ITEM -->

        </ul>
        <!-- FIM LISTA -->

        <!-- TITULO -->
        <div class="">
            <h3 class="fw-bolder fs-6">Resumo</h3>
        </div>
        <!-- FIM TITULO -->

        <!-- TOTAIS -->
        <div class="px-3">
            <div class="d-flex">
                <div class="d-flex align-items-center">
                    <p class="fs-6 text-dark m-0">
                        Subtotal
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-end w-100">
                    <p class="m-0 fs-6">
                        R$ {{number_format($subtotal, 2, ',', '.')}}
                    </p>
                </div>
            </div>
            <div class="d-flex">
                <div class="d-flex align-items-center">
                    <p class="fs-6 text-dark m-0">
                        Entrega
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-end w-100">
                    <p class="m-0 fs-6">
                        R$ {{number_format($data['pedido']->entrega->taxa_entrega, 2, ',', '.')}}
                    </p>
                </div>
            </div>
            <div class="d-flex">
                <div class="d-flex align-items-center">
                    <p class="fs-6 text-dark m-0">
                        Descontos
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-end w-100">
                    <p class="m-0 fs-6">
                        R$ 0,00
                    </p>
                </div>
            </div>
            <div class="d-flex">
                <div class="d-flex align-items-center">
                    <p class="fs-6 fw-bold m-0">
                        Total
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-end w-100">
                    <p class="m-0 fs-6 fw-bold">
                        R$ {{number_format($data['pedido']->total, 2, ',', '.')}}
                    </p>
                </div>
            </div>
        </div>
        <!-- FIM TOTAIS -->

        <!-- PAGAMENTO -->
        <div class="my-3">
            <h3 class="fw-bolder fs-6">Pagar na entrega</h3>
            <div class="d-flex">
                <span class="material-symbols-outlined text-secondary mr-1">
                    credit_card
                </span>
                <p class="text-secondary m-0">
                    Cartão de crédito
                </p>
            </div>

        </div>
        <!-- FIM ENTREGA -->

    </div>
    <!-- FIM CONTAINER -->



</x-layout-cardapio>