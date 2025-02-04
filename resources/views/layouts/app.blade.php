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

    <div class="bg-gray-100 min-h-screen">

        <!-- Page Content -->
        <main>
            <div class="d-flex w-100">

                @if(session('selected_store'))

                <!-- COLUNA SIDEBAR -->
                <div class="">

                    <!-- SIDEBAR -->
                    <div class="collapse collapse-horizontal show sticky-top" id="collapseSidebar">

                        <div class="m-0 border-end bg-white vh-100 py-3">

                            <!-- LOGO -->
                            <a href="{{ route('dashboard') }}">
                                <img src="{{asset("storage/images/logo-black.png")}}" width="150px" alt="Foomy"
                                    class="mx-auto my-2">
                            </a>
                            <!-- FIM LOGO -->

                            <div class="dropdown mx-3 border bg-light rounded">

                                <!-- LOJAS -->
                                @php
                                $stores = \App\Helpers\StoreHelper::getStoreUsers();

                                //Mudar status da Loja Selecionada
                                \App\Helpers\StoreHelper::updateStoreStatus();
                                @endphp
                                <!-- FIM LOJAS -->

                                <a class="btn d-flex align-items-center justify-content-between dropdown-toggle" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">

                                    <!-- SE EXISTIR LOJAS PARA O USUARIO CONECTADO -->
                                    @if(!empty($stores))

                                    @foreach($stores as $store)
                                    @if(session('selected_store') && $store->id == session('selected_store')['id'])
                                    <!-- LOJA CIRCULO STATUS -->
                                    @if($store->state == "OK" || $store->state == "WARNING")
                                    <span class="material-symbols-outlined mr-2 text-success"
                                        style="font-variation-settings: 'FILL' 1;">
                                        check_circle
                                    </span>
                                    @else
                                    <span class="material-symbols-outlined mr-2 text-danger"
                                        style="font-variation-settings: 'FILL' 1;">
                                        error
                                    </span>
                                    @endif
                                    <!-- FIM LOJA CIRCULO STATUS -->
                                    {{session('selected_store')['name']}}
                                    @else
                                    Selecione uma loja
                                    @endif
                                    @endforeach

                                    @else
                                    <span class="material-symbols-outlined mr-1">
                                        report
                                    </span>
                                    Nenhuma loja cadastrada ainda
                                    @endif
                                    <!-- FIM SE EXISTIR LOJAS PARA O USUARIO CONECTADO -->

                                </a>

                                <!-- DROPDOWN LOJAS -->
                                <ul class="dropdown-menu p-3 bg-light dropdown-menu-end" style="width: 400px">

                                    <!-- SE EXISTIR LOJAS PARA O USUARIO CONECTADO -->
                                    @if(!empty($stores))

                                    <div class="mb-3">
                                        <button onClick="window.location.reload()"
                                            class="text-primary text-decoration-underline">
                                            Atualizar
                                        </button>
                                    </div>

                                    @foreach($stores as $store)
                                    <li
                                        class="d-flex align-items-center justify-content-between rounded {{session('selected_store') && session('selected_store')['id'] == $store->id ? 'border-3 border-padrao' : 'bg-white'}} p-3">

                                        <div class="d-flex align-items-center">
                                            <!-- LOJA CIRCULO STATUS -->
                                            @if($store->state == "OK" || $store->state == "WARNING")
                                            <span class="material-symbols-outlined mr-2 text-success"
                                                style="font-variation-settings: 'FILL' 1;">
                                                check_circle
                                            </span>
                                            @else
                                            <span class="material-symbols-outlined mr-2 text-danger"
                                                style="font-variation-settings: 'FILL' 1;">
                                                error
                                            </span>
                                            @endif
                                            <!-- FIM LOJA CIRCULO STATUS -->

                                            <!-- LOJA DETALHES -->
                                            <div>
                                                <p class="fw-bold m-0">
                                                    {{$store->name}}
                                                </p>
                                                @if(!session('selected_store') || session('selected_store')['id'] ==
                                                $store->id)
                                                <p class="m-0 text-secondary">
                                                    @if($store->state == "OK" || $store->state == "WARNING")
                                                    Loja aberta
                                                    @else
                                                    Loja fechada
                                                    @endif
                                                </p>
                                                @endif
                                            </div>
                                            <!-- FIM LOJA DETALHES -->

                                        </div>

                                        <!-- BTN ESCOLHER LOJA -->
                                        @if(!session('selected_store') || session('selected_store')['id'] != $store->id)
                                        <form action="{{route('store.select', ['id' => $store->id])}}" method="post">
                                            @csrf
                                            <button type="submit"
                                                class="mx-2 p-2 text-white fw-semibold rounded w-100 bg-padrao">
                                                Selecionar loja
                                            </button>
                                        </form>
                                        @endif
                                        <!-- FIM BTN ESCOLHER LOJA -->

                                    </li>
                                    @endforeach

                                    @else
                                    Vamos começar gratuitamente? <a href="">
                                        Criar loja agora.
                                    </a>
                                    @endif
                                    <!-- FIM SE EXISTIR LOJAS PARA O USUARIO CONECTADO -->

                                </ul>
                                <!-- FIM DROPDOWN LOJAS -->
                            </div>

                            <hr>

                            <!-- ACCORDION -->
                            <div class="accordion accordion-flush" id="accordionSidebar">

                                <!-- ACCORDION ITEM -->
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <a class="accordion-button fw-medium collapsed text-decoration-none" href=""
                                            data-bs-toggle="collapse" data-bs-target="#collapse-orders"
                                            aria-controls="collapse-orders">
                                            <span class="material-symbols-outlined mr-2">
                                                receipt_long
                                            </span>
                                            Pedidos
                                        </a>
                                    </div>
                                    <div id="collapse-orders" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionSidebar">
                                        <div class="m-0 py-1">
                                            <ul class="fw-medium border-start border-secondary mx-2 ps-2"
                                                style="border-left-width: 4px !important;">
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('pedido.painel') }}">
                                                        Painel de Pedidos
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('mesa.painel') }}">
                                                        Painel de Mesas
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIM ACCORDION ITEM -->

                                <!-- ACCORDION ITEM -->
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <a class="accordion-button fw-medium collapsed text-decoration-none" href=""
                                            data-bs-toggle="collapse" data-bs-target="#collapse-customers"
                                            aria-controls="collapse-customers">
                                            <span class="material-symbols-outlined mr-2">
                                                groups
                                            </span>
                                            Clientes e Fornecedores
                                        </a>
                                    </div>
                                    <div id="collapse-customers" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionSidebar">
                                        <div class="m-0 py-1">
                                            <ul class="fw-medium border-start border-secondary mx-2 ps-2"
                                                style="border-left-width: 4px !important;">
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('cliente') }}">
                                                        Clientes
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary" href="">
                                                        Cashback
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary" href="">
                                                        Assinaturas
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary" href="">
                                                        Cupons
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('cupom') }}">
                                                        Fornecedores
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIM ACCORDION ITEM -->

                                <!-- ACCORDION ITEM -->
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <a class="accordion-button fw-medium collapsed text-decoration-none" href=""
                                            data-bs-toggle="collapse" data-bs-target="#collapse-stores"
                                            aria-controls="collapse-stores">
                                            <span class="material-symbols-outlined mr-2">
                                                storefront
                                            </span>
                                            Lojas
                                        </a>
                                    </div>
                                    <div id="collapse-stores" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionSidebar">
                                        <div class="m-0 py-1">
                                            <ul class="fw-medium border-start border-secondary mx-2 ps-2"
                                                style="border-left-width: 4px !important;">
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('store.show', ['store' => session('selected_store')['id'], 'tab' => 'sobre']) }}">
                                                        Sobre
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('store.show', ['store' => session('selected_store')['id'], 'tab' => 'horarios']) }}">
                                                        Horários de funcionamento
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('store.show', ['store' => session('selected_store')['id'], 'tab' => 'equipe']) }}">
                                                        Equipe
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('store.show', ['store' => session('selected_store')['id'], 'tab' => 'planos']) }}">
                                                        Planos
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('store.show', ['store' => session('selected_store')['id'], 'tab' => 'integracoes']) }}">
                                                        Integrações
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('store.show', ['store' => session('selected_store')['id'], 'tab' => 'mesas']) }}">
                                                        Mesas e comandas
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIM ACCORDION ITEM -->

                                <!-- ACCORDION ITEM -->
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <a class="accordion-button fw-medium collapsed text-decoration-none" href=""
                                            data-bs-toggle="collapse" data-bs-target="#collapse-deliveries"
                                            aria-controls="collapse-deliveries">
                                            <span class="material-symbols-outlined mr-2">
                                                sports_motorsports
                                            </span>
                                            Delivery
                                        </a>
                                    </div>
                                    <div id="collapse-deliveries" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionSidebar">
                                        <div class="m-0 py-1">
                                            <ul class="fw-medium border-start border-secondary mx-2 ps-2"
                                                style="border-left-width: 4px !important;">
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('store.entrega_taxas') }}">
                                                        Taxas de entrega
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('store.entrega_areas') }}">
                                                        Áreas de entrega
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary" href="">
                                                        Aplicativo personalizado
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('store.show', ['store' => session('selected_store')['id'], 'tab' => 'planos']) }}">
                                                        Notificações e marketing
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIM ACCORDION ITEM -->

                                <!-- ACCORDION ITEM -->
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <a class="accordion-button fw-medium collapsed text-decoration-none" href=""
                                            data-bs-toggle="collapse" data-bs-target="#collapse-menus"
                                            aria-controls="collapse-menus">
                                            <span class="material-symbols-outlined mr-2">
                                                restaurant_menu
                                            </span>
                                            Cardápio
                                        </a>
                                    </div>
                                    <div id="collapse-menus" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionSidebar">
                                        <div class="m-0 py-1">
                                            <ul class="fw-medium border-start border-secondary mx-2 ps-2"
                                                style="border-left-width: 4px !important;">
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('categoria_produto') }}">
                                                        Categorias e produtos
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary" href="">
                                                        Visual do cardápio
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIM ACCORDION ITEM -->

                                <!-- ACCORDION ITEM -->
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <a class="accordion-button fw-medium collapsed text-decoration-none" href=""
                                            data-bs-toggle="collapse" data-bs-target="#collapse-payments"
                                            aria-controls="collapse-payments">
                                            <span class="material-symbols-outlined mr-2">
                                                payments
                                            </span>
                                            Financeiro
                                        </a>
                                    </div>
                                    <div id="collapse-payments" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionSidebar">
                                        <div class="m-0 py-1">
                                            <ul class="fw-medium border-start border-secondary mx-2 ps-2"
                                                style="border-left-width: 4px !important;">
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('contas_receber.index') }}">
                                                        Contas a receber
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('contas_pagar.index') }}">
                                                        Contas a pagar
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('movimentacao.showFormConsulta') }}">
                                                        Movimentações
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('categoria_financeiro.listar') }}">
                                                        Categorias
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('forma_pagamento') }}">
                                                        Formas de pagamento
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('conta_corrente.listar') }}">
                                                        Conta corrente
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIM ACCORDION ITEM -->

                                <!-- ACCORDION ITEM -->
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <a class="accordion-button fw-medium collapsed text-decoration-none" href=""
                                            data-bs-toggle="collapse" data-bs-target="#collapse-stock"
                                            aria-controls="collapse-stock">
                                            <span class="material-symbols-outlined mr-2">
                                                package_2
                                            </span>
                                            Estoque
                                        </a>
                                    </div>
                                    <div id="collapse-stock" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionSidebar">
                                        <div class="m-0 py-1">
                                            <ul class="fw-medium border-start border-secondary mx-2 ps-2"
                                                style="border-left-width: 4px !important;">
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('contas_receber.index') }}">
                                                        Contas a receber
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('contas_pagar.index') }}">
                                                        Contas a pagar
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('movimentacao.showFormConsulta') }}">
                                                        Movimentações
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('categoria_financeiro.listar') }}">
                                                        Categorias
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('forma_pagamento') }}">
                                                        Formas de pagamento
                                                    </a>
                                                </li>
                                                <li class="my-2">
                                                    <a class="text-decoration-none text-secondary"
                                                        href="{{ route('conta_corrente.listar') }}">
                                                        Conta corrente
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIM ACCORDION ITEM -->

                            </div>
                            <!-- FIM ACCORDION -->

                        </div>
                    </div>
                    <!-- FIM SIDEBAR -->

                </div>
                @endif
                <!-- FIM COLUNA SIDEBAR -->

                <!-- COLUNA CONTEÚDO -->
                <div class="container-fluid m-0 p-0">
                    @livewire('navigation-menu')

                    {{ $slot }}
                </div>
                <!-- FIM COLUNA CONTEÚDO -->

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