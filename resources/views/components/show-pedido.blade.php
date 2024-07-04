<!-- HEADER -->
<div class="my-1">
    <div class="row m-0 p-0 d-flex align-items-center">
        <div class="col-md-auto">
            <div class="m-0 p-3 text-center">
                <h5 class="fw-bold fs-4 m-0 p-0">
                    {{ $pedido->cliente->nome }}
                </h5>
                <p class="m-0 p-0 fs-6 fw-regular text-secondary d-flex align-items-center justify-content-center">
                    <span class="material-symbols-outlined mr-1 fs-5">
                        call
                    </span>
                    {{ $pedido->cliente->telefone }}
                </p>
            </div>
        </div>
        <div class="col">
            @if($pedido->status == 0)
            <div class="m-0 p-2 text-center">
                <p class="m-0 p-0 fw-bold fs-6">Status do pedido</p>
                <p class="m-0 p-0 fs-4 fw-bold text-warning">Pendente!</p>
            </div>
            @elseif($pedido->status == 1)
            <div class="m-0 p-2 text-center">
                <p class="m-0 p-0 fw-bold fs-6">Status do pedido</p>
                <p class="m-0 p-0 fs-4 fw-regular">Em preparo</p>
            </div>
            @elseif($pedido->status == 2)
            <div class="m-0 p-2 text-center">
                <p class="m-0 p-0 fw-bold fs-6">Status do pedido</p>
                <p class="m-0 p-0 fs-4 fw-regular">A caminho</p>
            </div>
            @elseif($pedido->status == 3)
            <div class="m-0 p-2 text-center">
                <p class="m-0 p-0 fw-bold fs-6">Status do pedido</p>
                <p class="m-0 p-0 fs-4 fw-regular text-success">Concluido</p>
            </div>
            @elseif($pedido->status == 4)
            <div class="m-0 p-2 text-center">
                <p class="m-0 p-0 fw-bold fs-6">Status do pedido</p>
                <p class="m-0 p-0 fs-4 fw-regular text-danger">REJEITADO</p>
            </div>
            @elseif($pedido->status == 5)
            <div class="m-0 p-2 text-center">
                <p class="m-0 p-0 fw-bold fs-6">Status do pedido</p>
                <p class="m-0 p-0 fs-4 fw-regular text-danger">CANCELADO</p>
            </div>
            @endif
        </div>
        <div class="col m-0 text-center">
            <p class="m-0 p-0 fw-bold fs-6">Loja</p>
            <p class="m-0 p-0 fs-6 fw-regular text-secondary d-flex align-items-center justify-content-center">
                <span class="material-symbols-outlined mr-2">
                    storefront
                </span>
                {{ $pedido->loja->nome }}
            </p>

        </div>
        <div class="col d-flex justify-content-end">
            <p class="m-0 p-0 fw-semibold">{{\Carbon\Carbon::parse($pedido->data_pedido)->format('d/m/Y')}} - {{\Carbon\Carbon::parse($pedido->data_pedido)->format('H:i')}}</p>
        </div>
    </div>
</div>
<!-- FIM HEADER -->


@if($pedido->status == 4)
<div class="col">
    <div class="card text-bg-danger">
        <div class="card-header fw-bold">Motivo rejeição</div>
        <div class="card-body">
            <p class="card-text">{{ $pedido->mensagem_cancelamento_rejeicao }}</p>
        </div>
    </div>
</div>

@elseif($pedido->status == 5)
<div class="col">
    <div class="card text-bg-danger">
        <div class="card-header fw-bold">Motivo cancelamento</div>
        <div class="card-body">
            <p class="card-text">{{ $pedido->mensagem_cancelamento_rejeicao }}</p>
        </div>
    </div>
</div>

@endif

