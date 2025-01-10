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
                        $lojas = \App\Helpers\LojaHelper::getUserLoja();

                        //Mudar status da Loja Selecionada
                        \App\Helpers\LojaHelper::MudarStatusLoja();
                        @endphp
                        <!-- FIM LOJAS -->

                        <a class="btn bg-light rounded d-flex align-items-center dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">

                            @foreach($lojas as $loja)
                            @if(session('lojaConectado') && $loja->id == session('lojaConectado')['id'])
                            <!-- LOJA CIRCULO STATUS -->
                            @if($loja->state == "OK" || $loja->state == "WARNING")
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
                            {{session('lojaConectado')['nome']}}
                            @else
                            Selecione uma loja
                            @endif
                            @endforeach
                        </a>

                        <!-- DROPDOWN LOJAS -->
                        <ul class="dropdown-menu p-3 bg-light" style="width: 400px">
                            <div class="mb-3">
                                <button onClick="window.location.reload()"
                                    class="text-primary text-decoration-underline">
                                    Atualizar
                                </button>
                            </div>

                            @foreach($lojas as $loja)
                            <li
                                class="d-flex align-items-center justify-content-between rounded {{session('lojaConectado') && session('lojaConectado')['id'] == $loja->id ? 'border-3 border-padrao' : 'bg-white'}} p-3">

                                <div class="d-flex align-items-center">
                                    <!-- LOJA CIRCULO STATUS -->
                                    @if($loja->state == "OK" || $loja->state == "WARNING")
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
                                            {{$loja->nome}}
                                        </p>
                                        @if(!session('lojaConectado') || session('lojaConectado')['id'] == $loja->id)
                                        <p class="m-0 text-secondary">
                                            @if($loja->state == "OK" || $loja->state == "WARNING")
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
                                @if(!session('lojaConectado') || session('lojaConectado')['id'] != $loja->id)
                                <form action="{{route('loja.choose', ['id' => $loja->id])}}" method="post">
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

                        <ul class="dropdown-menu">
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