<!-- HEADER -->
<div class="my-3">
    <div class="row m-0 p-0 d-flex align-items-center">
        <div class="col-md-auto">
            <h5 class="fw-bold fs-3 m-0 p-0">{{ $pedido->cliente->nome }}</h5>
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

            </p>
        </div>
    </div>
    <div class="row m-0 p-0 d-flex align-items-center">
        <div class="m-0 p-0">
            <p class="fw-regular m-0 p-0">
                {{ $pedido->restaurante->nome }},
            </p>
        </div>
    </div>
    @endif
</div>
<!-- FIM ENTREGA -->

<!-- PEDIDO -->
<div class="bg-white rounded border p-3 my-2">
    <p class="fw-bolder fs-5 m-0 p-0">Pedido</p>
    <!-- Exibir itens do pedido -->
    @foreach ($pedido->item_pedido as $item)
    <div class="px-3 py-1 m-2 border rounded">
        <div class="row fs-5">
            <div class="col col-2">
                <p class="m-0 p-0 text-start">{{ $item->quantidade }}x</p>
            </div>
            <div class="col">
                <p class="fw-semibold text-start m-0 p-0"> {{ $item->produto->nome }}</p>
            </div>
            <div class="col col-2">
                <p class="m-0 p-0 text-end">R$ {{number_format($item->subtotal, 2, ',', '.')}}</p>
            </div>
        </div>
    </div>
    @endforeach

</div>
<!-- FIM PEDIDO -->

<!-- PAGAMENTO -->
<div class="bg-white rounded border p-3 my-2">
    <p class="fw-bolder fs-5 m-0 p-0">Pagamento</p>
    <div class="">
        <p class="m-0 p-0">Cobrar do cliente na entrega <strong>{{ $pedido->forma_pagamento_entrega->forma }}</strong></p>
        <p class="text-secondary m-0 p-0">O entregador deve cobrar esse valor no ato da entrega. </p>
    </div>

</div>
<!-- FIM PAGAMENTO -->