<!-- AÇÕES -->
<div class="bg-white rounded border p-3">
    <div class="row">

        <!-- STATUS DO PEDIDO -->
        @if($pedido->status == 0)
        <div class="col">
            <a href="{{route('pedido.update_status', ['id' => $pedido->id])}}"
                class="btn btn-success d-flex align-items-center justify-content-center">
                <span class="material-symbols-outlined mr-1">
                    task_alt
                </span>
                <span>
                    Aceitar pedido
                </span>
            </a>
        </div>
        <div class="col">
            <a href="" class="btn btn-danger d-flex align-items-center justify-content-center" data-bs-toggle="modal"
                data-bs-target="#rejeitarModal">
                <span class="material-symbols-outlined mr-1">
                    dangerous
                </span>
                <span>
                    Rejeitar pedido
                </span>
            </a>
        </div>

        <!-- MODAL REJEITAR PEDIDO -->
        <div class="modal fade" id="rejeitarModal" tabindex="-1" aria-labelledby="rejeitarModal" aria-hidden="true">
            <div class="modal-dialog">
                <!-- FORM ACAO -->
                <form action="{{route('pedido.rejeitar', ['id' => $pedido->id])}}" method="POST" class="my-2">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="rejeitarModal">Deseja mesmo rejeitar esse pedido?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="px-4">
                                Após rejeitar pedido essa ação não poderá ser desfeita!
                            </p>
                            <div class="form-floating mt-1">
                                <input type="text" class="form-control @error('motivo') is-invalid @enderror"
                                    id="inputArea" name="motivo" autocomplete="off" required>
                                <label for="inputArea">Qual o motivo?</label>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-danger px-5">
                                Rejeitar
                            </button>
                        </div>
                    </div>
                </form>
                <!-- FIM FORM -->
            </div>
        </div>
        <!-- FIM MODAL REJEITAR -->

        @elseif($pedido->status == 1)
        <div class="col">
            <a href="{{route('pedido.update_status', ['id' => $pedido->id])}}"
                class="btn btn-primary d-flex align-items-center justify-content-center">
                <span class="material-symbols-outlined">
                    sports_motorsports
                </span>
                <span>
                    Enviar para entrega
                </span>
            </a>
        </div>
        <div class="col">
            <a href="" class="btn btn-danger d-flex align-items-center justify-content-center" data-bs-toggle="modal"
                data-bs-target="#cancelarModal">
                <span class="material-symbols-outlined mr-1">
                    dangerous
                </span>
                <span>
                    Cancelar pedido
                </span>
            </a>
        </div>

        <!-- MODAL CANCELAR PEDIDO -->
        <div class="modal fade" id="cancelarModal" tabindex="-1" aria-labelledby="cancelarModal" aria-hidden="true">
            <div class="modal-dialog">
                <!-- FORM ACAO -->
                <form action="{{route('pedido.cancelar', ['id' => $pedido->id])}}" method="POST" class="my-2">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="cancelarModal">Deseja mesmo cancelar esse pedido?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="px-4">
                                Após cancelar esse pedido essa ação não poderá ser desfeita!
                            </p>
                            <div class="form-floating mt-1">
                                <input type="text" class="form-control @error('motivo') is-invalid @enderror"
                                    id="inputArea" name="motivo" autocomplete="off" required>
                                <label for="inputArea">Qual o motivo?</label>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-danger px-5">
                                Cancelar pedido
                            </button>
                        </div>
                    </div>
                </form>
                <!-- FIM FORM -->
            </div>
        </div>
        <!-- FIM MODAL CANCELAR -->


        @elseif($pedido->status == 2)
        <div class="col">
            <a href="{{route('pedido.update_status', ['id' => $pedido->id])}}"
                class="btn btn-success d-flex align-items-center justify-content-center">
                <span class="material-symbols-outlined mr-1">
                    task_alt
                </span>
                <span>
                    Pedido entregue
                </span>
            </a>
        </div>
        <div class="col">
            <a href="" class="btn btn-danger d-flex align-items-center justify-content-center" data-bs-toggle="modal"
                data-bs-target="#cancelarModal">
                <span class="material-symbols-outlined mr-1">
                    dangerous
                </span>
                <span>
                    Cancelar pedido
                </span>
            </a>
        </div>

        <!-- MODAL CANCELAR PEDIDO -->
        <div class="modal fade" id="cancelarModal" tabindex="-1" aria-labelledby="cancelarModal" aria-hidden="true">
            <div class="modal-dialog">
                <!-- FORM ACAO -->
                <form action="{{route('pedido.cancelar', ['id' => $pedido->id])}}" method="POST" class="my-2">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="cancelarModal">Deseja mesmo cancelar esse pedido?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="px-4">
                                Após cancelar esse pedido essa ação não poderá ser desfeita!
                            </p>
                            <div class="form-floating mt-1">
                                <input type="text" class="form-control @error('motivo') is-invalid @enderror"
                                    id="inputArea" name="motivo" autocomplete="off" required>
                                <label for="inputArea">Qual o motivo?</label>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-danger px-5">
                                Cancelar pedido
                            </button>
                        </div>
                    </div>
                </form>
                <!-- FIM FORM -->
            </div>
        </div>
        <!-- FIM MODAL CANCELAR -->

        @endif
        <div class="col">
            <a href="" class="btn btn-outline-primary d-flex align-items-center justify-content-center">
                <span class="material-symbols-outlined mr-1">
                    print
                </span>
                <span>
                    Imprimir
                </span>
            </a>
        </div>
    </div>
</div>
<!-- FIM AÇÕES -->

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
                $total_sem_entrega = 0;
                @endphp

                <!-- Exibir itens do pedido -->
                @foreach ($pedido->item_pedido as $item)

                <!-- Incrementando sobre valor total -->
                @php
                $total_sem_entrega += $item->subtotal;
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
                            $total_sem_entrega += $opcional->subtotal;
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
                    <td>R$ {{number_format($total_sem_entrega, 2, ',', '.')}}</td>
                </tr>
                <tr>
                    <td colspan="3" class="fw-bold">Entrega</td>
                    <td>R$ {{number_format($pedido->entrega->taxa_entrega, 2, ',', '.')}}</td>
                </tr>
                <tr>
                    <td colspan="3" class="fw-bold">Total</td>
                    <td class="fw-bolder "> R$ {{number_format($pedido->total, 2, ',', '.')}}</td>
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