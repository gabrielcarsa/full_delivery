<x-layout-cardapio>

    @if(empty($pedidos))

    <!-- NÃO HOUVER PEDIDOS -->
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="m-5">
            <h3>Ops!</h3>
            <p>Parece que você ainda não fez nenhum pedido!</p>
            <a href="#" onclick="history.go(-1); return false;" class="btn btn-primary">Fazer pedido</a>
        </div>
    </div>

    <!-- FIM NÃO HOUVER PEDIDOS -->

    @else
    <p>pedido</p>
    @endif

    <!-- MENU APPBAR -->
    <x-appbar-cardapio :data="$data" />
    <!-- FIM MENU APPBAR -->

</x-layout-cardapio>