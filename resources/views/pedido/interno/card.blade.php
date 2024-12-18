<!-- PEDIDOS -->
@foreach($pedidos as $pedido)
<!-- PEDIDO -->
<div class="col mx-1 shadow-md p-2 rounded {{$id_selecionado == $pedido->id ? 'bg-light border-end-0 border-top-0 border-start-0 border-danger border-5' : 'bg-white' }}"
    style="min-width: 300px !important; max-width: 300px !important">

    <!-- HEADER PEDIDO -->
    <div class="row px-2">
        <div class="col-md-8">
            <p class="text-secondary fs-6 m-0">
                # 0{{$pedido->id}}0
            </p>

            <h4 class="fw-bold fs-5 text-dark text-uppercase text-wrapper">
                @if($pedido->cliente_id != null)
                {{$pedido->cliente->nome}}
                @else
                {{$pedido->nome_cliente}}
                @endif
            </h4>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <button class="btn btn-outline-danger dropdown-toggle rounded-pill" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Pendente
                </button>

                @elseif($pedido->status == 1)
                <button class="btn btn-warning dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Em preparo
                </button>

                @elseif($pedido->status == 2)
                <button class="btn btn-primary dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Pronto p/ retirar
                </button>

                @elseif($pedido->status == 3)
                <button class="btn btn-outline-primary dropdown-toggle rounded-pill" type="button"
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
                        <a href="" class="dropdown-item d-flex align-items-center text-danger" data-bs-toggle="modal"
                            data-bs-target="#cancelarModal{{$pedido->id}}">
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
                        <a href="" class="dropdown-item d-flex align-items-center text-danger" data-bs-toggle="modal"
                            data-bs-target="#cancelarModal{{$pedido->id}}">
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
                        <a href="" class="dropdown-item d-flex align-items-center text-danger" data-bs-toggle="modal"
                            data-bs-target="#cancelarModal{{$pedido->id}}">
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
                        <a href="" class="dropdown-item d-flex align-items-center text-danger" data-bs-toggle="modal"
                            data-bs-target="#cancelarModal{{$pedido->id}}">
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
                        <a href="" class="dropdown-item d-flex align-items-center text-danger" data-bs-toggle="modal"
                            data-bs-target="#cancelarModal{{$pedido->id}}">
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

    <a href="{{route('pedido.gestor', ['id' => $pedido->id])}}" class="text-decoration-none text-black">

        <!-- CORPO PEDIDO -->
        <div class="fw-medium px-3 py-2 text-secondary">
            <p class="m-0 d-flex align-items-center">
                <span class="material-symbols-outlined mr-1 fs-5" style="font-variation-settings: 'FILL' 1;">
                    schedule
                </span>
                Recebido {{ \Carbon\Carbon::parse($pedido->feito_em)->diffForHumans() }}
            </p>

            <!-- CONSUMO -->
            @if($pedido->tipo == "DINE_IN")
            <p class="m-0 d-flex align-items-center">
                <span class="material-symbols-outlined mr-1 fs-5" style="font-variation-settings: 'FILL' 1;">
                    table_restaurant
                </span>
                Mesa {{$pedido->mesa->nome}}
            </p>

            @elseif($pedido->tipo == "TAKEOUT")
            <p class="m-0 d-flex align-items-center">
                <span class="material-symbols-outlined mr-1 fs-5" style="font-variation-settings: 'FILL' 1;">
                    shopping_bag
                </span>
                Para viagem
            </p>

            @elseif($pedido->tipo == "DELIVERY")
            <p class="m-0 d-flex align-items-center">
                <span class="material-symbols-outlined mr-1 fs-5" style="font-variation-settings: 'FILL' 1;">
                    two_wheeler
                </span>
                Entrega
            </p>
            <!-- FIM CONSUMO -->

            <!-- FORMA PAGAMENTO -->
            @if($pedido->tipo == "DELIVERY")

            <div class="d-flex align-items-center">
                <img src="{{ asset('storage/icones-forma-pagamento/' .$pedido->forma_pagamento->imagem . '.svg') }}"
                    alt="" width="20px">
                <p class="p-0 ml-1 my-0">
                    @if($pedido->is_pagamento_entrega == 0)
                    Pago R$ {{number_format($pedido->total, 2, ',', '.')}} online.
                    @else
                    Cobrar R$ {{number_format($pedido->total, 2, ',', '.')}} na entrega.
                    @endif
                </p>
            </div>

            @endif
            <!-- FIM FORMA PAGAMENTO -->

            @if($pedido->via_ifood == false)
            <p class="m-0 d-flex align-items-center">
                <span class="material-symbols-outlined mr-1 fs-5 text-secondary"
                    style="font-variation-settings: 'FILL' 1;">
                    calendar_clock
                </span>
                {{ \Carbon\Carbon::parse($pedido->feito_em)->addMinutes($pedido->entrega->tempo_min)->format('H:i') }}
                -
                {{ \Carbon\Carbon::parse($pedido->feito_em)->addMinutes($pedido->entrega->tempo_max)->format('H:i') }}
            </p>
            @else
            <p class="text-padrao fw-semibold mb-0">
                via iFood
            </p>
            @endif
            @endif

        </div>
        <!-- FIM CORPO PEDIDO -->

    </a>
</div>
@endforeach
<!-- FIM PEDIDO -->