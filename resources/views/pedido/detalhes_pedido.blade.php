<x-layout-cardapio>

    <!-- NAVBAR PRODUTO -->
    <div class="d-flex bg-white fixed-top p-2">
        <a href="#" onclick="history.go(-1); return false;"
            class="text-dark text-decoration-none d-flex align-items-center m-0">
            <span class="material-symbols-outlined">
                arrow_back
            </span>
        </a>
        <div class="d-flex align-items-center justify-content-center" style="flex: 1;">
            <h2 class="fs-6 fw-bold">Detalhes do pedido</h2>
        </div>
    </div>
    <!-- FIM NAVBAR PRODUTO -->

    <!-- CONTAINER -->
    <div class="container my-5">

        <!-- PREVISÃO -->
        <div class="py-3">
            <p class="text-secondary m-0">
                Previsão de entrega
            </p>
            <p class="text-black m-0 fs-5">
                12:30 - 13:20
            </p>
        </div>
        <!-- FIM PREVISÃO -->

        <!-- ETAPAS STATUS -->
        <div class="d-flex align-items-center bg-light rounded my-3 justify-content-between" style="height: 20px">

            <div class="bg-light rounded-circle"
                style="height: 70px; width: 70px; {{ $data['pedido']->status >= 0 ? 'background-color: #FD0146 !important' : '' }}">
                <div class="m-0 d-flex align-items-center justify-content-center" style="height: 70px; width: 70px">
                    <span class="material-symbols-outlined text-white">
                        hourglass_top
                    </span>
                </div>
                <p class="text-truncate d-flex align-items-center justify-content-center"
                    style="font-size: 13px; max-width: 100px">
                    Pendente
                </p>
            </div>

            <div class="bg-light rounded-circle" style="height: 70px; width: 70px">
                <div class="m-0 d-flex align-items-center justify-content-center" style="height: 70px; width: 70px">
                    <span class="material-symbols-outlined">
                        skillet
                    </span>
                </div>
                <p class="text-truncate d-flex align-items-center justify-content-center"
                    style="font-size: 13px; max-width: 100px">Preparando</p>
            </div>

            <div class="bg-light rounded-circle" style="height: 70px; width: 70px">
                <div class="m-0 d-flex align-items-center justify-content-center" style="height: 70px; width: 70px">
                    <span class="material-symbols-outlined">
                        sports_motorsports
                    </span>
                </div>
                <p class="text-truncate d-flex align-items-center justify-content-center"
                    style="font-size: 13px; max-width: 100px">A caminho</p>
            </div>
            <div class="bg-light rounded-circle" style="height: 70px; width: 70px">
                <div class="m-0 d-flex align-items-center justify-content-center" style="height: 70px; width: 70px">
                    <span class="material-symbols-outlined">
                        check_circle
                    </span>
                </div>
                <p class="text-truncate d-flex align-items-center justify-content-center"
                    style="font-size: 13px; max-width: 100px">Concluído</p>
            </div>
        </div>

        <div class="" style="margin: 70px 0">
            <p class="text-secondary m-0">
                Entregar em
            </p>
            <p class="text-black m-0">
                {{$data['pedido']->entrega->rua}}, {{$data['pedido']->entrega->numero}}.
            </p>
            <p class="text-black m-0">
                {{$data['pedido']->entrega->bairro}} - {{$data['pedido']->entrega->cidade}}
                {{$data['pedido']->entrega->estado}}
            </p>
            <p class="text-black m-0">
                {{$data['pedido']->entrega->complemento}}
            </p>
        </div>



    </div>
    <!-- FIM CONTAINER -->



</x-layout-cardapio>