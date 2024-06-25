<x-app-layout>

    <!-- CONTAINER -->

    <div class="container">

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
        <div class="row">
            <div class="col">
                <h2 class="my-3 fw-bolder fs-1">
                    Painel de pedidos
                </h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn btn-warning m-0 py-1 px-5 fw-semibold d-flex align-items-center justify-content-center"
                    href="">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Simulador pedido
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        @if(isset($pedidos))

        @endif

    </div>

    <!-- FIM CONTAINER -->

    <!-- PEDIDOS -->
    <div class="row">

        <!-- MENU LATERAL PEDIDOS -->
        <div class="col-md-4">
            <div class="bg-white rounded border m-0" style="width: 350px">
                <div class="row p-0 m-0 mt-3">
                    <div class="col fs-2 fw-bolder text-primary">
                        <h3 class="d-flex align-items-center">
                            <span class="material-symbols-outlined mr-3">
                                warning
                            </span>
                            Pendentes
                        </h3>
                    </div>
                    <div class="col fw-semibold fs-4 text-secondary">
                        <p class="d-flex align-items-center justify-content-end">
                            3
                        </p>
                    </div>
                </div>

                <div class="bg-light rounded shadow-sm p-2 m-2">
                    <div class="row">
                        <div class="col">
                            <h4>NOME</h4>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <p>18:10</p>
                        </div>
                    </div>
                    <p class="text-secondary fs-6"># 01212</p>
                    <p>Campo Grande, MS</p>
                    <div class="row">
                        <div class="col">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIM MENU LATERAL PEDIDOS -->

        <!-- CONTEUDO PEDIDOS -->
        <div class="col-md-8">
            @yield('pedido')
        </div>
        <!-- FIM CONTEUDO PEDIDOS -->

    </div>

    <!-- FIM PEDIDOS -->

</x-app-layout>