<!-- HEADER -->
<div class="my-3">
    <div class="row m-0 p-0 d-flex align-items-center">
        <div class="col-md-auto">
            <h5 class="fw-bold fs-3 m-0 p-0">{{ $pedido->cliente->nome }}</h5>
        </div>
        <div class="col d-flex align-items-center justify-content-center">
            <span class="material-symbols-outlined mr-2">
                storefront
            </span>
            {{ $pedido->restaurante->nome }}
        </div>
        <div class="col d-flex justify-content-end">
            <p class="m-0 p-0">Feito às {{\Carbon\Carbon::parse($pedido->data_pedido)->format('H:i')}}</p>
        </div>
    </div>
</div>
<!-- FIM HEADER -->

<!-- ENTREGA -->
<div class="bg-white rounded border p-3">

    @if($pedido->consumo_local_viagem_delivery == 1)
    <p class="fw-bolder fs-5 m-0 p-0">Consumir no local</p>
    <div class="row m-0 p-0 d-flex align-items-center">
        <div class="m-0 p-0">
            <p class="fw-regular m-0 p-0">
                Sem entrega
            </p>
        </div>
    </div>

    @elseif($pedido->consumo_local_viagem_delivery == 2)
    <p class="fw-bolder fs-5 m-0 p-0">Para viagem</p>
    <div class="row m-0 p-0 d-flex align-items-center">
        <div class="m-0 p-0">
            <p class="fw-regular m-0 p-0">
                Embalar para viagem
            </p>
        </div>
    </div>

    @elseif($pedido->consumo_local_viagem_delivery == 3)
    <p class="fw-bolder fs-5 m-0 p-0">Entrega</p>
    <div class="row m-0 p-0 d-flex align-items-center">
        <div class="m-0 p-0">
            <p class="fw-regular m-0 p-0">
                {{ $pedido->entrega->rua }},
                {{ $pedido->entrega->numero }},
                {{ $pedido->entrega->bairro }} -
                {{ $pedido->entrega->cidade }}
                {{ $pedido->entrega->estado }}.
                {{ $pedido->entrega->complemento }}
            </p>
            <p class="fw-regular m-0 p-0">
                {{ $pedido->entrega->distancia_metros }} metros de distância.
            </p>
        </div>
    </div>
    @endif
</div>
<!-- FIM ENTREGA -->

<!-- PEDIDO -->
<div class="bg-white rounded border p-3 my-2">
    <p class="fw-bolder fs-5 m-0 p-0">Pedido</p>

    <div class="px-3 py-1 m-2">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Item</th>
                    <th scope="col">Preço unitário</th>
                    <th scope="col">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <!-- Variáveis PHP -->
                @php
                $total_pedido = 0;
                @endphp

                <!-- Exibir itens do pedido -->
                @foreach ($pedido->item_pedido as $item)

                <!-- Incrementando sobre valor total -->
                @php
                $total_pedido += $item->subtotal;
                @endphp

                <tr class="p-0 m-0">
                    <td class="bg-white">
                        <span>
                            {{ $item->quantidade }}x
                        </span><br>
                        <span class="text-secondary">
                            @foreach ($item->opcional_item as $opcional)
                            {{ $opcional->quantidade }}x
                            @endforeach
                        </span>
                    </td>
                    <td class="bg-white">
                        <span class="fw-bold">
                            {{ $item->produto->nome }}
                        </span><br>
                        <span class="text-secondary">
                            @foreach ($item->opcional_item as $opcional)
                            {{ $opcional->opcional_produto->nome }}
                            @endforeach
                        </span>
                    </td>
                    <td class="bg-white">
                        <span>
                            R$ {{number_format($item->preco_unitario, 2, ',', '.')}}
                        </span><br>
                        <span class="text-secondary">
                            @foreach ($item->opcional_item as $opcional)
                            R$ {{number_format($opcional->preco_unitario, 2, ',', '.')}}
                            @endforeach
                        </span>
                    </td>
                    <td class="bg-white">
                        <span>
                            R$ {{number_format($item->subtotal, 2, ',', '.')}}
                        </span><br>
                        <span class="text-secondary">
                            @foreach ($item->opcional_item as $opcional)

                            <!-- Incrementando sobre valor total -->
                            @php
                            $total_pedido += $opcional->subtotal;
                            @endphp

                            R$ {{number_format($opcional->subtotal, 2, ',', '.')}}
                            @endforeach
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="fw-bold">Subtotal</td>
                    <td>R$ {{number_format($total_pedido, 2, ',', '.')}}</td>
                </tr>
                <tr>
                    <td colspan="3" class="fw-bold">Entrega</td>
                    @php
                    $total_pedido += $pedido->entrega->taxa_entrega;
                    @endphp
                    <td>R$ {{number_format($pedido->entrega->taxa_entrega, 2, ',', '.')}}</td>
                </tr>
                <tr>
                    <td colspan="3" class="fw-bold">Total</td>
                    <td class="fw-bolder ">R$ {{number_format($total_pedido, 2, ',', '.')}}</td>
                </tr>
            </tfoot>

        </table>

    </div>

</div>
<!-- FIM PEDIDO -->

<!-- PAGAMENTO -->
<div class="bg-white rounded border p-3 my-2">
    <p class="fw-bolder fs-5 m-0 p-0">Pagamento</p>
    <div class="">
        <p class="m-0 p-0">Cobrar do cliente na entrega <strong>{{ $pedido->forma_pagamento_entrega->forma }}</strong>
        </p>
        <p class="text-secondary m-0 p-0">O entregador deve cobrar esse valor no ato da entrega. </p>
    </div>

</div>
<!-- FIM PAGAMENTO -->