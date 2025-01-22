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

    <div class="container-padrao">

        <!-- HEADER -->
        <h2 class="my-3 fw-bolder fs-1">Formas de pagamento</h2>
        <!-- FIM HEADER -->

        <!-- CARD FORMAS DE PAGAMENTO -->
        <div class="p-3 bg-white rounded border">

            <p class="m-0">
                Ative e desative as formas de pagamento aceitas pela sua loja
            </p>
            <p class="text-secondary">
                As formas de pagamento que estão "ativadas" são as aceitas pela sua Loja. Então na hora de pagar o
                pedido serão exibidas somente as opções que estão ativadas.
            </p>

            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col">Status</th>
                        <th scope="col">Forma de pagamento</th>
                        <th scope="col">Aceitar / Rejeitar</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- FORMAS DE PAGAMENTO -->
                    @foreach($dados['formas_pagamento'] as $forma_pagamento)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($forma_pagamento->forma_pagamento_loja->isEmpty())
                                <span class="material-symbols-outlined fill-icon text-danger mr-1">
                                    cancel
                                </span>
                                Desativado
                                @else
                                <span class="material-symbols-outlined fill-icon text-success mr-1">
                                    check_circle
                                </span>
                                Ativado
                                @endif
                            </div>

                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/icones-forma-pagamento/' . $forma_pagamento->imagem . '.svg') }}"
                                    alt="" width="30px">
                                <p class="my-0 mx-2 fw-bold">
                                    {{$forma_pagamento->nome}}
                                </p>
                            </div>

                            <!-- MODAL BTN -->
                            <a class="text-decoration-none text-padrao d-flex align-items-center" data-bs-toggle="modal"
                                data-bs-target="#modalVinculo{{$forma_pagamento->id}}">
                                @if($forma_pagamento->conta_corrente)
                                <span class="material-symbols-outlined">
                                    sync
                                </span>
                                Vinculado a {{$forma_pagamento->conta_corrente->nome}}
                                @else
                                Vincular a uma conta corrente
                                @endif
                            </a>
                            <!-- FIM MODAL BTN -->

                            <!-- MODAL -->
                            <div class="modal fade" id="modalVinculo{{$forma_pagamento->id}}" tabindex="-1"
                                aria-labelledby="modalVinculo{{$forma_pagamento->id}}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <p class="fs-5" id="modalVinculo{{$forma_pagamento->id}}">
                                                Vincular {{$forma_pagamento->nome}} a uma conta:
                                            </p>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-secondary d-flex align-items-center">
                                                <span class="material-symbols-outlined mr-2">
                                                    info
                                                </span>
                                                Ao vincular forma de pagamento com conta corrente todos os pedidos dessa
                                                forma serão baixados na conta corrente selecionada.
                                            </p>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-dark dropdown-toggle w-100" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Selecione a conta corrente abaixo
                                                </button>
                                                <ul class="dropdown-menu w-100">
                                                    <li>
                                                        <h6 class="dropdown-header">
                                                            Clique para vincular
                                                        </h6>
                                                    </li>
                                                    <li>
                                                        @foreach ($dados['contas_corrente'] as $conta)
                                                        <a class="dropdown-item"
                                                            href="{{ route('forma_pagamento.updateVincular', ['id' => $forma_pagamento->id, 'conta_corrente_id' => $conta->id]) }}">
                                                            {{$conta->nome}}
                                                        </a>
                                                        @endforeach

                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FIM MODAL -->
                        </td>
                        <td>
                            <form
                                action="{{ route('forma_pagamento.cadastrar', ['forma_pagamento_id' => $forma_pagamento->id]) }}"
                                method="post">
                                @csrf
                                @if($forma_pagamento->forma_pagamento_loja->isEmpty())
                                <button type="submit" class="btn btn-success fw-semibold">
                                    <div class="d-flex align-items-center">
                                        <span class="material-symbols-outlined mr-2 fill-icon">
                                            check_circle
                                        </span>
                                        Aceitar forma de pagamento
                                    </div>
                                </button>
                                @else
                                <button type="submit" class="btn btn-danger fw-semibold">
                                    <div class="d-flex align-items-center">
                                        <span class="material-symbols-outlined mr-2 fill-icon">
                                            cancel
                                        </span>
                                        Rejeitar forma de pagamento
                                    </div>
                                </button>
                                @endif

                            </form>
                        </td>
                    </tr>

                    @endforeach
                    <!-- FIM FORMAS DE PAGAMENTO -->
                </tbody>
            </table>

        </div>
        <!-- FIM CARD FORMAS DE PAGAMENTO -->

    </div>

</x-app-layout>