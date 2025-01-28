<nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container-fluid">

        @if(session('selected_store'))
        <button class="text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSidebar"
            aria-expanded="false" aria-controls="collapseSidebar">
            <span class="material-symbols-outlined">
                menu_open
            </span>
        </button>
        @else
        <a href="{{ route('dashboard') }}">
            <img src="{{asset("storage/images/logo-black.png")}}" width="100px" alt="Foomy" class="mx-auto my-2">
        </a>
        @endif

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
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