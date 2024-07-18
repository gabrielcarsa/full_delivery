<x-layout-cardapio>
    @if($enderecos->isEmpty())
    <!-- CARRINHO VAZIO -->
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="m-5">
            <span class="material-symbols-outlined" style="font-size: 60px;">
                location_off
            </span>
            <h3>Ops!</h3>
            <p>Parece que você não tem nenum endereço cadastrado!</p>
            <a href="{{ route('cliente_endereco.novo', ['cliente_id' => Auth::guard('cliente')->user()->id]) }}" class="btn btn-primary">Cadastrar endereço de entrega</a>
        </div>
    </div>
    <!-- FIM CARRINHO VAZIO -->
    @else
    <div class="container">
        s
    </div>
    @endif
</x-layout-cardapio>