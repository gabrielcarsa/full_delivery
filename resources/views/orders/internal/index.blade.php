<x-app-layout>

    <!-- CONTAINER PADRAO -->
    <div class="container-padrao">

        <!-- HEADER -->
        <div class="d-flex align-items-center justify-content-between p-2 m-0">
            <h2 class="m-0 fw-bolder fs-2 text-black">
                Painel de Pedidos
            </h2>

            <div class="d-flex">
                <a href="" class="btn border-padrao d-flex align-items-center text-padrao rounded-pill mx-1">
                    <span class="material-symbols-outlined mr-1">
                        print
                    </span>
                    Configurar
                </a>

                <a href="" class="btn btn-outline-secondary d-flex align-items-center rounded-pill mx-1">
                    <span class="material-symbols-outlined mr-1">
                        block
                    </span>
                    Cancelados
                </a>

                <a class="btn bg-padrao text-white fw-bold d-flex align-items-center rounded-pill mx-1" href="">
                    <span class="material-symbols-outlined fill-icon mr-1">
                        add_circle
                    </span>
                    Novo pedido
                </a>
            </div>

            <!-- FORM -->
            <form class="row g-1" action="" method="post">
                @csrf
                <div class="col-auto">
                    <x-input placeholder="ID pedido" id="pedido_id" type="text" name="pedido_id"
                        :value="old('pedido_id')" autofocus autocomplete="off" />
                </div>

                <div class="col-auto">
                    <x-button class="">
                        Pesquisar
                    </x-button>
                </div>
            </form>
            <!-- FIM FORM -->
        </div>
        <!-- FIM HEADER -->

        <!-- ACCORDION PEDIDOS NOVOS -->
        <div class="accordion" id="accordionPedidoNovos">

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button fs-4 fw-bold text-black" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePedidosNovos" aria-expanded="true"
                        aria-controls="collapsePedidosNovos">
                        Novos pedidos <span class="text-secondary ml-1">({{$data['pending_orders']}})</span>
                    </button>
                </h2>
                <div id="collapsePedidosNovos" class="accordion-collapse collapse show"
                    data-bs-parent="#accordionPedidoNovos">
                    <div class="accordion-body">

                        <!-- PEDIDOS GRID -->
                        <div class="row g-1" id="novos-pedidos-grid">

                            <!-- PEDIDOS -->
                            @if(isset($data['orders']))

                            @foreach($data['orders'] as $order)

                            <!-- MODAL DETALHES PEDIDO -->
                            <div class="modal fade modal-lg" id="modalDetalhes" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDetalhesLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex justify-content-between">
                                            @if(isset($data['order']))
                                            <p class="fw-bold fs-5 m-0" id="modalDetalhesLabel">
                                                #0{{$data['order']->id}}0
                                            </p>
                                            <p class="m-0 text-secondary">
                                                Recebido
                                                {{ \Carbon\Carbon::parse($data['order']->created_at)->diffForHumans() }}
                                            </p>
                                            @endif
                                        </div>
                                        <div class="modal-body">
                                            <!-- PEDIDO DETALHE -->
                                            @if(isset($data['order']))
                                            <x-show-order :order="$data['order']" />
                                            @endif
                                            <!-- FIM PEDIDO DETALHE -->
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ route('orders.index') }}" class="btn border-padrao text-padrao">
                                                Fechar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FIM MODAL DETALHES PEDIDO -->

                            <!-- Verificar se o modal deve ser aberto -->
                            @if(isset($data['order']) && $data['order']->id == $order->id)
                            <script>
                            // Espera o DOM ser completamente carregado
                            document.addEventListener('DOMContentLoaded', function() {
                                var myModal = new bootstrap.Modal(document.getElementById('modalDetalhes'));
                                myModal.show();
                            });
                            </script>
                            @endif

                            @endforeach

                            @endif
                            <!-- FIM PEDIDOS -->

                        </div>
                        <!-- FIM PEDIDOS GRID -->
                    </div>
                </div>
            </div>

        </div>
        <!-- FIM ACCORDION PEDIDOS NOVOS -->

        <!-- ACCORDION PEDIDOS TODOS -->
        <div class="accordion mt-3" id="accordionPedidos">

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button fs-4 fw-bold text-black" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePedidosTodos" aria-expanded="true"
                        aria-controls="collapsePedidosTodos">
                        Todos pedidos <span class="text-secondary ml-1">({{$data['orders_total']}})</span>
                    </button>

                </h2>
                <div id="collapsePedidosTodos" class="accordion-collapse collapse show"
                    data-bs-parent="#accordionPedidos">
                    <div class="accordion-body">
                        <!-- FILTROS -->
                        <div class="overflow-x-scroll w100 m-0">
                            <div class="d-flex py-3">
                                @php
                                $filters = request()->input('filters'); // Obtendo o valor do filters da URL
                                @endphp
                                @if(isset($filters) && is_numeric($filters))
                                <a href="{{ route('orders.index') }}"
                                    class="mx-1 px-2 rounded-pill text-decoration-none fw-semibold text-white d-flex align-items-center justify-content-center"
                                    style="min-width: 180px; background-color: #FD0146 !important">
                                    @if($filters == 1)
                                    Em preparo
                                    @elseif($filters == 2)
                                    Pronto p/ retirar
                                    @elseif($filters == 3)
                                    A caminho
                                    @elseif($filters == 4)
                                    Concluídos
                                    @elseif($filters == 5)
                                    Cancelados
                                    @endif
                                    <span class="material-symbols-outlined ml-1 text-light">
                                        close
                                    </span>
                                </a>
                                @endif

                                @if($filters != 1)
                                <a href="{{ route('orders.index', ['filters' => 1]) }}"
                                    class="p-2 mx-1 border rounded-pill bg-white text-decoration-none text-secondary text-center"
                                    style="min-width: 110px;">
                                    Em preparo
                                </a>
                                @endif

                                @if($filters != 2)
                                <a href="{{ route('orders.index', ['filters' => 2]) }}"
                                    class="p-2 mx-1 border rounded-pill bg-white text-decoration-none text-secondary text-center"
                                    style="min-width: 110px;">
                                    Pronto p/ retirar
                                </a>
                                @endif

                                @if($filters != 3)
                                <a href="{{ route('orders.index', ['filters' => 3]) }}"
                                    class="p-2 mx-1 border rounded-pill bg-white text-decoration-none text-secondary text-center"
                                    style="min-width: 110px;">
                                    A caminho
                                </a>
                                @endif

                                @if($filters != 4)
                                <a href="{{ route('orders.index', ['filters' => 4]) }}"
                                    class="p-2 mx-1 border rounded-pill bg-white text-decoration-none text-secondary text-center"
                                    style="min-width: 110px;">
                                    Concluídos
                                </a>
                                @endif

                            </div>
                        </div>
                        <!-- FIM FILTROS -->

                        <!-- PEDIDOS GRID -->
                        <div class="row g-3" id="pedidos-grid">

                            <!-- PEDIDOS -->
                            @if(isset($data['orders']))

                            @foreach($data['orders'] as $order)

                            <!-- MODAL DETALHES PEDIDO -->
                            <div class="modal fade modal-lg" id="modalDetalhes" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDetalhesLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex justify-content-between">
                                            @if(isset($data['pedido']))
                                            <p class="fw-bold fs-5 m-0" id="modalDetalhesLabel">
                                                #0{{$data['pedido']->id}}0
                                            </p>
                                            <p class="m-0 text-secondary">
                                                Recebido
                                                {{ \Carbon\Carbon::parse($data['pedido']->feito_em)->diffForHumans() }}
                                            </p>
                                            @endif
                                        </div>
                                        <div class="modal-body">
                                            <!-- PEDIDO DETALHE -->
                                            @if(isset($data['pedido']))
                                            <x-show-order :order="$data['order']" />
                                            @endif
                                            <!-- FIM PEDIDO DETALHE -->
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ route('orders.index') }}" class="btn border-padrao text-padrao">
                                                Fechar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FIM MODAL DETALHES PEDIDO -->

                            <!-- Verificar se o modal deve ser aberto -->
                            @if(isset($data['pedido']) && $data['pedido']->id == $order->id)
                            <script>
                            // Espera o DOM ser completamente carregado
                            document.addEventListener('DOMContentLoaded', function() {
                                var myModal = new bootstrap.Modal(document.getElementById('modalDetalhes'));
                                myModal.show();
                            });
                            </script>
                            @endif

                            @endforeach

                            @endif
                            <!-- FIM PEDIDOS -->

                        </div>
                        <!-- FIM PEDIDOS GRID -->
                    </div>
                </div>
            </div>

        </div>
        <!-- FIM ACCORDION PEDIDOS TODOS -->

    </div>
    <!-- CONTAINER PADRAO -->

    <!-- BOTÃO DE AJUDA -->
    <div class="dropup fixed-bottom d-flex justify-content-end m-3">
        <a class="rounded-circle bg-padrao p-3 text-decoration-none" data-bs-toggle="dropdown">
            <span class="material-symbols-outlined text-white d-flex align-items-center fs-2 fw-bold">
                help
            </span>
        </a>
        <div class="dropdown-menu p-3">
            <p class="fw-bold m-0">
                Ajuda
            </p>
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action">
                    Como funciona cancelamento de um pedido?
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    Como alterar informações de pedidos?
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    Central de ajuda
                </a>
            </div>
            <p class="fw-bold mt-3 mb-0">
                Integração iFood: Registros
            </p>
            <div class="bg-gray-100">
                <ul class="m-0 p-3">
                    @foreach($data['store_polling_events'] as $event)
                    <li class="m-0 p-0" style="font-size: 13px">
                        <p class="m-0">
                            {{$event->full_code}} - {{$event->order_id}} -
                            {{\Carbon\Carbon::parse($event->created_at)->format('d/m/Y H:i')}}
                        </p>
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
    <!-- FIM BOTÃO DE AJUDA -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
    // ATUALIZAR PEDIDOS A CADA 30s
    $(document).ready(function() {
        // ATUALIZANDO TODOS OS PEDIDOS
        function atualizarPedidos() {
            $.ajax({
                url: "{{ route('pedido.atualizar', ['id_selecionado' => isset($data['pedido']) && $data['pedido']->status != 0 ? $data['pedido']->id : null, 'filters' => request()->get('filters') ] ) }}",
                type: 'GET',
                success: function(data) {
                    $('#pedidos-grid').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Erro ao atualizar pedidos: ", error);
                }
            });
        }
        // ATUALIZANDO TODOS OS PEDIDOS NOVOS
        function atualizarPedidosNovos() {
            $.ajax({
                url: "{{ route('pedido.atualizar', ['id_selecionado' => isset($data['pedido']) && $data['pedido']->status == 0 ? $data['pedido']->id : null, 'novos_pedidos'=> 'true' ] ) }}",
                type: 'GET',
                success: function(data) {
                    $('#novos-pedidos-grid').html(data); // Insere o HTML retornado
                },
                error: function(xhr, status, error) {
                    console.error("Erro ao atualizar pedidos: ", error);
                }
            });
        }

        // Atualiza os pedidos a cada 30 segundos
        setInterval(atualizarPedidos, 30000);
        setInterval(atualizarPedidosNovos, 30000);

        // Primeira chamada ao carregar a página
        atualizarPedidos();
        atualizarPedidosNovos();

    });

    //POLLING API IFOOD A CADA 30s
    $(document).ready(function() {

        function pollingAPI() {
            $.ajax({
                url: "{{ route('pedido.polling') }}",
                type: 'GET',
            });
        }

        // Atualiza os pedidos a cada 30 segundos
        setInterval(pollingAPI, 30000);

        // Primeira chamada ao carregar a página
        pollingAPI();

    });
    </script>

</x-app-layout>