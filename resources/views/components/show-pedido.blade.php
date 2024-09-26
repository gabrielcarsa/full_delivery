
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
                    <th>
                        <input type="checkbox" name="selectAll" id="selectAll">
                    </th>
                    <th scope="col">Qtnd</th>
                    <th scope="col">Item</th>
                    <th scope="col">Unidade</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Ações</th>
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
                        <input type="checkbox" name="item_pedido_id[]" value="{{$item->id}}">
                    </td>
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
                                <li>
                                    <a class="dropdown-item" href="#">
                                        Alterar quantidade
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#">
                                        Excluir item
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>

                @if(!$item->produto->categoria_opcional->isEmpty())
                <tr style="font-size:14px">
                    <td></td>
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
            <tfoot>
                <tr>
                    <td colspan="4" class="fw-bold bg-white">Subtotal</td>
                    <td class="bg-white">R$ {{number_format($total_sem_entrega, 2, ',', '.')}}</td>
                    <td class="bg-white"></td>
                </tr>
                @if($pedido->consumo_local_viagem_delivery == 3)
                <tr>
                    <td colspan="4" class="fw-bold bg-white">Entrega</td>
                    <td class="bg-white">R$ {{number_format($pedido->entrega->taxa_entrega, 2, ',', '.')}}</td>
                    <td class="bg-white"></td>
                </tr>
                @endif

                @if(!empty($pedido->uso_cupom))
                <tr>
                    <td colspan="4" class="fw-regular bg-white">Cupom - {{ $pedido->uso_cupom->cupom->codigo }}</td>
                    @if($pedido->uso_cupom->cupom->tipo_desconto == 1)
                    <td class="text-danger bg-white">
                        - R$ {{ number_format($pedido->uso_cupom->cupom->desconto, 2, ',', '.') }}
                    </td>
                    @else
                    <td class="text-danger bg-white">- {{ $pedido->uso_cupom->cupom->desconto }} %</td>
                    @endif
                    <td class="bg-white"></td>
                </tr>
                @endif
                <tr>
                    <td colspan="4" class="fw-bold bg-white">Total</td>
                    <td class="fw-bolder bg-white"> R$ {{number_format($pedido->total, 2, ',', '.')}}</td>
                    <td class="bg-white"></td>
                </tr>
            </tfoot>

        </table>

    </div>

</div>
<!-- FIM PEDIDO -->