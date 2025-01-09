<nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container-fluid">
        <!-- Logo -->
        <div class="shrink-0 flex items">
            <a href="{{ route('dashboard') }}"
                class="d-flex align-items-center text-decoration-none text-dark fs-2 fw-bolder">
                <img src="{{asset("storage/images/logo-black.png")}}" width="150px" alt="Foomy">
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item mx-1">
                    @dd(App\Models\Loja::all())
                    <div class="dropdown">
                        <a class="btn bg-light rounded dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Lojas
                        </a>
                        @if(session('lojaConectado') != null)
                        @if(LojaAbertaFechadaHelper::getLojaStatus() == true)
                        <div class="dropdown-menu">
                            <p class="m-0 d-flex align-items-center text-success">
                                <span class="material-symbols-outlined mr-1" style="font-variation-settings: 'FILL' 1;">
                                    circle
                                </span>
                                Loja Aberta
                            </p>
                            <span class="fs-6 mx-2">
                                -
                            </span>
                            <button onClick="window.location.reload()" class="text-primary text-decoration-underline">
                                Recarregar
                            </button>
                        </div>
                        @elseif(LojaAbertaFechadaHelper::getLojaStatus() == false)
                        <div class="d-flex bg-light p-2 rounded">
                            <p class="m-0 d-flex align-items-center text-danger">
                                <span class="material-symbols-outlined mr-1 "
                                    style="font-variation-settings: 'FILL' 1;">
                                    circle
                                </span>
                                Loja Fechada
                            </p>
                            <span class="fs-6 mx-2">
                                -
                            </span>
                            <button onClick="window.location.reload()" class="text-primary text-decoration-underline">
                                Recarregar
                            </button>
                        </div>
                        @endif
                        @endif
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