<nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container-fluid">

        <!-- LOGO -->
        <div class="shrink-0 flex items">
            <a href="{{ route('dashboard') }}"
                class="d-flex align-items-center text-decoration-none text-dark fs-2 fw-bolder">
                <img src="{{asset("storage/images/logo-black.png")}}" width="150px" alt="Foomy">
            </a>
        </div>
        <!-- FIM LOGO -->

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item mx-1">
                    <div class="dropdown">
                        <!-- LOJAS -->
                        @php
                        $stores = \App\Helpers\StoreHelper::getStoreUsers();

                        //Mudar status da Loja Selecionada
                        \App\Helpers\StoreHelper::MudarStatusLoja();
                        @endphp
                        <!-- FIM LOJAS -->

                        <a class="btn bg-light rounded d-flex align-items-center dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">

                            <!-- SE EXISTIR LOJAS PARA O USUARIO CONECTADO -->
                            @if(!empty($stores))

                            @foreach($stores as $store)
                            @if(session('storeConectado') && $store->id == session('storeConectado')['id'])
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
                            {{session('storeConectado')['nome']}}
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
                                class="d-flex align-items-center justify-content-between rounded {{session('storeConectado') && session('storeConectado')['id'] == $store->id ? 'border-3 border-padrao' : 'bg-white'}} p-3">

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
                                            {{$store->nome}}
                                        </p>
                                        @if(!session('storeConectado') || session('storeConectado')['id'] == $store->id)
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
                                @if(!session('storeConectado') || session('storeConectado')['id'] != $store->id)
                                <form action="{{route('store.choose', ['id' => $store->id])}}" method="post">
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
                </li>
                <li class="nav-item mx-1">
                    <div class="dropdown">
                        <a class="btn text-secondary border rounded dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    Perfil
                                </a>
                            </li>
                            <li>
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </li>
                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <li>
                                <a class="dropdown-item" href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>