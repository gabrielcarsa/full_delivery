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
        @if($data['pedido']->consumo_local_viagem_delivery == 3)
        <div class="py-1">
            <p class="text-secondary m-0">
                Previsão de entrega
            </p>
            <p class="text-black m-0 fs-5">
                12:30 - 13:20
            </p>
        </div>
        @endif
        <!-- FIM PREVISÃO -->

        <!-- MESA E CLIENTE -->
        @if($data['pedido']->consumo_local_viagem_delivery == 1)
        <div class="py-1">
            <p class="text-secondary m-0">
                Mesa
            </p>
            <p class="text-black m-0 fs-5">
                {{$data['pedido']->mesa->nome}}
            </p>
        </div>
        @endif
        <!-- FIM MESA E CLIENTE -->

        <!-- CLIENTE NÃO LOGADO -->
        @if($data['pedido']->cliente_id == null)
        <div class="py-1">
            <p class="text-secondary m-0">
                Nome e sobrenome
            </p>
            <p class="text-black m-0 fs-5">
                {{$data['pedido']->nome_cliente}}
            </p>
        </div>
        @endif
        <!-- FIM CLIENTE NÃO LOGADO -->

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

        <!--  PEDIDO REJEITADO, CANCELADO OU NORMAL -->
        @if($data['pedido']->status == 4 || $data['pedido']->status == 5 )

        <div class="p-3 my-3 border rounded bg-light">
            <div class="d-flex align-items-center">
                <span class="material-symbols-outlined text-danger fw-semibold mr-1">
                    error
                </span>
                <p class="m-0 text-danger fw-semibold">
                    {{$data['pedido']->status == 4 ? 'Pedido Rejeitado' : 'Pedido Cancelado'}}
                </p>
            </div>
            <p class="mb-0 mt-2">
                {{$data['pedido']->mensagem_cancelamento_rejeicao}}
            </p>
        </div>

        @else

        <!-- ETAPAS STATUS -->
        <div class="d-flex align-items-center justify-content-between my-3">

            <!-- PEDIDO PENDENTE -->
            <div class="{{$data['pedido']->status == 0 ? 'text-black' : 'text-secondary'}}">
                <div class="m-0">
                    @if($data['pedido']->status > 0)
                    <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                        check_circle
                    </span>
                    @else
                    <p class="m-0 fs-1 fw-bolder {{ $data['pedido']->status > 0 ? 'text-padrao' : '' }}">
                        1.
                    </p>
                    @endif
                </div>
                <p class="m-0" style="font-size: 13px !important">
                    Pendente
                </p>
            </div>
            <!-- FIM PEDIDO PENDENTE -->

            <!-- LINHA INTERMEDIARIA -->
            <div class="{{ $data['pedido']->status > 0 ? 'bg-padrao' : 'bg-light border' }} rounded" style="width: 100% !important; height: 5px;">
            </div>
            <!-- FIM LINHA INTERMEDIARIA -->

            <!-- PEDIDO PREPARANDO -->
            <div class="ms-3 {{$data['pedido']->status == 1 ? 'text-black' : 'text-secondary'}}">
                <div class="m-0">
                    @if($data['pedido']->status > 1)
                    <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                        check_circle
                    </span>
                    @else
                    <p class="m-0 fs-1 fw-bolder {{ $data['pedido']->status > 1 ? 'text-padrao' : '' }}">
                        2.
                    </p>
                    @endif
                </div>
                <p class="m-0" style="font-size: 13px !important">
                    Preparando
                </p>
            </div>
            <!-- FIM PEDIDO PREPARANDO -->

            <!-- LINHA INTERMEDIARIA -->
            <div class="{{ $data['pedido']->status > 1 ? 'bg-padrao' : 'bg-light border' }} rounded m-1" style="width: 100% !important; height: 5px;">
            </div>
            <!-- FIM LINHA INTERMEDIARIA -->

            <!-- PEDIDO ENTREGA -->
            @if($data['pedido']->consumo_local_viagem_delivery == 3)

            <div class="ms-3 {{$data['pedido']->status == 2 ? 'text-black' : 'text-secondary'}}">
                <div class="m-0">
                    @if($data['pedido']->status > 2)
                    <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                        check_circle
                    </span>
                    @else
                    <p class="m-0 fs-1 fw-bolder {{ $data['pedido']->status > 2 ? 'text-padrao' : '' }}">
                        3.
                    </p>
                    @endif
                </div>
                <p class="m-0" style="font-size: 13px !important">
                    A caminho
                </p>
            </div>

            <!-- LINHA INTERMEDIARIA -->
            <div class="{{ $data['pedido']->status > 2 ? 'bg-padrao' : 'bg-light border' }} rounded m-1" style="width: 100% !important; height: 5px;">
            </div>
            <!-- FIM LINHA INTERMEDIARIA -->

            @endif
            <!-- FIM PEDIDO ENTREGA -->

            <!-- PEDIDO CONCLUIDO -->
            <div class="{{$data['pedido']->status == 3 ? 'text-black' : 'text-secondary'}}">
                <div class="m-0">
                    @if($data['pedido']->status > 2)
                    <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                        check_circle
                    </span>
                    @else
                    <p class="m-0 fs-1 fw-bolder {{ $data['pedido']->status > 2 ? 'text-padrao' : '' }}">
                        {{ $data['pedido']->consumo_local_viagem_delivery == 3 ? '4.' : '3.' }}
                    </p>
                    @endif
                </div>
                <p class="m-0" style="font-size: 13px !important">
                    Concluído
                </p>
            </div>
            <!-- FIM PEDIDO ENTREGA -->

        </div>
        <!--  FIM ETAPAS STATUS -->

        @endif
        <!--  FIM PEDIDO REJEITADO, CANCELADO OU NORMAL -->

        <!-- ENTREGA -->
        @if($data['pedido']->consumo_local_viagem_delivery == 3)
        <div class="">
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
        @endif
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

                    <!-- VERIFICAR OPCIONAIS -->
                    @php
                    // Verifica se o opcional está relacionado ao item_pedido
                    $opcional_item = $item['opcional_item']->firstWhere('opcional_produto_id', $opcional->id);
                    @endphp

                    @if($opcional_item)
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
                            R$ {{number_format($opcional_item->preco_unitario, 2, ',', '.')}}
                        </p>
                    </div>
                    <!-- Incrementando sobre valor total -->
                    @php
                    $subtotal += $opcional_item->preco_unitario * $item['quantidade'];;
                    @endphp

                    @endif

                    @endforeach
                    <!-- OPCIONAIS -->

                    @endforeach
                    <!-- CATEGORIAS DE OPCIONAIS -->

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


        <!-- TOTAIS -->

        <!-- TITULO -->
        <div class="">
            <h3 class="fw-bolder fs-6">Resumo</h3>
        </div>
        <!-- FIM TITULO -->

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
            @if($data['pedido']->consumo_local_viagem_delivery == 3)
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
            @endif
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
        @if($data['pedido']->consumo_local_viagem_delivery == 3)
        <div class="mx-0 my-3">

            <!-- FORMA PAGAMENTO -->
            @if($data['pedido']->forma_pagamento_loja->id != null)

            <h3 class="fw-bolder fs-6">
                Pagar na entrega
            </h3>
            <div class="d-flex align-items-center" style="font-size: 14px !important">
                <img src="{{ asset('storage/icones-forma-pagamento/' .$data['pedido']->forma_pagamento_loja->imagem . '.svg') }}"
                    alt="" width="30px">
                <p class="p-0 mx-1 my-0">{{$data['pedido']->forma_pagamento_loja->nome}}</p>
            </div>

            @else

            <h3 class="fw-bolder fs-6">
                Pago via web
            </h3>
            <div class="d-flex align-items-center" style="font-size: 14px !important">
                <img src="{{ asset('storage/icones-forma-pagamento/' .$data['pedido']->forma_pagamento_foomy->imagem . '.svg') }}"
                    alt="" width="30px">
                <p class="p-0 mx-1 my-0">{{$data['pedido']->forma_pagamento_foomy->nome}}</p>
            </div>

            @endif
            <!-- FIM FORMA PAGAMENTO -->


        </div>
        @endif
        <!-- FIM PAGAMENTO -->

    </div>
    <!-- FIM CONTAINER -->

</x-layout-cardapio>