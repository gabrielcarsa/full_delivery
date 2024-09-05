<div class="my-3">

    <!-- HEADER MESA DETALHES -->
    <div class="d-flex justify-content-between align-items-center border p-3 rounded">
        <h4 class="m-0 fw-bold text-black">
            Mesa {{$data['mesa']->nome}}
        </h4>
        <div class="d-flex align-items-center">
            <p class="my-0 mx-1">
                <span class="fw-bold">
                    Tempo:
                </span>
                @if($data['mesa']->hora_abertura != null)
                {{$data['mesa']->hora_abertura}}
                @else
                00h00m
                @endif
            </p>
            <p class="my-0 mx-1">
                <span class="fw-bold">
                    Qtd de itens:
                </span>
                0
            </p>

            <div class="dropdown">
                <a class="btn border d-flex align-items-center ml-2" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span class="material-symbols-outlined">
                        more_vert
                    </span>
                </a>

                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>

        </div>
    </div>
    <!-- HEADER MESA DETALHES -->

    <!-- PEDIDO -->
    <div class="p-3 my-2">
        <p class="fw-bolder fs-5 m-0 p-0">Pedido</p>

        <div class="px-3 py-1 m-2">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Item</th>
                        <th scope="col">Preço unitário</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                @foreach ($data['pedidos'] as $pedido)

                <tbody>
                    <!-- Variáveis PHP -->
                    @php
                    $total_sem_entrega = 0;
                    @endphp

                    <!-- Exibir itens do pedido -->
                    @foreach ($pedido->item_pedido as $item)

                    <!-- Incrementando sobre valor total -->
                    @php
                    $total_sem_entrega += $item->subtotal;
                    @endphp

                    @if($pedido->nome_cliente == null)
                    {{$pedido->cliente->nome }}
                    @else
                    {{$pedido->nome_cliente }}
                    @endif
                    
                    <tr class="p-0 m-0">
                        <td class="bg-white">
                            <span>
                                {{ $item->quantidade }}x
                            </span><br>
                        </td>
                        <td class="bg-white">
                            <span class="fw-bold">
                                {{ $item->produto->nome }}
                            </span>
                        </td>
                        <td class="bg-white">
                            <span>
                                R$ {{number_format($item->preco_unitario, 2, ',', '.')}}
                            </span>
                        </td>
                        <td class="bg-white">
                            <span>
                                R$ {{number_format($item->subtotal, 2, ',', '.')}}
                            </span>
                        </td>
                        <td class="bg-white">
                            <div class="dropdown">
                                <a class="btn d-flex align-items-center ml-2" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">
                                        more_vert
                                    </span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    @if(!$item->produto->categoria_opcional->isEmpty())
                    <tr style="font-size:14px">
                        <td></td>
                        <td>

                            <!-- CATEGORIAS DE OPCIONAIS -->
                            @foreach ($item->produto->categoria_opcional as $categoria_opcional)

                            <!-- VERIFICAR SE EXISTE ALGUM OPCIONAL RELACIONADO A ESTA CATEGORIA -->
                            @php

                            // Filtra os opcionais do item_pedido que pertencem à categoria atual

                            $opcionais_relacionados = $item->opcional_item->filter(function($opcional_item) use
                            ($categoria_opcional) {
                            return $categoria_opcional->opcional_produto->contains('id',
                            $opcional_item->opcional_produto_id);
                            });

                            @endphp

                            @if($opcionais_relacionados->isNotEmpty())
                            <p class="col-6 fw-bold m-0 text-secondary">{{$categoria_opcional->nome}}</p>

                            <!-- OPCIONAIS -->
                            @foreach($opcionais_relacionados as $opcional_item)

                            <!-- VERIFICAR OPCIONAIS -->
                            @php
                            // Obter os detalhes do opcional_produto relacionado
                            $opcional_produto = $categoria_opcional->opcional_produto->firstWhere('id',
                            $opcional_item->opcional_produto_id);
                            @endphp

                            <p class="m-0 text-secondary">
                                {{$opcional_produto->nome}}
                            </p>

                            <!-- Incrementando sobre valor total -->
                            @php
                            $total_sem_entrega += $opcional_item->preco_unitario * $item->quantidade;
                            @endphp
                            @endforeach
                            <!-- FIM OPCIONAIS -->
                            @endif

                            @endforeach
                            <!-- FIM CATEGORIAS DE OPCIONAIS -->

                        </td>
                        <td>
                            <!-- CATEGORIAS DE OPCIONAIS -->
                            @foreach ($item->produto->categoria_opcional as $categoria_opcional)
                            <!-- OPCIONAIS -->
                            @foreach($categoria_opcional->opcional_produto as $opcional)

                            <!-- VERIFICAR OPCIONAIS -->
                            @php
                            // Verifica se o opcional está relacionado ao item_pedido
                            $opcional_item = $item['opcional_item']->firstWhere('opcional_produto_id', $opcional->id);
                            @endphp

                            @if($opcional_item)
                            <p class="text-secondary">
                                + R$ {{number_format($opcional->preco, 2, ',', '.')}}
                            </p>
                            @endif

                            @endforeach
                            <!-- FIM OPCIONAIS -->

                            @endforeach
                            <!-- FIM CATEGORIAS DE OPCIONAIS -->
                        </td>
                        <td>
                            <!-- CATEGORIAS DE OPCIONAIS -->
                            @foreach ($item->produto->categoria_opcional as $categoria_opcional)
                            <!-- OPCIONAIS -->
                            @foreach($categoria_opcional->opcional_produto as $opcional)

                            <!-- VERIFICAR OPCIONAIS -->
                            @php
                            // Verifica se o opcional está relacionado ao item_pedido
                            $opcional_item = $item['opcional_item']->firstWhere('opcional_produto_id', $opcional->id);
                            @endphp

                            @if($opcional_item)
                            <p class="text-secondary">
                                + R$ {{number_format($opcional->preco * $item->quantidade, 2, ',', '.')}}
                            </p>
                            @endif

                            @endforeach
                            <!-- FIM OPCIONAIS -->

                            @endforeach
                            <!-- FIM CATEGORIAS DE OPCIONAIS -->
                        </td>
                        <td></td>
                    </tr>
                    @endif

                    @endforeach

                </tbody>
                @endforeach

            </table>

        </div>

    </div>
    <!-- FIM PEDIDO -->
</div>