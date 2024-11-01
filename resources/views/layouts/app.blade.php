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

        <!-- Page Content -->
        <main>
            <div class="d-flex">
                <div class="col-2 px-0 border-end bg-white">
                    <div class="vh-100 p-3">
                        <p class="p-0 m-0 fw-regular" style="font-size: 14px">conectado como</p>
                        <h4 class="p-0 m-0 fs-3 fw-bold">
                            {{session('lojaConectado') != null ? session('lojaConectado')['nome'] : '---'}}
                        </h4>
                        <a href="{{ route('loja') }}"
                            class="d-flex align-items-center align-middle fs-6 text-decoration-none text-padrao">
                            <span class="material-symbols-outlined fs-6">
                                change_circle
                            </span>
                            <span>{{session('lojaConectado') != null ? 'Trocar loja': 'Selecionar loja'}}</span>
                        </a>
                        <hr>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                            id="menu">

                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}"
                                    class="nav-link d-flex align-items-center align-middle px-0 {{ request()->routeIs('dashboard') ? 'nav-link-active' : 'nav-link-desactive'}} text-black">
                                    <span class="material-symbols-outlined">
                                        dashboard
                                    </span>
                                    <span class="ml-1 d-none d-sm-inline">Dashboard</span>
                                </a>
                            </li>

                            <!-- Nav Item - GESTOR DE PEDIDOS E MESAS DROPEND -->
                            <li class="nav-item dropend">
                                <a class="nav-link d-flex align-items-center align-middle px-0 collapsed nav-link-desactive dropdown-toggle text-black"
                                    href="#" data-toggle="collapse" id="dropdownCardapio" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <span class="material-symbols-outlined">
                                        receipt_long
                                    </span>
                                    <span class="ml-1 d-none d-sm-inline">Pedidos</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCardapio">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('pedido.gestor') }}">
                                            Gestor de Pedidos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('mesa.gestor') }}">
                                            Gestor de Mesas
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center align-middle px-0 {{ request()->routeIs('register') ? 'nav-link-active' : 'nav-link-desactive'}} text-black"
                                    href="{{ route('register') }}">
                                    <span class="material-symbols-outlined">
                                        person_add
                                    </span>
                                    <span class="ml-1 d-none d-sm-inline">Cadastrar Usuário</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center align-middle px-0 {{ request()->routeIs('cliente') ? 'nav-link-active' : 'nav-link-desactive'}} text-black"
                                    href="{{ route('cliente') }}">
                                    <span class="material-symbols-outlined">
                                        groups
                                    </span>
                                    <span class="ml-1 d-none d-sm-inline"> Clientes</span>
                                </a>
                            </li>


                            <!-- Nav Item - LOJAS DROPEND -->
                            <li class="nav-item dropend">
                                <a class="nav-link d-flex align-items-center align-middle px-0 collapsed nav-link-desactive dropdown-toggle text-black"
                                    href="#" data-toggle="collapse" id="dropdownCardapio" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <span class="material-symbols-outlined">
                                        storefront
                                    </span>
                                    <span class="ml-1 d-none d-sm-inline">Loja</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCardapio">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('loja') }}">
                                            Minhas Lojas
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('mesa') }}">
                                            Cadastro de Mesas
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Nav Item - ENTREGAS DROPEND -->
                            <li class="nav-item dropend">
                                <a class="nav-link d-flex align-items-center align-middle px-0 collapsed nav-link-desactive dropdown-toggle text-black"
                                    href="#" data-toggle="collapse" id="dropdownCardapio" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <span class="material-symbols-outlined">
                                        sports_motorsports
                                    </span>
                                    <span class="ml-1 d-none d-sm-inline">Entregas</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCardapio">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('loja.entrega_taxas') }}">
                                            Taxas
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('loja.entrega_areas') }}">
                                            Áreas
                                        </a>
                                    </li>
                                </ul>
                            </li>


                            <!-- Nav Item - CARDAPIO DROPEND -->
                            <li class="nav-item dropend">
                                <a class="nav-link d-flex align-items-center align-middle px-0 collapsed nav-link-desactive dropdown-toggle text-black"
                                    href="#" data-toggle="collapse" id="dropdownCardapio" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <span class="material-symbols-outlined">
                                        restaurant_menu
                                    </span>
                                    <span class="ml-1 d-none d-sm-inline">Cardápio</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCardapio">
                                    <li>
                                        <a class="dropdown-item" href="#">Visual</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('categoria_produto') }}">
                                            Categorias e produtos
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Nav Item - FINANCEIRO DROPEND -->
                            <li class="nav-item dropend">
                                <a class="nav-link d-flex align-items-center align-middle px-0 collapsed nav-link-desactive dropdown-toggle text-black"
                                    href="#" data-toggle="collapse" id="dropdownCardapio" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <span class="material-symbols-outlined">
                                        payments
                                    </span>
                                    <span class="ml-1 d-none d-sm-inline">Financeiro</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCardapio">
                                    <li>
                                        <a class="dropdown-item" href="#">Vendas</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('forma_pagamento') }}">
                                            Formas de pagamento
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('contas_receber.index') }}">
                                            Contas a receber
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('forma_pagamento') }}">
                                            Contas a pagar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('forma_pagamento') }}">
                                            Movimentações
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center align-middle px-0 {{ request()->routeIs('notificacoes') ? 'nav-link-active' : 'nav-link-desactive'}} text-black"
                                    href="">
                                    <span class="material-symbols-outlined">
                                        campaign
                                    </span>
                                    <span class="ml-1 d-none d-sm-inline">Notificações app</span>
                                </a>
                            </li>

                            <!-- Nav Item - VANTAGENS DROPEND -->
                            <li class="nav-item dropend">
                                <a class="nav-link d-flex align-items-center align-middle px-0 collapsed nav-link-desactive dropdown-toggle text-black"
                                    href="#" data-toggle="collapse" id="dropdownCardapio" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <span class="material-symbols-outlined">
                                        favorite
                                    </span>
                                    <span class="ml-1 d-none d-sm-inline">Vantagens</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCardapio">
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

                            <!-- Nav Item - FINANCEIRO DROPEND -->
                            <li class="nav-item dropend">
                                <a class="nav-link d-flex align-items-center align-middle px-0 collapsed nav-link-desactive dropdown-toggle text-black"
                                    href="#" data-toggle="collapse" id="dropdownCardapio" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <span class="material-symbols-outlined">
                                        settings
                                    </span>
                                    <span class="ml-1 d-none d-sm-inline">
                                        Configurações
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCardapio">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('categoria_financeiro.listar') }}">
                                            Categoria Financeiro
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="">
                                            Conta Corrente
                                        </a>
                                    </li>
                                    
                                </ul>
                            </li>

                        </ul>

                    </div>
                </div>

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