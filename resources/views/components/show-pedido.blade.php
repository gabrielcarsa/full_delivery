<!-- HEADER -->
<div class="my-1">
    <div class="m-0">
        <h5 class="fw-bold fs-4 m-0 text-uppercase">
            @if($pedido->cliente_id != null)
            {{$pedido->cliente->nome}}
            @else
            {{$pedido->nome_cliente}}
            @endif
        </h5>
        <p class="m-0 fs-6 fw-regular text-secondary d-flex align-items-center">
            @if($pedido->cliente_id != null)
            {{ $pedido->cliente->telefone }}
            @endif
            <span class="material-symbols-outlined mx-2" style="font-variation-settings: 'FILL' 1; font-size: 10px">
                circle
            </span>
            {{\Carbon\Carbon::parse($pedido->data_pedido)->format('d/m/Y')}} -
            {{\Carbon\Carbon::parse($pedido->data_pedido)->format('H:i')}}
        </p>
    </div>
</div>
<!-- FIM HEADER -->


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

        @elseif($pedido->status == 1 && $pedido->consumo_local_viagem_delivery == 3)
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


        @elseif($pedido->status == 2 && $pedido->consumo_local_viagem_delivery == 3)
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

        @elseif($pedido->status == 1 && $pedido->consumo_local_viagem_delivery == 1)
        <div class="col">
            <a href="{{route('pedido.update_status', ['id' => $pedido->id])}}"
                class="btn btn-success d-flex align-items-center justify-content-center">
                <span class="material-symbols-outlined mr-1">
                    task_alt
                </span>
                <span>
                    Pedido concluído
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

<!-- STATUS PEDIDO -->
<div class="bg-white border rounded my-3 p-2">
    @if($pedido->status == 0)
    <div class="m-0">
        <p class="m-0 p-0 text-secondary fs-6">Status do pedido</p>
        <p class="m-0 p-0 fs-5 fw-bold text-warning">Pendente</p>
    </div>
    @elseif($pedido->status == 1)
    <div class="m-0">
        <p class="m-0 p-0 text-secondary fs-6">Status do pedido</p>
        <p class="m-0 p-0 fs-5 fw-bold">Em preparo</p>
    </div>
    @elseif($pedido->status == 2)
    <div class="m-0">
        <p class="m-0 p-0 text-secondary fs-6">Status do pedido</p>
        <p class="m-0 p-0 fs-5 fw-bold">A caminho</p>
    </div>
    @elseif($pedido->status == 3)
    <div class="m-0">
        <p class="m-0 p-0 text-secondary fs-6">Status do pedido</p>
        <p class="m-0 p-0 fs-5 fw-bold text-success">Concluido</p>
    </div>
    @elseif($pedido->status == 4)
    <div class="m-0">
        <p class="m-0 p-0 text-secondary fs-6">Status do pedido</p>
        <p class="m-0 p-0 fs-5 fw-bold text-danger">REJEITADO</p>
        <p class="mt-2 mb-0 p-0 text-secondary fs-6">Motivo rejeição</p>
        <p class="m-0 text-black">{{ $pedido->mensagem_cancelamento_rejeicao }}</p>
    </div>

    @elseif($pedido->status == 5)
    <div class="m-0">
        <p class="m-0 p-0 text-secondary fs-6">Status do pedido</p>
        <p class="m-0 p-0 fs-5 fw-bold text-danger">CANCELADO</p>
        <p class="mt-2 mb-0 p-0 text-secondary fs-6">Motivo cancelamento</p>
        <p class="m-0 text-black">{{ $pedido->mensagem_cancelamento_rejeicao }}</p>
    </div>
    @endif

    <!--  PEDIDO ETAPAS -->
    @if($pedido->status != 4 && $pedido->status != 5 )

    <!-- ETAPAS STATUS -->
    <div class="d-flex align-items-center justify-content-between my-3">

        <!-- PEDIDO PENDENTE -->
        <div class="{{$pedido->status == 0 ? 'text-black' : 'text-secondary'}}">
            <div class="m-0">
                @if($pedido->status > 0)
                <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                    check_circle
                </span>
                @else
                <p class="m-0 fs-1 fw-bolder {{ $pedido->status > 0 ? 'text-padrao' : '' }}">
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
        <div class="{{ $pedido->status > 0 ? 'bg-padrao' : 'bg-light border' }} rounded"
            style="width: 100% !important; height: 5px;">
        </div>
        <!-- FIM LINHA INTERMEDIARIA -->

        <!-- PEDIDO PREPARANDO -->
        <div class="ms-3 {{$pedido->status == 1 ? 'text-black' : 'text-secondary'}}">
            <div class="m-0">
                @if($pedido->status > 1)
                <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                    check_circle
                </span>
                @else
                <p class="m-0 fs-1 fw-bolder {{ $pedido->status > 1 ? 'text-padrao' : '' }}">
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
        <div class="{{ $pedido->status > 1 ? 'bg-padrao' : 'bg-light border' }} rounded m-1"
            style="width: 100% !important; height: 5px;">
        </div>
        <!-- FIM LINHA INTERMEDIARIA -->

        <!-- PEDIDO ENTREGA -->
        @if($pedido->consumo_local_viagem_delivery == 3)

        <div class="ms-3 {{$pedido->status == 2 ? 'text-black' : 'text-secondary'}}">
            <div class="m-0">
                @if($pedido->status > 2)
                <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                    check_circle
                </span>
                @else
                <p class="m-0 fs-1 fw-bolder {{ $pedido->status > 2 ? 'text-padrao' : '' }}">
                    3.
                </p>
                @endif
            </div>
            <p class="m-0" style="font-size: 13px !important">
                A caminho
            </p>
        </div>

        <!-- LINHA INTERMEDIARIA -->
        <div class="{{ $pedido->status > 2 ? 'bg-padrao' : 'bg-light border' }} rounded m-1"
            style="width: 100% !important; height: 5px;">
        </div>
        <!-- FIM LINHA INTERMEDIARIA -->

        @endif
        <!-- FIM PEDIDO ENTREGA -->

        <!-- PEDIDO CONCLUIDO -->
        <div class="{{$pedido->status == 3 ? 'text-black' : 'text-secondary'}}">
            <div class="m-0">
                @if($pedido->status > 2)
                <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                    check_circle
                </span>
                @else
                <p class="m-0 fs-1 fw-bolder {{ $pedido->status > 2 ? 'text-padrao' : '' }}">
                    {{ $pedido->consumo_local_viagem_delivery == 3 ? '4.' : '3.' }}
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
    <!--  FIM PEDIDO ETAPAS -->
