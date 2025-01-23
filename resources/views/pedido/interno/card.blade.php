<!-- PEDIDOS -->
@foreach($pedidos as $pedido)

<!-- PEDIDO -->
<div class="col-sm-3">

    <!-- CARD -->
    <div
        class="card h-100 {{$id_selecionado == $pedido->id ? 'bg-light border-end-0 border-top-0 border-start-0 border-danger border-5' : 'bg-white' }}">

        <!-- HEADER PEDIDO -->
        <div class="d-flex justify-content-between align-items-center py-2 px-3 border-bottom">
            <div class="">
                <p class="text-secondary fs-6 m-0">
                    # 0{{$pedido->id}}0 -
                    <span class="fw-bold text-padrao">
                        {{$pedido->via_ifood == true ? 'via iFood' : 'via Foomy'}}
                    </span>
                </p>
            </div>

            <!-- MODAL CANCELAR PEDIDO -->
            <div class="modal fade" id="cancelarModal{{$pedido->id}}" tabindex="-1" aria-labelledby="cancelarModal"
                aria-hidden="true">
                <div class="modal-dialog">
                    <!-- FORM ACAO -->
                    <form action="{{route('pedido.cancelar', ['id' => $pedido->id])}}" method="POST" class="my-2">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="cancelarModal">Deseja mesmo
                                    cancelar esse pedido #0{{$pedido->id}}0?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="px-4">
                                    Após cancelar esse pedido essa ação não poderá ser
                                    desfeita!
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

            <!-- BOTÃO DROPDOWN NO CANTO COM STATUS -->
            <div class="col-md-4 d-flex align-items-start justify-content-end">
                <!-- DROPDOWN -->
                <div class="dropdown">
                    @if($pedido->status == 0)
                    <button class="btn btn-warning dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Pendente
                    </button>

                    @elseif($pedido->status == 1)
                    <button class="btn btn-outline-dark dropdown-toggle rounded-pill" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Em preparo
                    </button>

                    @elseif($pedido->status == 2)
                    <button class="btn btn-outline-dark dropdown-toggle rounded-pill" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Pronto p/ retirar
                    </button>

                    @elseif($pedido->status == 3)
                    <button class="btn btn-outline-dark dropdown-toggle rounded-pill" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        A caminho
                    </button>

                    @elseif($pedido->status == 4)
                    <button class="btn btn-success rounded-pill">
                        Concluído
                    </button>

                    @elseif($pedido->status == 5)
                    <button class="btn btn-secondary rounded-pill">
                        Cancelado
                    </button>

                    @endif

                    <!-- AÇÕES DROPDOWN -->
                    <ul class="dropdown-menu">

                        <!-- STATUS DO PEDIDO -->
                        @if($pedido->status == 0)
                        <!-- Pedindo pendente -> aceitar pedido -->
                        <li>
                            <a href="{{route('pedido.update_status', ['id' => $pedido->id])}}"
                                class="dropdown-item d-flex align-items-center">
                                <span class="material-symbols-outlined mr-1">
                                    task_alt
                                </span>
                                <span>
                                    Aceitar pedido
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item d-flex align-items-center text-danger"
                                data-bs-toggle="modal" data-bs-target="#cancelarModal{{$pedido->id}}">
                                <span class="material-symbols-outlined mr-1">
                                    dangerous
                                </span>
                                <span>
                                    Rejeitar pedido
                                </span>
                            </a>
                        </li>

                        @elseif($pedido->status == 1 && $pedido->tipo == "DELIVERY")
                        <!-- Pedido em preparo -> pronto para retirar -->
                        <li>
                            <a href="{{route('pedido.update_status', ['id' => $pedido->id])}}"
                                class="dropdown-item d-flex align-items-center">
                                <span class="material-symbols-outlined">
                                    check_circle
                                </span>
                                <span>
                                    Pronto p/ retirar
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item d-flex align-items-center text-danger"
                                data-bs-toggle="modal" data-bs-target="#cancelarModal{{$pedido->id}}">
                                <span class="material-symbols-outlined mr-1">
                                    dangerous
                                </span>
                                <span>
                                    Cancelar pedido
                                </span>
                            </a>
                        </li>

                        @elseif($pedido->status == 2 && $pedido->tipo == "DELIVERY")
                        <!-- Pronto para retirar -> Ir para entrega -->
                        <li>
                            <a href="{{route('pedido.update_status', ['id' => $pedido->id])}}"
                                class="dropdown-item d-flex align-items-center">
                                <span class="material-symbols-outlined mr-1">
                                    sports_motorsports
                                </span>
                                <span>
                                    Enviar para entrega
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item d-flex align-items-center text-danger"
                                data-bs-toggle="modal" data-bs-target="#cancelarModal{{$pedido->id}}">
                                <span class="material-symbols-outlined mr-1">
                                    dangerous
                                </span>
                                <span>
                                    Cancelar pedido
                                </span>
                            </a>
                        </li>

                        @elseif($pedido->status == 3 && $pedido->tipo == "DELIVERY")
                        <!-- Ir para entrega -> Concluído -->
                        <li>
                            <a href="{{route('pedido.update_status', ['id' => $pedido->id])}}"
                                class="dropdown-item d-flex align-items-center">
                                <span class="material-symbols-outlined mr-1">
                                    task_alt
                                </span>
                                <span>
                                    Pedido entregue
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item d-flex align-items-center text-danger"
                                data-bs-toggle="modal" data-bs-target="#cancelarModal{{$pedido->id}}">
                                <span class="material-symbols-outlined mr-1">
                                    dangerous
                                </span>
                                <span>
                                    Cancelar pedido
                                </span>
                            </a>
                        </li>

                        @elseif($pedido->status == 1 && $pedido->tipo == "DINE_IN")
                        <!-- Pedido em preparo -> concluído caso seja comer no local -->
                        <li>
                            <a href="{{route('pedido.update_status', ['id' => $pedido->id])}}"
                                class="dropdown-item d-flex align-items-center">
                                <span class="material-symbols-outlined mr-1">
                                    task_alt
                                </span>
                                <span>
                                    Pedido concluído
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item d-flex align-items-center text-danger"
                                data-bs-toggle="modal" data-bs-target="#cancelarModal{{$pedido->id}}">
                                <span class="material-symbols-outlined mr-1">
                                    dangerous
                                </span>
                                <span>
                                    Cancelar pedido
                                </span>
                            </a>
                        </li>
                        @endif

                    </ul>
                    <!-- FIM AÇÕES DROPDOWN -->
                </div>
                <!-- FIM DROPDOWN -->

            </div>
            <!-- FIM BOTÃO DROPDOWN NO CANTO COM STATUS -->

        </div>
        <!-- FIM HEADER PEDIDO -->


        <!-- INFO CLIENTE -->
        <div class="d-flex align-items-center px-3 mt-3">
            <span class="material-symbols-outlined mr-2 fill-icon text-secondary">
                account_circle
            </span>
            <div>
                <h4 class="fw-bold fs-6 text-dark text-uppercase text-truncate m-0" style="max-width: 205px;">
                    @if($pedido->cliente_id != null)
                    {{$pedido->cliente->nome}}
                    @else
                    {{$pedido->nome_cliente}}
                    @endif
                </h4>
                <p class="m-0 text-secondary text-truncate" style="max-width: 205px;">
                    1 pedido na loja
                </p>
            </div>
        </div>
        <!-- FIM INFO CLIENTE -->

        <!-- CONSUMO -->
        <div class="d-flex align-items-center px-3 my-1">
            <span class="material-symbols-outlined mr-2 fill-icon text-secondary">
                @if($pedido->tipo == "DINE_IN")
                table_restaurant
                @elseif($pedido->tipo == "TAKEOUT")
                shopping_bag
                @elseif($pedido->tipo == "DELIVERY")
                location_on
                @endif
            </span>
            <div>
                <p class="fw-bold fs-6 text-dark text-uppercase text-truncate m-0" style="max-width: 205px;">
                    @if($pedido->tipo == "DINE_IN")
                    Mesa {{$pedido->mesa->nome}}
                    @elseif($pedido->tipo == "TAKEOUT")
                    Para retirada no local
                    @elseif($pedido->tipo == "DELIVERY")
                    {{$pedido->entrega->rua}} {{$pedido->entrega->numero}},
                    {{$pedido->entrega->bairro}}, {{$pedido->entrega->cidade}}/{{$pedido->entrega->estado}}.
                    {{$pedido->entrega->complemento}}
                    @endif
                </p>
                <p class="m-0 text-secondary text-truncate" style="max-width: 205px;">
                    1 pedido na loja
                </p>
            </div>
        </div>
        <!-- FIM CONSUMO -->

        <!-- FORMA PAGAMENTO -->
        <div class="d-flex align-items-center px-3 my-1">
            <span class="material-symbols-outlined mr-2 fill-icon text-secondary">
                paid
            </span>
            <div>
                <p class="fw-bold fs-6 text-dark text-uppercase text-truncate m-0" style="max-width: 205px;">
                    @if($pedido->is_pagamento_entrega == 0)
                    Pago R$ {{number_format($pedido->total, 2, ',', '.')}} online.
                    @else
                    Cobrar R$ {{number_format($pedido->total, 2, ',', '.')}} na entrega.
                    @endif
                </p>
                <p class="m-0 text-secondary text-truncate" style="max-width: 205px;">
                    {{$pedido->forma_pagamento->nome}}
                </p>
            </div>
        </div>
        <!-- FIM FORMA PAGAMENTO -->

        <div class="d-flex align-items-center justify-content-between p-3">
            <p class="m-0 text-secondary" style="font-size: 14px">
                {{\Carbon\Carbon::parse($pedido->feito_em)->format('d/m/Y')}} -
                {{\Carbon\Carbon::parse($pedido->feito_em)->format('H:i')}}
            </p>
            <a href="{{route('pedido.gestor', ['id' => $pedido->id])}}" class="btn bg-padrao text-white fw-semibold">
                Ver perdido
            </a>
        </div>

    </div>
    <!-- FIM CARD -->

</div>
@endforeach
<!-- FIM PEDIDO -->