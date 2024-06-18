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
    <link href="https://fonts.googleapis.com/css2?family=Madimi+One&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Madimi+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <link href="{{ asset('css/tema-sb-admin.css') }}" rel="stylesheet">
    @livewireStyles
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            <div class="flex">
                <!-- Sidebar -->
                <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

                    <!-- Nav Item - Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'nav-link-active' : 'nav-link-desactive'}}"
                            href="{{ route('dashboard') }}">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span>{{ __('Dashboard') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="">
                            <i class="fa-solid fa-list-check"></i>
                            <span> Painel de Pedidos</span>
                        </a>

                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Pessoas
                    </div>

                    <!-- Nav Item  -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'nav-link-active' : 'nav-link-desactive'}}"
                            href="{{ route('register') }}">
                            <i class="fa-solid fa-user"></i>
                            <span> {{ __('Cadastrar Usuário') }}</span>
                        </a>

                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href="">
                            <i class="fa-solid fa-user"></i>
                            <span> Clientes</span>
                        </a>

                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Negócios
                    </div>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('restaurante') ? 'nav-link-active' : 'nav-link-desactive'}}"
                            href="{{ route('restaurante') }}">
                            <i class="fa-solid fa-house"></i>
                            <span>Restaurante</span>
                        </a>

                    </li>
                    <!-- Nav Item - Utilities Collapse Menu -->
                    <li class="nav-item dropend ">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" id="dropdownCardapio"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-burger"></i>
                            <span>Cardápio</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCardapio">
                            <li><a class="dropdown-item" href="#">Visual</a></li>
                            <li><a class="dropdown-item" href="{{ route('categoria_produto') }}">Categoria de
                                    produtos</a></li>
                        </ul>
                    </li>


                    <!-- Nav Item - Charts -->
                    <li class="nav-item">
                        <a class="nav-link" href="charts.html">
                            <i class="fas fa-fw fa-chart-area"></i>
                            <span>Charts</span></a>
                    </li>

                    <!-- Nav Item - Tables -->
                    <li class="nav-item">
                        <a class="nav-link" href="tables.html">
                            <i class="fas fa-fw fa-table"></i>
                            <span>Tables</span></a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider d-none d-md-block">

                    <!-- Sidebar Toggler (Sidebar) -->
                    <div class="text-center d-none d-md-inline">
                        <button class="rounded-circle border-0" id="sidebarToggle"></button>
                    </div>


                </ul>
                <!-- End of Sidebar -->

                <div class="container-fluid">
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

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.js') }}"></script>

    <script src="https://kit.fontawesome.com/e9fb33108b.js" crossorigin="anonymous"></script>
</body>

</html>