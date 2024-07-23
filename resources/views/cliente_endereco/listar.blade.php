<x-layout-cardapio>

    <!-- NAVBAR ENDEREÇO -->
    <div class="d-flex p-0 fixed-top p-1 bg-light border shadow-sm">
        <a href="#" onclick="history.go(-1); return false;"
            class="btn btn-light rounded-circle d-flex align-items-center">
            <span class="material-symbols-outlined">
                arrow_back
            </span>
        </a>
        <div class="d-flex align-items-center justify-content-center" style="flex: 1;">
            <h2 class="fs-5 fw-bold">Endereços</h2>
        </div>
    </div>
    <!-- FIM NAVBAR ENDEREÇO -->

    @if($enderecos->isEmpty())

    <!-- CARRINHO VAZIO -->
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="m-5">
            <span class="material-symbols-outlined" style="font-size: 60px;">
                location_off
            </span>
            <h3>Ops!</h3>
            <p>Parece que você não tem nenum endereço cadastrado!</p>
            <a href="{{ route('cliente_endereco.novo', ['cliente_id' => Auth::guard('cliente')->user()->id]) }}"
                class="btn btn-primary">
                Cadastrar endereço de entrega
            </a>
        </div>
    </div>
    <!-- FIM CARRINHO VAZIO -->

    @else

    <!-- CONTAINER ENDEREÇOS -->
    <div class="container vh-100" style="margin-top: 80px;">

        <a href="{{ route('cliente_endereco.novo', ['cliente_id' => Auth::guard('cliente')->user()->id]) }}"
            class="btn btn-primary">
            Cadastrar endereço de entrega
        </a>

        <!-- LISTA DE ENDEREÇOS -->
        <ul class="list-group my-3">

            <!-- ENDEREÇOS FOREACH -->
            @foreach($enderecos as $endereco)

            <!-- ENDEREÇO -->
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <h4 class="fs-5 fw-semibold m-0">{{$endereco->nome}}</h4>
                    <p class="m-0 text-secondary">{{$endereco->rua}}, {{$endereco->numero}} - {{$endereco->bairro}}</p>
                    <p class="m-0 text-secondary">{{$endereco->cidade}}, {{$endereco->estado}}</p>
                    <p class="m-0 text-secondary">{{$endereco->complemento}}</p>
                </div>
                <form action="{{ route('cliente_endereco.excluir', ['id' => $endereco->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger p-2 m-0">
                        <span class="material-symbols-outlined d-flex justify-content-center align-items-center">
                            delete
                        </span>
                    </button>
                </form>
       
            </li>
            <!-- FIM ENDEREÇO -->

            @endforeach
            <!-- FIM ENDEREÇOS FOREACH -->

        </ul>
        <!-- FIM LISTA DE ENDEREÇOS -->

    </div>
    <!-- FIM CONTAINER ENDEREÇOS -->

    @endif
</x-layout-cardapio>