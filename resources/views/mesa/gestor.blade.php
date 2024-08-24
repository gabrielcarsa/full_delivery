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

        <div class="container">

            <!-- FILTROS -->
            <div class="d-flex my-3">

                <a href="" class="d-flex align-items-center fs-6 py-2 px-4 rounded border text-decoration-none mx-1">
                    <span class="material-symbols-outlined text-success mr-1" style="font-variation-settings:'FILL' 1;">
                        circle
                    </span>
                    <span class="fw-semibold text-black">
                        Disponível
                    </span>
                </a>

                <a href="" class="d-flex align-items-center fs-6 py-2 px-4 rounded border text-decoration-none mx-1">
                    <span class="material-symbols-outlined text-warning mr-1" style="font-variation-settings:'FILL' 1;">
                        circle
                    </span>
                    <span class="fw-semibold text-black">
                        Ocupado
                    </span>
                </a>


            </div>
            <!-- FIM FILTROS -->

            <!-- GRID GESTOR PEDIDOS-->
            <div class="row">

                <!-- COLUNA MESAS -->
                <div class="col-md-4">

                    <!-- GRID MESAS -->
                    <div class="row g-3">
                        @if($data['mesas'] != null)

                        <!-- MESA -->
                        @foreach($data['mesas'] as $mesa)

                        <!-- CARD MESA -->
                        <div class="col-5 bg-white p-3 border mx-1 rounded">

                            <!-- HEADER CARD MESA -->
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="fw-bold fs-4 m-0">
                                    Mesa {{$mesa->nome}}
                                </p>
                                <span class="material-symbols-outlined fs-3 text-success d-flex justify-items-between"
                                    style="font-variation-settings:'FILL' 1;">
                                    circle
                                </span>
                            </div>
                            <!-- FIM HEADER CARD MESA -->

                            <!-- CORPO CARD MESA -->
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <div>
                                    <p class="text-secondary fs-6 m-0">
                                        Tempo
                                    </p>
                                    <p class="fw-semibold fs-6 m-0">
                                        @if($mesa->hora_abertura != null)
                                        {{$mesa->hora_abertura}}
                                        @else
                                        00h00m
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-secondary fs-6 m-0">
                                        Total
                                    </p>
                                    <p class="fw-semibold fs-6 m-0">
                                        R$ 0,00
                                    </p>
                                </div>
                            </div>
                            <!-- FIM CORPO CARD MESA -->

                        </div>
                        <!-- FIM CARD MESA -->

                        @endforeach
                        <!-- FIM MESA -->

                        @endif
                    </div>
                    <!-- FIM GRID MESAS -->

                </div>
                <!-- FIM COLUNA MESAS -->

                <div class="col-md-8">
                    <div class="bg-white border rounded p-3 d-flex align-items-center justify-content-center">

                        <!-- MESA DETALHE -->
                        @if(isset($data['mesa']))
                        <x-show-mesa :mesa="$data['mesa']" />

                        <!-- FIM MESA DETALHE -->
                         
                        @else

                        <div>
                            <h4 class="m-0">
                                Nenhuma mesa selecionada
                            </h4>
                            <p>
                                Clique sobre uma mesa para visualizar detalhes
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- FIM GRID GESTOR PEDIDOS-->

        </div>

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