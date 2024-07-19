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
                class="btn btn-primary">Cadastrar endereço de entrega</a>
        </div>
    </div>
    <!-- FIM CARRINHO VAZIO -->

    @else

    <div class="container">
        s
    </div>
    @endif
</x-layout-cardapio>