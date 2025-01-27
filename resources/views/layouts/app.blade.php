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

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default" async></script>

</head>

<body class="font-sans antialiased">
    <!-- MENSAGENS -->
    @if(session('success'))
    <x-toasts-message type="success" message="{{ session('success') }}" />
    @endif

    @if(session('error'))
    <x-toasts-message type="danger" message="{{ session('error') }}" />
    @endif

    @if($errors->any())
    @foreach ($errors->all() as $error)
    <x-toasts-message type="danger" message="{{ $error }}" />
    @endforeach
    @endif
    <!-- FIM MENSAGENS -->

    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Content -->
        <main>
            <div class="d-flex">

                @if(session('selected_store'))
                <div class="border-end bg-white vh-100">
                    <ul class="m-0 p-0">

                        <!-- Nav Item - GESTOR DE PEDIDOS E MESAS DROPEND -->
                        <li class="d-flex align-items-center justify-content-center dropend hover">
                            <a class="btn text-decoration-none text-center text-secondary w-100" href="#"
                                data-toggle="collapse" id="dropdownCardapio" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="material-symbols-outlined fs-4">
                                    receipt_long
                                </span>
                                <p class="m-0 p-0">Pedidos</p>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownCardapio">
                                <li>
                                    <p class="text-secondary mb-1 ms-3" style="font-size: 13px">
                                        Pedidos
                                    </p>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('pedido.painel') }}">
                                        Painel de Pedidos
                                    </a>
                                </li>
                                <hr>
                                <li>
                                    <p class="text-secondary mb-1 ms-3" style="font-size: 13px">
                                        Mesas
                                    </p>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('mesa.painel') }}">
                                        Painel de Mesas
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Nav Item - CLIENTES DROPEND -->
                        <li class="d-flex align-items-center justify-content-center border-top dropend hover">
                            <a class="btn text-decoration-none text-center text-secondary w-100" href="#"
                                data-toggle="collapse" id="" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined fs-4">
                                    groups
                                </span>
                                <p class="m-0 p-0">
                                    Clientes
                                </p>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="">
                                <li>
                                    <p class="text-secondary mb-1 ms-3" style="font-size: 13px">
                                        Cadastro geral
                                    </p>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('cliente') }}">
                                        Clientes
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('cliente') }}">
                                        Fornecedores
                                    </a>
                                </li>
                                <hr>
                                <li>
                                    <p class="text-secondary mb-1 ms-3" style="font-size: 13px">
                                        Vantagens
                                    </p>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Cashback</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="">Assinaturas</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('cupom') }}">Cupons</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Nav Item - LOJAS DROPEND -->
                        <li class="d-flex align-items-center justify-content-center border-top dropend hover">
                            <a class="btn text-decoration-none text-center text-secondary w-100" href="#"
                                data-toggle="collapse" id="dropdownCardapio" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="material-symbols-outlined fs-4">
                                    storefront
                                </span>
                                <p class="m-0 p-0">
                                    Loja
                                </p>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCardapio">
                                <li>
                                    <p class="text-secondary mb-1 ms-3" style="font-size: 13px">
                                        {{session('selected_store') != null ? session('selected_store')['nome'] : 'Sua loja' }}
                                    </p>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('store.show', ['store' => session('selected_store') ? session('selected_store')['id'] : null, 'tab' => 'sobre']) }}">
                                        Sobre
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('store.show', ['store' => session('selected_store') ? session('selected_store')['id'] : null, 'tab' => 'horarios']) }}">
                                        Horários de funcionamento
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('store.show', ['store' => session('selected_store') ? session('selected_store')['id'] : null, 'tab' => 'equipe']) }}">
                                        Equipe
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('store.show', ['store' => session('selected_store') ? session('selected_store')['id'] : null, 'tab' => 'planos']) }}">
                                        Planos
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('store.show', ['store' => session('selected_store') ? session('selected_store')['id'] : null, 'tab' => 'integracoes']) }}">
                                        Integrações
                                    </a>
                                </li>
                                <hr>
                                <li>
                                    <p class="text-secondary mb-1 ms-3" style="font-size: 13px">
                                        Mesas
                                    </p>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('mesa') }}">
                                        Cadastro de Mesas
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Nav Item - ENTREGAS DROPEND -->
                        <li class="d-flex align-items-center justify-content-center border-top dropend hover">
                            <a class="btn text-decoration-none text-center text-secondary w-100" href="#"
                                data-toggle="collapse" id="dropdownCardapio" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="material-symbols-outlined fs-4">
                                    sports_motorsports
                                </span>
                                <p class="m-0 p-0">Delivery</p>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCardapio">
                                <li>
                                    <p class="text-secondary mb-1 ms-3" style="font-size: 13px">
                                        Operação delivery
                                    </p>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('store.entrega_taxas') }}">
                                        Taxas de entrega
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('store.entrega_areas') }}">
                                        Áreas para entrega
                                    </a>
                                </li>
                                <hr>
                                <li>
                                    <p class="text-secondary mb-1 ms-3" style="font-size: 13px">
                                        Aplicativo personalizado
                                    </p>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="">
                                        Configurações gerais
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="">
                                        Notificações e marketing
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <!-- Nav Item - CARDAPIO DROPEND -->
                        <li class="d-flex align-items-center justify-content-center border-top dropend hover">
                            <a class="btn text-decoration-none text-center text-secondary w-100" href="#"
                                data-toggle="collapse" id="dropdownCardapio" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="material-symbols-outlined fs-4">
                                    restaurant_menu
                                </span>
                                <p class="m-0 p-0">Cardápio</p>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCardapio">
                                <li>
                                    <p class="text-secondary mb-1 ms-3" style="font-size: 13px">
                                        Cardápio
                                    </p>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        Layout
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('categoria_produto') }}">
                                        Categoria e produtos
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Nav Item - FINANCEIRO DROPEND -->
                        <li class="d-flex align-items-center justify-content-center border-top dropend hover">
                            <a class="btn text-decoration-none text-center text-secondary w-100" href="#"
                                data-toggle="collapse" id="dropdownCardapio" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="material-symbols-outlined fs-4">
                                    payments
                                </span>
                                <p class="m-0 p-0">Financeiro</p>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCardapio">
                                <li>
                                    <p class="text-secondary mb-1 ms-3" style="font-size: 13px">
                                        Financeiro
                                    </p>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('contas_receber.index') }}">
                                        Contas a receber
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('contas_pagar.index') }}">
                                        Contas a pagar
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('movimentacao.showFormConsulta') }}">
                                        Movimentações
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('categoria_financeiro.listar') }}">
                                        Categoria Financeiro
                                    </a>
                                </li>
                                <hr>
                                <li>
                                    <p class="text-secondary mb-1 ms-3" style="font-size: 13px">
                                        Vendas
                                    </p>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        Relatórios
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('forma_pagamento') }}">
                                        Formas de pagamento
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('conta_corrente.listar') }}">
                                        Conta Corrente
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Nav Item - FINANCEIRO DROPEND -->
                        <li class="d-flex align-items-center justify-content-center border-top dropend hover">
                            <a class="btn text-decoration-none text-center text-secondary w-100" href="#"
                                data-toggle="collapse" id="dropdownCardapio" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="material-symbols-outlined fs-4">
                                    package_2
                                </span>
                                <p class="m-0 p-0">
                                    Estoque
                                </p>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCardapio">
                                <li>
                                    <p class="text-secondary mb-1 ms-3" style="font-size: 13px">
                                        Controle Estoque
                                    </p>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="">
                                        Painel
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="">
                                        Insumos
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
                @endif

                <!-- CONTEÚDO -->
                <div class="container-fluid m-0 p-0">
                    {{ $slot }}
                </div>
            </div>

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