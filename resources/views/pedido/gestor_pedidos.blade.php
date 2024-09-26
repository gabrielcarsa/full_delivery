<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <link href="{{ asset('css/master.css') }}" rel="stylesheet">
    @livewireStyles
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

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
            <div class="col-md-3 m-3 shadow-md p-2 rounded {{isset($data['pedido']) && $data['pedido']->id == $pedido->id ? 'bg-light' : 'bg-white' }}"
                {{isset($data['pedido']) && $data['pedido']->id == $pedido->id ? '' : 'style="max-height: 400px !important"' }}>
                <a href="{{route('pedido.show', ['id' => $pedido->id])}}" class="text-decoration-none text-black">

                    <p class="text-secondary fs-6 px-2 m-0"># {{$pedido->id}}</p>

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
                        <div class="col-md-4 d-flex justify-content-end text-dark">

                        </div>
                    </div>
                    <!-- FIM HEADER PEDIDO -->

                    <!-- CORPO PEDIDO -->
                    <div class="text-dark-50 fw-medium px-2">
                        <p class="m-0">
                            {{\Carbon\Carbon::parse($pedido->feito_em)->format('d/m/Y')}} -
                            {{\Carbon\Carbon::parse($pedido->feito_em)->format('H:i')}}
                        </p>
                        @if($pedido->status == 0)
                        <div class="d-flex fw-bold">
                            <span class="material-symbols-outlined d-flex align-items-center text-warning mr-1"
                                style="font-variation-settings: 'FILL' 1;">
                                pending
                            </span>
                            <p class="m-0 p-0">Pedido pendente</p>
                        </div>
                        @elseif($pedido->status == 1)
                        <div class="d-flex fw-bold">
                            <span class="material-symbols-outlined d-flex align-items-center text-warning mr-1"
                                style="font-variation-settings: 'FILL' 1;">
                                skillet
                            </span>
                            <p class="m-0 p-0">Pedido em preparo</p>
                        </div>
                        @elseif($pedido->status == 2)
                        <div class="d-flex fw-bold">
                            <span class="material-symbols-outlined d-flex align-items-center text-primary mr-1"
                                style="font-variation-settings: 'FILL' 1;">
                                sports_motorsports
                            </span>
                            <p class="m-0 p-0">Pedido a caminho</p>
                        </div>
                        @elseif($pedido->status == 3)
                        <div class="d-flex fw-bold">
                            <span class="material-symbols-outlined text-success d-flex align-items-center mr-1"
                                style="font-variation-settings: 'FILL' 1;">
                                check_circle
                            </span>
                            <p class="m-0 p-0">Pedido Concluído</p>
                        </div>
                        @elseif($pedido->status == 4)
                        <div class="d-flex fw-bold">
                            <span class="material-symbols-outlined text-danger d-flex align-items-center mr-1"
                                style="font-variation-settings: 'FILL' 1;">
                                error
                            </span>
                            <p class="m-0 p-0">Pedido Rejeitado</p>
                        </div>
                        @elseif($pedido->status == 5)
                        <div class="d-flex fw-bold">
                            <span class="material-symbols-outlined text-danger d-flex align-items-center mr-1"
                                style="font-variation-settings: 'FILL' 1;">
                                warning
                            </span>
                            <p class="m-0 p-0">Pedido Cancelado</p>
                        </div>
                        @endif

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
                    <div class="modal fade modal-lg" id="modalDetalhes" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDetalhesLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p class="modal-title fs-5" id="modalDetalhesLabel">
                                        Pedido #{{$pedido->id}}
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
                                    <button type="button" class="btn border-padrao text-padrao" data-bs-dismiss="modal">
                                        Fechar
                                    </button>
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

    </div>

    @stack('modals')

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery.min.js"></script>


</body>

</html>