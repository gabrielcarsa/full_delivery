<x-app-layout>

    <!-- MENSAGENS -->
    @if(session('success'))
    <x-toasts-message type="success" message="{{ session('success') }}" />
    @endif

    @if(session('error'))
    <x-toasts-message type="danger" message="{{ session('error') }}" />
    @endif

    @if($errors->any())
    @foreach ($errors->all() as $error)
    <x-toasts-message type="danger" message="{{ $error }}" />
    @endforeach
    @endif
    <!-- FIM MENSAGENS -->


    <!-- CONTAINER PADRAO -->
    <div class="container-padrao">

        <!-- HEADER -->
        <div class="d-flex align-items-center justify-content-between p-2 m-0">
            <h2 class="m-0 fw-bolder fs-2 text-black">
                Gestor de Pedidos
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

        <!-- FILTROS -->
        <div class="overflow-x-scroll w100 m-0">
            <div class="d-flex py-3">
                @php
                $filtro = request()->input('filtro'); // Obtendo o valor do filtro da URL
                @endphp
                @if(isset($filtro) && is_numeric($filtro))
                <a href="{{ route('pedido.gestor') }}"
                    class="mx-1 p-0 rounded text-decoration-none fw-semibold text-white d-flex align-items-center justify-content-center"
                    style="min-width: 180px; background-color: #FD0146 !important">
                    @if($filtro == 0)
                    Pendentes
                    @elseif($filtro == 1)
                    Em preparo
                    @elseif($filtro == 2)
                    Pronto p/ retirar
                    @elseif($filtro == 3)
                    A caminho
                    @elseif($filtro == 4)
                    Concluídos
                    @elseif($filtro == 5)
                    Cancelados
                    @endif
                    <span class="badge text-bg-light mx-1">
                        {{isset($data['pedidos']) ? $data['pedidos']->count() : '0'}}
                    </span>
                    <span class="material-symbols-outlined ml-1 text-light">
                        close
                    </span>
                </a>
                @endif

                @if($filtro == null || $filtro != 0)
                <a href="{{ route('pedido.gestor', ['filtro' => 0]) }}"
                    class="p-2 mr-1 border rounded bg-white text-decoration-none text-secondary text-center shadow-sm"
                    style="min-width: 110px;">
                    Pendentes
                </a>
                @endif

                @if($filtro != 1)
                <a href="{{ route('pedido.gestor', ['filtro' => 1]) }}"
                    class="p-2 mx-1 border rounded bg-white text-decoration-none text-secondary text-center shadow-sm"
                    style="min-width: 110px;">
                    Em preparo
                </a>
                @endif

                @if($filtro != 2)
                <a href="{{ route('pedido.gestor', ['filtro' => 2]) }}"
                    class="p-2 mx-1 border rounded bg-white text-decoration-none text-secondary text-center shadow-sm"
                    style="min-width: 110px;">
                    Pronto p/ retirar
                </a>
                @endif

                @if($filtro != 3)
                <a href="{{ route('pedido.gestor', ['filtro' => 3]) }}"
                    class="p-2 mx-1 border rounded bg-white text-decoration-none text-secondary text-center shadow-sm"
                    style="min-width: 110px;">
                    A caminho
                </a>
                @endif

                @if($filtro != 4)
                <a href="{{ route('pedido.gestor', ['filtro' => 4]) }}"
                    class="p-2 mx-1 border rounded bg-white text-decoration-none text-secondary text-center shadow-sm"
                    style="min-width: 110px;">
                    Concluídos
                </a>
                @endif

                @if($filtro != 5)
                <a href="{{ route('pedido.gestor', ['filtro' => 5]) }}"
                    class="p-2 mx-1 border rounded bg-white text-decoration-none text-secondary text-center shadow-sm"
                    style="min-width: 110px;">
                    Cancelados
                </a>
                @endif

            </div>
        </div>
        <!-- FIM FILTROS -->

        <!-- ACCORDION PEDIDOS NOVOS -->
        <div class="accordion" id="accordionExample">

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button fs-4 text-dark" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePedidosNovos" aria-expanded="true"
                        aria-controls="collapsePedidosNovos">
                        Novos pedidos ()
                    </button>
                </h2>
                <div id="collapsePedidosNovos" class="accordion-collapse collapse show"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                        <!-- PEDIDOS GRID -->
                        <div class="row g-1" class="pedidos-grid">

                            <!-- PEDIDOS -->
                            @if(isset($data['pedidos']))

                            @foreach($data['pedidos'] as $pedido)

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
                                            <x-show-pedido :pedido="$data['pedido']" />
                                            @endif
                                            <!-- FIM PEDIDO DETALHE -->
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ route('pedido.gestor') }}"
                                                class="btn border-padrao text-padrao">
                                                Fechar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FIM MODAL DETALHES PEDIDO -->

                            <!-- Verificar se o modal deve ser aberto -->
                            @if(isset($data['pedido']) && $data['pedido']->id == $pedido->id)
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
        <div class="accordion mt-3" id="accordionExample">

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button fs-4 text-dark" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePedidosTodos" aria-expanded="true"
                        aria-controls="collapsePedidosTodos">
                        Todos pedidos ()
                    </button>
                </h2>
                <div id="collapsePedidosTodos" class="accordion-collapse collapse show"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                        <!-- PEDIDOS GRID -->
                        <div class="row g-1" id="pedidos-grid">

                            <!-- PEDIDOS -->
                            @if(isset($data['pedidos']))

                            @foreach($data['pedidos'] as $pedido)

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
                                            <x-show-pedido :pedido="$data['pedido']" />
                                            @endif
                                            <!-- FIM PEDIDO DETALHE -->
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ route('pedido.gestor') }}"
                                                class="btn border-padrao text-padrao">
                                                Fechar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FIM MODAL DETALHES PEDIDO -->

                            <!-- Verificar se o modal deve ser aberto -->
                            @if(isset($data['pedido']) && $data['pedido']->id == $pedido->id)
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
                    @foreach($data['polling_eventos'] as $evento)
                    <li class="m-0 p-0" style="font-size: 13px">
                        <p class="m-0">
                            {{$evento->full_code}} - {{$evento->order_id}} -
                            {{\Carbon\Carbon::parse($evento->created_at)->format('d/m/Y H:i')}}
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
    $(document).ready(function() {
        function atualizarPedidos() {
            $.ajax({
                url: "{{ route('pedido.atualizar', ['id_selecionado' => isset($data['pedido']) ? $data['pedido']->id : null, 'filtro' => request()->get('filtro') ] ) }}",
                type: 'GET',
                success: function(data) {
                    $('#pedidos-grid').html(data); // Insere o HTML retornado
                }
            });
        }

        // Atualiza os pedidos a cada 30 segundos
        setInterval(atualizarPedidos, 30000);

        // Primeira chamada ao carregar a página
        atualizarPedidos();
    });

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