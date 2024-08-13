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

        <!-- PEDIDOS -->
        <div class="row m-0">

            <!-- MENU LATERAL PEDIDOS -->
            <div class="col-md-auto m-0 p-0 vh-100" style="overflow-y: auto; overflow-x: hidden;">
                <div class="bg-white border-end m-0 h-100" style="max-width: 400px">

                    <!-- HEADER -->
                    <div class="p-2 m-0">
                        <div class="row">
                            <div class="col d-flex justify-content-center w100">
                                <a href="{{ route('pedido.novo') }}" class="btn btn-primary">
                                    Simular pedido
                                </a>
                            </div>
                            <div class="col d-flex justify-content-center w100">
                                <a href="" class="btn btn-secondary">
                                    Configurações
                                </a>
                            </div>
                        </div>

                        <!-- HEADER -->
                        <div class="row">
                            <div class="col">
                                <h2 class="mt-3 fw-bolder fs-2 text-black">
                                    Painel de Pedidos
                                </h2>
                            </div>
                        </div>
                        <!-- FIM HEADER -->

                        <!-- FILTROS -->
                        <div class="overflow-x-scroll w100 m-0">
                            <div class="d-flex flex-nowrap py-3">
                                @php
                                $filtro = request()->input('filtro'); // Obtendo o valor do filtro da URL
                                @endphp
                                @if(isset($filtro) && is_numeric($filtro))
                                <a href="{{ route('pedido.painel') }}"
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

                                @if($filtro != 0)
                                <a href="{{ route('pedido.painel', ['filtro' => 0]) }}"
                                    class="p-2 mx-1 border rounded text-decoration-none text-center text-secondary"
                                    style="min-width: 110px;">
                                    Pendentes
                                </a>
                                @endif

                                @if($filtro != 1)
                                <a href="{{ route('pedido.painel', ['filtro' => 1]) }}"
                                    class="p-2 mx-1 border rounded text-decoration-none text-center text-secondary"
                                    style="min-width: 110px;">
                                    Em preparo
                                </a>
                                @endif

                                @if($filtro != 2)
                                <a href="{{ route('pedido.painel', ['filtro' => 2]) }}"
                                    class="p-2 mx-1 border rounded text-decoration-none text-center text-secondary"
                                    style="min-width: 110px;">
                                    A caminho
                                </a>
                                @endif

                                @if($filtro != 3)
                                <a href="{{ route('pedido.painel', ['filtro' => 3]) }}"
                                    class="p-2 mx-1 border rounded text-decoration-none text-center text-secondary"
                                    style="min-width: 110px;">
                                    Concluídos
                                </a>
                                @endif

                                @if($filtro != 4)
                                <a href="{{ route('pedido.painel', ['filtro' => 4]) }}"
                                    class="p-2 mx-1 border rounded text-decoration-none text-center text-secondary"
                                    style="min-width: 110px;">
                                    Rejeitados
                                </a>
                                @endif

                                @if($filtro != 5)
                                <a href="{{ route('pedido.painel', ['filtro' => 5]) }}"
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

                    <!-- MENU PEDIDOS -->
                    <div>
                        @if(isset($data['pedidos']))

                        @foreach($data['pedidos'] as $pedido)

                        <!-- COLLAPSE PEDIDOS -->
                        <a href="{{route('pedido.show', ['id' => $pedido->id])}}"
                            class="text-decoration-none text-black">

                            <div
                                class="my-3 shadow-md p-2 {{isset($data['pedido']) && $data['pedido']->id == $pedido->id ? 'bg-light border-end-0 border-top-0 border-bottom-0 border-danger border-5' : 'bg-white' }}">

                                <p class="text-secondary fs-6 px-2 m-0"># {{$pedido->id}}</p>

                                <!-- HEADER PEDIDOS -->
                                <div class="row px-2">
                                    <div class="col-md-8">
                                        <h4 class="fw-bold fs-4 text-dark text-uppercase">{{$pedido->cliente->nome}}
                                        </h4>
                                    </div>
                                    <div class="col-md-4 d-flex justify-content-end text-dark">
                                        <p>{{\Carbon\Carbon::parse($pedido->data_pedido)->format('H:i')}}</p>
                                    </div>
                                </div>
                                <!-- FIM COLLAPSE PEDIDOS -->

                                <!-- CORPO COLLAPSE PEDIDOS -->
                                <div class="text-dark-50 fw-medium px-2">

                                    @if($pedido->status == 0)
                                    <div class="d-flex fw-bold">
                                        <span
                                            class="material-symbols-outlined d-flex align-items-center text-warning mr-1"
                                            style="font-variation-settings: 'FILL' 1;">
                                            pending
                                        </span>
                                        <p class="m-0 p-0">Pedido pendente</p>
                                    </div>
                                    @elseif($pedido->status == 1)
                                    <div class="d-flex fw-bold">
                                        <span
                                            class="material-symbols-outlined d-flex align-items-center text-warning mr-1"
                                            style="font-variation-settings: 'FILL' 1;">
                                            skillet
                                        </span>
                                        <p class="m-0 p-0">Pedido em preparo</p>
                                    </div>
                                    @elseif($pedido->status == 2)
                                    <div class="d-flex fw-bold">
                                        <span
                                            class="material-symbols-outlined d-flex align-items-center text-primary mr-1"
                                            style="font-variation-settings: 'FILL' 1;">
                                            sports_motorsports
                                        </span>
                                        <p class="m-0 p-0">Pedido a caminho</p>
                                    </div>
                                    @elseif($pedido->status == 3)
                                    <div class="d-flex fw-bold">
                                        <span
                                            class="material-symbols-outlined text-success d-flex align-items-center mr-1"
                                            style="font-variation-settings: 'FILL' 1;">
                                            check_circle
                                        </span>
                                        <p class="m-0 p-0">Pedido Concluído</p>
                                    </div>
                                    @elseif($pedido->status == 4)
                                    <div class="d-flex fw-bold">
                                        <span
                                            class="material-symbols-outlined text-danger d-flex align-items-center mr-1"
                                            style="font-variation-settings: 'FILL' 1;">
                                            error
                                        </span>
                                        <p class="m-0 p-0">Pedido Rejeitado</p>
                                    </div>
                                    @elseif($pedido->status == 5)
                                    <div class="d-flex fw-bold">
                                        <span
                                            class="material-symbols-outlined text-danger d-flex align-items-center mr-1"
                                            style="font-variation-settings: 'FILL' 1;">
                                            warning
                                        </span>
                                        <p class="m-0 p-0">Pedido Cancelado</p>
                                    </div>
                                    @endif


                                    @if($pedido->consumo_local_viagem_delivery == 1)
                                    <p class="p-0 m-0">
                                        Consumo no local
                                    </p>

                                    @elseif($pedido->consumo_local_viagem_delivery == 2)
                                    <p class="p-0 m-0">
                                        Para viagem
                                    </p>

                                    @elseif($pedido->consumo_local_viagem_delivery == 3)
                                    <p class="p-0 m-0">
                                        {{$pedido->entrega->rua}},
                                        {{$pedido->entrega->bairro}},
                                        {{$pedido->entrega->numero}}
                                    </p>

                                    @endif
                                    <p class="p-0 m-0">{{$pedido->forma_pagamento_entrega->forma}}</p>
                                </div>
                                <!-- FIM CORPO COLLAPSE PEDIDOS -->

                            </div>
                            <!-- FIM COLLAPSE PEDIDOS -->

                        </a>

                        @endforeach

                        @endif

                    </div>
                    <!-- FIM MENU PEDIDOS -->

                </div>
            </div>
            <!-- FIM MENU LATERAL PEDIDOS -->

            <!-- CONTEUDO PEDIDOS -->
            <div class="col m-0 p-3" style="overflow-y: auto; overflow-x: hidden; height: 100vh">
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

                <!-- PEDIDO DETALHE -->
                @if(isset($data['pedido']))
                <x-show-pedido :pedido="$data['pedido']" />
                @endif

            </div>
            <!-- FIM CONTEUDO PEDIDOS -->

        </div>

        <!-- FIM PEDIDOS -->

        </main>
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