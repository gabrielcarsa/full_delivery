<x-app-layout>

    <div class="container py-3">

        <!-- GRID GESTOR-->
        <div class="row">

            <!-- COLUNA MESAS -->
            <div class="col-md-4" style="overflow-y: auto; height: 85vh !important">

                <!-- FILTROS -->
                <div class="d-flex my-3">

                    <a href=""
                        class="d-flex align-items-center fs-6 py-2 px-4 rounded border text-decoration-none mx-1">
                        <span class="material-symbols-outlined text-success mr-1"
                            style="font-variation-settings:'FILL' 1;">
                            circle
                        </span>
                        <span class="fw-semibold text-black">
                            Disponível
                        </span>
                    </a>

                    <a href=""
                        class="d-flex align-items-center fs-6 py-2 px-4 rounded border text-decoration-none mx-1">
                        <span class="material-symbols-outlined text-warning mr-1"
                            style="font-variation-settings:'FILL' 1;">
                            circle
                        </span>
                        <span class="fw-semibold text-black">
                            Ocupado
                        </span>
                    </a>


                </div>
                <!-- FIM FILTROS -->

                <!-- GRID MESAS -->
                <div class="row g-3">
                    @if($data['mesas'] != null)

                    <!-- MESA -->
                    @foreach($data['mesas'] as $mesa)

                    <!-- CARD MESA -->
                    <a href="{{ route('mesa.show', ['id' => $mesa->id]) }}"
                        class="col-5 bg-white p-3 border mx-1 rounded text-decoration-none text-black">

                        <!-- HEADER CARD MESA -->
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="fw-bold fs-4 m-0">
                                Mesa {{$mesa->nome}}
                            </p>
                            <span
                                class="material-symbols-outlined fs-3 d-flex justify-items-between {{$mesa->is_ocupada == false ? 'text-success' : 'text-warning'}}"
                                style="font-variation-settings:'FILL' 1;">
                                circle
                            </span>
                        </div>
                        <!-- FIM HEADER CARD MESA -->

                        <!-- CORPO CARD MESA -->
                        <div class="d-flex align-items-center justify-content-between mt-3">
                            <div>
                                <p class="text-secondary fs-6 m-0">
                                    Abertura
                                </p>
                                <p class="fw-semibold fs-6 m-0">
                                    @if($mesa->hora_abertura != null)
                                    {{\Carbon\Carbon::parse($mesa->hora_abertura)->format('H:i')}}
                                    @else
                                    00h00m
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-secondary fs-6 m-0">
                                    Total
                                </p>
                                <p class="fw-semibold fs-6 m-0">
                                    @php
                                    $total_mesa = 0;
                                    @endphp

                                    @foreach($mesa->pedido as $pedido)

                                    @php
                                    if($pedido->situacao != 2){
                                    $total_mesa += $pedido->total;
                                    }
                                    @endphp

                                    @endforeach

                                    R$ {{number_format($total_mesa, 2, ',', '.')}}
                                </p>
                            </div>
                        </div>
                        <!-- FIM CORPO CARD MESA -->

                    </a>
                    <!-- FIM CARD MESA -->

                    @endforeach
                    <!-- FIM MESA -->

                    @endif
                </div>
                <!-- FIM GRID MESAS -->

            </div>
            <!-- FIM COLUNA MESAS -->

            <div class="col-md-8 m-0 p-0" style="overflow-y: auto; height: 85vh !important">
                <div class="bg-white border rounded p-3">

                    <!-- MESA DETALHE -->
                    @if(isset($data['mesa']))

                    <div>
                        <x-show-mesa :data="$data" />
                    </div>
                    <!-- FIM MESA DETALHE -->

                    @else

                    <div class="p-5">
                        <h4 class="m-0 fw-bold">
                            Nenhuma mesa selecionada
                        </h4>
                        <p class="text-secondary">
                            Clique sobre uma mesa para visualizar detalhes.
                        </p>
                        <p class="fw-bold m-0 pt-3">
                            Sobre o painel de mesas:
                        </p>
                        <p class="m-0">
                            - Veja todos pedidos da mesa.
                        </p>
                        <p class="m-0">
                            - Realize o pagamento dos pedidos da mesa.
                        </p>
                        <p class="m-0">
                            - O pagamento pode ser feito por item ou parcialmente sobre o valor total.
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- FIM GRID GESTOR PEDIDOS-->

    </div>

</x-app-layout>