</div>
<!-- FIM STATUS PEDIDO -->

<!-- ENTREGA -->
<div class="bg-white rounded border p-3">

    @if($pedido->consumo_local_viagem_delivery == 1)
    <p class="fw-bolder fs-5 m-0 p-0">
        Consumir no local
    </p>
    <div class="row m-0 p-0 d-flex align-items-center">
        <div class="m-0 p-0">
            <p class="fw-regular m-0 p-0">
                Mesa {{$pedido->mesa->nome}}
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

<!-- PAGAMENTO -->
@if($pedido->consumo_local_viagem_delivery == 3)
<div class="bg-white rounded border p-3 my-2">
    <p class="fw-bolder fs-5 m-0 p-0">Pagamento</p>
    <div class="">

        <!-- FORMA PAGAMENTO -->
        @if($pedido->forma_pagamento_loja->id != null)
        <p class="p-0 m-0 fs-6">
            Cobrar do cliente na entrega <strong>R$ {{number_format($pedido->total, 2, ',', '.')}} no
                {{$pedido->forma_pagamento_loja->nome}}</strong>
        </p>
        <p class="text-secondary m-0 p-0">
            O entregador deve cobrar esse valor no ato da entrega.
        </p>

        @else
        <p class="p-0 m-0">
            Cliente pagou via site/app <strong>R$ {{number_format($pedido->total, 2, ',', '.')}} no
                {{$pedido->forma_pagamento_foomy->nome}}</strong>
        </p>
        @endif

        <!-- FIM FORMA PAGAMENTO -->

    </div>
</div>
@endif

<!-- FIM PAGAMENTO -->

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
                </tr>
                @endif

                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="fw-bold bg-white">Subtotal</td>
                    <td class="bg-white">R$ {{number_format($total_sem_entrega, 2, ',', '.')}}</td>
                </tr>
                @if($pedido->consumo_local_viagem_delivery == 3)
                <tr>
                    <td colspan="3" class="fw-bold bg-white">Entrega</td>
                    <td class="bg-white">R$ {{number_format($pedido->entrega->taxa_entrega, 2, ',', '.')}}</td>
                </tr>
                @endif

                @if(!empty($pedido->uso_cupom))
                <tr>
                    <td colspan="3" class="fw-regular bg-white">Cupom - {{ $pedido->uso_cupom->cupom->codigo }}</td>
                    @if($pedido->uso_cupom->cupom->tipo_desconto == 1)
                    <td class="text-danger bg-white">
                        - R$ {{ number_format($pedido->uso_cupom->cupom->desconto, 2, ',', '.') }}
                    </td>
                    @else
                    <td class="text-danger bg-white">- {{ $pedido->uso_cupom->cupom->desconto }} %</td>
                    @endif
                </tr>
                @endif
                <tr>
                    <td colspan="3" class="fw-bold bg-white">Total</td>
                    <td class="fw-bolder bg-white"> R$ {{number_format($pedido->total, 2, ',', '.')}}</td>
                </tr>
            </tfoot>

        </table>

    </div>

</div>
<!-- FIM PEDIDO -->