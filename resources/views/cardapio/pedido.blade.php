<x-layout-cardapio>

    @if($pedidos->isEmpty())

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

    <!-- CONTAINER PEDIDOS -->
    <div class="container my-3">
        <h3 class="fs-3 fw-bold">
            Meus pedidos
        </h3>

        <!-- PEDIDOS -->
        @foreach($pedidos as $pedido)

        <div class="border rounded m-3 p-3">
            <div class="col d-flex justify-content-end">
                <p class="m-0 p-0 text-secondary" style="font-size:14px">
                    {{\Carbon\Carbon::parse($pedido->data_pedido)->format('d/m/Y')}} -
                    {{\Carbon\Carbon::parse($pedido->data_pedido)->format('H:i')}}
                </p>
            </div>
            <div class="col-8 d-flex">
                <div class="d-flex align-items-center justify-content-center">
                    <img src="{{ asset('storage/' . $pedido->loja->nome . '/' . $pedido->loja->logo) }}"
                        class="rounded-circle" style="max-width: 50px;">
                </div>
                <div class="ml-2">
                    <p class="m-0 fw-semibold">{{$pedido->loja->nome}}</p>
                    <p class="m-0 text-secondary texto-truncate-100w text-truncate">{{$pedido->loja->rua}}, {{$pedido->loja->numero}}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-8">
                    @if($pedido->status == 0)
                    <div class="d-flex">
                        <span class="material-symbols-outlined d-flex align-items-center text-warning mr-1"
                            style="font-variation-settings: 'FILL' 1;">
                            pending
                        </span>
                        <p class="m-0 p-0">Pedido pendente</p>
                    </div>
                    @elseif($pedido->status == 1)
                    <p class="m-0 p-0">Pedido em preparo</p>
                    @elseif($pedido->status == 2)
                    <p class="m-0 p-0">Pedido a caminho</p>
                    @elseif($pedido->status == 3)
                    <div class="d-flex">
                        <span class="material-symbols-outlined text-success d-flex align-items-center mr-1"
                            style="font-variation-settings: 'FILL' 1;">
                            check_circle
                        </span>
                        <p class="m-0 p-0">Pedido Concluído</p>
                    </div>
                    @elseif($pedido->status == 4)
                    <p class="m-0 p-0">REJEITADO</p>
                    @elseif($pedido->status == 5)
                    <p class="m-0 p-0">CANCELADO</p>
                    @endif
                </div>
                <div class="col-4 d-flex justify-content-end">
                    <p class="m-0 fw-bold text-secondary">
                        ID: {{$pedido->id}}
                    </p>
                </div>
            </div>
            <div class="d-flex">
                <span class="material-symbols-outlined text-secondary d-flex align-items-center mr-1"
                    style="font-variation-settings: 'FILL' 1;">
                    location_on
                </span>
                <p class="m-0 p-0 text-secondary texto-truncate-100w text-truncate">
                    {{$pedido->entrega->rua}}, {{$pedido->entrega->numero}}
                </p>
            </div>
        </div>

        @endforeach
        <!-- FIM PEDIDOS -->
    </div>
    <!-- FIM CONTAINER PEDIDOS -->


    @endif

    <!-- MENU APPBAR -->
    <x-appbar-cardapio :data="$data" />
    <!-- FIM MENU APPBAR -->

</x-layout-cardapio>