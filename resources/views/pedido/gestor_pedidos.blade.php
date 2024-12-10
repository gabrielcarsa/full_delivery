<x-app-layout>

    <div class="container">
        <!-- MENSAGENS -->
        <div class="toast-container position-fixed top-0 end-0">
            @if(session('success'))
            <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true">
                <div class="d-flex align-items-center p-3">
                    <span class="material-symbols-outlined fs-1 text-success" style="font-variation-settings:'FILL' 1;">
                        check_circle
                    </span>
                    <div class="toast-body">
                        <p class="fs-5 m-0">
                            {{ session('success') }}
                        </p>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            @endif
            @if (session('error'))
            <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true">
                <div class="d-flex align-items-center p-3">
                    <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                        error
                    </span>
                    <div class="toast-body">
                        <p class="fs-5 m-0">
                            {{ session('error') }}
                        </p>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            @endif
            @if ($errors->any())
            <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true">
                <div class="d-flex align-items-center p-3">
                    <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                        error
                    </span>
                    <div class="toast-body">
                        @foreach ($errors->all() as $error)
                        <p class="fs-5 m-0">
                            {{ $error }}
                        </p>
                        @endforeach
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            @endif
        </div>
        <!-- FIM MENSAGENS -->


        <!-- HEADER -->
        <div class="p-2 m-0">

            <!-- TITULO -->
            <div class="row mt-3">
                <div class="col">
                    <h2 class="m-0 fw-bolder fs-2 text-black">
                        Gestor de Pedidos
                        <span class="fs-6 text-secondary fw-light">
                            @if($data['token'] != null)
                            Integração iFood online até
                            {{\Carbon\Carbon::parse($data['token']->created_at)->addDays(7)->format('d/m/Y')}}
                            @endif
                        </span>
                    </h2>
                </div>

                <div class="col d-flex align-items-center justify-content-end p-0">
                    <a class="btn bg-padrao text-white m-0 py-1 px-5 fw-bold d-flex align-items-center justify-content-center"
                        href="">
                        <span class="material-symbols-outlined mr-1">
                            add
                        </span>
                        Novo
                    </a>
                </div>
            </div>
            <!-- FIM TITULO -->

            <!-- FILTROS -->
            <div class="overflow-x-scroll w100 m-0">
                <div class="d-flex flex-nowrap py-3">
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
                        class="p-2 mx-1 border rounded text-decoration-none text-secondary d-flex align-items-center"
                        style="min-width: 110px;">
                        <span class="material-symbols-outlined text-danger mr-1">
                            radio_button_unchecked
                        </span>
                        Pendentes
                    </a>
                    @endif

                    @if($filtro != 1)
                    <a href="{{ route('pedido.gestor', ['filtro' => 1]) }}"
                        class="p-2 mx-1 border rounded text-decoration-none text-secondary d-flex align-items-center"
                        style="min-width: 110px;">
                        <span class="material-symbols-outlined text-warning mr-1"
                            style="font-variation-settings: 'FILL' 1;">
                            radio_button_unchecked
                        </span>
                        Em preparo
                    </a>
                    @endif

                    @if($filtro != 2)
                    <a href="{{ route('pedido.gestor', ['filtro' => 2]) }}"
                        class="p-2 mx-1 border rounded text-decoration-none text-secondary d-flex align-items-center"
                        style="min-width: 110px;">
                        <span class="material-symbols-outlined text-primary mr-1"
                            style="font-variation-settings: 'FILL' 1;">
                            radio_button_unchecked
                        </span>
                        Pronto p/ retirar
                    </a>
                    @endif

                    @if($filtro != 3)
                    <a href="{{ route('pedido.gestor', ['filtro' => 3]) }}"
                        class="p-2 mx-1 border rounded text-decoration-none text-secondary d-flex align-items-center"
                        style="min-width: 110px;">
                        <span class="material-symbols-outlined text-primary mr-1">
                            radio_button_unchecked
                        </span>
                        A caminho
                    </a>
                    @endif

                    @if($filtro != 4)
                    <a href="{{ route('pedido.gestor', ['filtro' => 4]) }}"
                        class="p-2 mx-1 border rounded text-decoration-none text-secondary d-flex align-items-center"
                        style="min-width: 110px;">
                        <span class="material-symbols-outlined text-success mr-1"
                            style="font-variation-settings: 'FILL' 1;">
                            radio_button_unchecked
                        </span>
                        Concluídos
                    </a>
                    @endif

                    @if($filtro != 5)
                    <a href="{{ route('pedido.gestor', ['filtro' => 5]) }}"
                        class="p-2 mx-1 border rounded text-decoration-none text-secondary d-flex align-items-center"
                        style="min-width: 110px;">
                        <span class="material-symbols-outlined text-secondary mr-1"
                            style="font-variation-settings: 'FILL' 1;">
                            radio_button_unchecked
                        </span>
                        Cancelados
                    </a>
                    @endif

                </div>
            </div>
            <!-- FIM FILTROS -->

        </div>
        <!-- FIM HEADER -->

        <!-- PEDIDOS GRID -->
        <div class="row g-1" id="pedidos-grid">

            @if(isset($data['pedidos']))

            <!-- PEDIDOS -->
            @foreach($data['pedidos'] as $pedido)

            <!-- MODAL DETALHES PEDIDO -->
            <div class="modal fade modal-lg" id="modalDetalhes" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="modalDetalhesLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-between">
                            @if(isset($data['pedido']))
                            <p class="fw-bold fs-5 m-0" id="modalDetalhesLabel">
                                #0{{$data['pedido']->id}}0
                            </p>
                            <p class="m-0 text-secondary">
                                Recebido {{ \Carbon\Carbon::parse($data['pedido']->feito_em)->diffForHumans() }}
                            </p>
                            <button type="button" class="pe-auto" data-bs-dismiss="modal" aria-label="Close">
                                <span class="material-symbols-outlined">
                                    close
                                </span>
                            </button>
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
                            <a href="{{ route('pedido.gestor') }}" class="btn border-padrao text-padrao">
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
            <!-- FIM PEDIDOS -->

            @endif

        </div>
        <!-- FIM PEDIDOS GRID -->
    </div>

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