<x-app-layout>

    <!-- MENSAGENS -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- FIM MENSAGENS -->


    <!-- HEADER -->
    <div class="p-2 m-0">

        <!-- TITULO -->
        <div class="mt-3">
            <h2 class="m-0 fw-bolder fs-2 text-black">
                Gestor de Pedidos
            </h2>
        </div>
        <!-- FIM TITULO -->

        <!-- FILTROS -->
        <div class="overflow-x-scroll w100 m-0">
            <div class="d-flex flex-nowrap py-3">
                @php
                $filtro = request()->input('filtro'); // Obtendo o valor do filtro da URL
                @endphp
                @if(isset($filtro) && is_numeric($filtro))
                <a href="{{ route('pedido.gestor') }}"
                    class="mx-1 p-0 rounded text-decoration-none fw-semibold text-white d-flex align-items-center justify-content-center"
                    style="min-width: 180px; background-color: #FD0146 !important">
                    @if($filtro == 0)
                    Pendentes
                    @elseif($filtro == 1)
                    Em preparo
                    @elseif($filtro == 2)
                    A caminho
                    @elseif($filtro == 3)
                    Concluídos
                    @elseif($filtro == 4)
                    Rejeitados
                    @elseif($filtro == 5)
                    Cancelados
                    @endif
                    <span class="badge text-bg-light mx-1">
                        {{isset($data['pedidos']) ? $data['pedidos']->count() : '0'}}
                    </span>
                    <span class="material-symbols-outlined ml-1 text-light">
                        close
                    </span>
                </a>
                @endif

                @if($filtro == null || $filtro != 0)
                <a href="{{ route('pedido.gestor', ['filtro' => 0]) }}"
                    class="p-2 mx-1 border rounded text-decoration-none text-center text-secondary"
                    style="min-width: 110px;">
                    Pendentes
                </a>
                @endif

                @if($filtro != 1)
                <a href="{{ route('pedido.gestor', ['filtro' => 1]) }}"
                    class="p-2 mx-1 border rounded text-decoration-none text-center text-secondary"
                    style="min-width: 110px;">
                    Em preparo
                </a>
                @endif

                @if($filtro != 2)
                <a href="{{ route('pedido.gestor', ['filtro' => 2]) }}"
                    class="p-2 mx-1 border rounded text-decoration-none text-center text-secondary"
                    style="min-width: 110px;">
                    A caminho
                </a>
                @endif

                @if($filtro != 3)
                <a href="{{ route('pedido.gestor', ['filtro' => 3]) }}"
                    class="p-2 mx-1 border rounded text-decoration-none text-center text-secondary"
                    style="min-width: 110px;">
                    Concluídos
                </a>
                @endif

                @if($filtro != 4)
                <a href="{{ route('pedido.gestor', ['filtro' => 4]) }}"
                    class="p-2 mx-1 border rounded text-decoration-none text-center text-secondary"
                    style="min-width: 110px;">
                    Rejeitados
                </a>
                @endif

                @if($filtro != 5)
                <a href="{{ route('pedido.gestor', ['filtro' => 5]) }}"
                    class="p-2 mx-1 border rounded text-decoration-none text-center text-secondary"
                    style="min-width: 110px;">
                    Cancelados
                </a>
                @endif

            </div>
        </div>
        <!-- FIM FILTROS -->

    </div>
    <!-- FIM HEADER -->

    <!-- PEDIDOS GRID -->
    <div class="row g-3">
        @if(isset($data['pedidos']))

        <!-- PEDIDOS -->
        @foreach($data['pedidos'] as $pedido)

        <!-- PEDIDO -->
        <div
            class="col-md-3 m-3 shadow-md p-2 rounded {{isset($data['pedido']) && $data['pedido']->id == $pedido->id ? 'bg-light' : 'bg-white' }}">

            <p class="text-secondary fs-6 px-2 m-0"># 0{{$pedido->id}}0</p>

            <!-- HEADER PEDIDO -->
            <div class="row px-2">
                <div class="col-md-8">
                    <h4 class="fw-bold fs-4 text-dark text-uppercase">
                        @if($pedido->cliente_id != null)
                        {{$pedido->cliente->nome}}
                        @else
                        {{$pedido->nome_cliente}}
                        @endif
                    </h4>
                </div>

                <!-- BOTÃO DROPDOWN NO CANTO COM STATUS -->
                <div class="col-md-4 d-flex align-items-center justify-content-end">
                    <!-- DROPDOWN -->
                    <div class="dropdown">
                        @if($pedido->status == 0)
                        <button class="btn btn-outline-danger dropdown-toggle rounded-pill" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Pendente
                        </button>

                        @elseif($pedido->status == 1)
                        <button class="btn btn-warning dropdown-toggle rounded-pill" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Em preparo
                        </button>

                        @elseif($pedido->status == 2)
                        <button class="btn btn-primary dropdown-toggle rounded-pill" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            A caminho
                        </button>

                        @elseif($pedido->status == 3)
                        <button class="btn btn-success dropdown-toggle rounded-pill" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Concluído
                        </button>

                        @elseif($pedido->status == 4)
                        <button class="btn btn-danger dropdown-toggle rounded-pill" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Rejeitado
                        </button>

                        @elseif($pedido->status == 5)
                        <button class="btn btn-secondary dropdown-toggle rounded-pill" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Cancelado
                        </button>

                        @endif

                        <!-- AÇÕES DROPDOWN -->
                        <ul class="dropdown-menu">

                            <!-- STATUS DO PEDIDO -->
                            @if($pedido->status == 0)
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
                                    data-bs-toggle="modal" data-bs-target="#rejeitarModal{{$pedido->id}}">
                                    <span class="material-symbols-outlined mr-1">
                                        dangerous
                                    </span>
                                    <span>
                                        Rejeitar pedido
                                    </span>
                                </a>
                            </li>

                            @elseif($pedido->status == 1 && $pedido->consumo_local_viagem_delivery == 3)
                            <li>
                                <a href="{{route('pedido.update_status', ['id' => $pedido->id])}}"
                                    class="dropdown-item d-flex align-items-center">
                                    <span class="material-symbols-outlined">
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

                            @elseif($pedido->status == 2 && $pedido->consumo_local_viagem_delivery == 3)
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

                            @elseif($pedido->status == 1 && $pedido->consumo_local_viagem_delivery == 1)
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

            <!-- MODAL REJEITAR PEDIDO -->
            <div class="modal fade" id="rejeitarModal{{$pedido->id}}" tabindex="-1" aria-labelledby="rejeitarModal"
                aria-hidden="true">
                <div class="modal-dialog">
                    <!-- FORM ACAO -->
                    <form action="{{route('pedido.rejeitar', ['id' => $pedido->id])}}" method="POST" class="my-2">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="rejeitarModal">Deseja mesmo
                                    rejeitar esse pedido # 0{{$pedido->id}}0?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
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


            <a href="{{route('pedido.show', ['id' => $pedido->id])}}" class="text-decoration-none text-black">

                <!-- CORPO PEDIDO -->
                <div class="text-dark-50 fw-medium px-2">
                    <p class="m-0">
                        {{\Carbon\Carbon::parse($pedido->feito_em)->format('d/m/Y')}} -
                        {{\Carbon\Carbon::parse($pedido->feito_em)->format('H:i')}}
                    </p>

                    <!-- CONSUMO -->
                    @if($pedido->consumo_local_viagem_delivery == 1)
                    <p class="m-0 text-secondary">
                        Consumo no local
                    </p>
                    <p class="m-0 text-secondary">
                        Mesa {{$pedido->mesa->nome}}
                    </p>

                    @elseif($pedido->consumo_local_viagem_delivery == 2)
                    <p class="mx-0 my-1 text-secondary">
                        Para viagem
                    </p>

                    @elseif($pedido->consumo_local_viagem_delivery == 3)
                    <p class="mx-0 my-1 text-secondary">
                        {{$pedido->entrega->rua}},
                        {{$pedido->entrega->bairro}},
                        {{$pedido->entrega->numero}}
                    </p>
                    @endif
                    <!-- CONSUMO -->

                    <!-- FORMA PAGAMENTO -->
                    @if($pedido->consumo_local_viagem_delivery == 3)

                    @if($pedido->forma_pagamento_loja->id != null)

                    <div class="d-flex align-items-center" style="font-size: 14px !important">
                        <img src="{{ asset('storage/icones-forma-pagamento/' .$pedido->forma_pagamento_loja->imagem . '.svg') }}"
                            alt="" width="30px">
                        <p class="p-0 mx-1 my-0">{{$pedido->forma_pagamento_loja->nome}}</p>
                    </div>

                    @else

                    <div class="d-flex align-items-center" style="font-size: 14px !important">
                        <img src="{{ asset('storage/icones-forma-pagamento/' .$pedido->forma_pagamento_foomy->imagem . '.svg') }}"
                            alt="" width="30px">
                        <p class="p-0 mx-1 my-0">{{$pedido->forma_pagamento_foomy->nome}}</p>
                    </div>

                    @endif

                    @endif
                    <!-- FIM FORMA PAGAMENTO -->

                </div>
                <!-- FIM CORPO PEDIDO -->

                <!-- MODAL DETALHES PEDIDO -->
                <div class="modal fade modal-lg" id="modalDetalhes" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="modalDetalhesLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p class="fw-semibold fs-5 m-0" id="modalDetalhesLabel">
                                    Detalhes do pedido
                                </p>
                            </div>
                            <div class="modal-body">
                                <!-- PEDIDO DETALHE -->
                                @if(isset($data['pedido']))
                                <x-show-pedido :pedido="$data['pedido']" />
                                @endif
                                <!-- FIM PEDIDO DETALHE -->
                            </div>
                            <div class="modal-footer">
                                <a href="{{ route('pedido.gestor') }}" class="btn border-padrao text-padrao">
                                    Fechar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIM MODAL DETALHES PEDIDO -->

                <!-- Verificar se o modal deve ser aberto -->
                @if(isset($data['pedido']) && $data['pedido']->id == $pedido->id)
                <script>
                // Espera o DOM ser completamente carregado
                document.addEventListener('DOMContentLoaded', function() {
                    var myModal = new bootstrap.Modal(document.getElementById('modalDetalhes'));
                    myModal.show();
                });
                </script>
                @endif

            </a>
        </div>
        <!-- FIM PEDIDO -->


        @endforeach
        <!-- FIM PEDIDOS -->

        @endif

    </div>
    <!-- FIM PEDIDOS GRID -->

</x-app-layout>