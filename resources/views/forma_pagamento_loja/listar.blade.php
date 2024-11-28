<x-app-layout>

    <div class="container">

        <!-- MENSAGENS -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- FIM MENSAGENS -->

        <!-- HEADER -->
        <h2 class="my-3 fw-bolder fs-1">Formas de pagamento</h2>
        <!-- FIM HEADER -->

        <!-- CARD FORMAS DE PAGAMENTO -->
        <div class="p-3 bg-white rounded border">

            <!-- FORM -->
            <form action="{{ route('forma_pagamento.cadastrar') }}" method="post">
                @csrf

                <p>Selecione as formas de pagamento aceitas pela sua loja</p>

                <!-- ROW -->
                <div class="row g-3">

                    <!-- FORMAS DE PAGAMENTO -->
                    @foreach($dados['formas_pagamento_loja'] as $forma_pagamento)
                    <div class="form-check col-md-6">
                        <input class="form-check-input" type="checkbox" name="formas_pagamento_loja[]"
                            value="{{$forma_pagamento->id}}" id="flexCheckDefault{{$forma_pagamento->id}}"
                            {{$forma_pagamento->is_ativo == true ? 'checked' : ''}}>
                        <label class="form-check-label d-flex align-items-center"
                            for="flexCheckDefault{{$forma_pagamento->id}}">
                            <img src="{{ asset('storage/icones-forma-pagamento/' . $forma_pagamento->imagem . '.svg') }}"
                                alt="" width="30px">
                            <span class="ml-1 fw-semibold">
                                {{$forma_pagamento->nome}}
                            </span>
                        </label>

                        <!-- Button trigger modal -->
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

                        <!-- Modal -->
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
                    </div>
                    @endforeach
                    <!-- FORMAS DE PAGAMENTO -->

                </div>
                <!-- FIM ROW -->

                <div class="d-flex justify-content-end w-100">
                    <button type="submit" class="btn bg-padrao text-white px-5 fw-semibold">
                        Salvar
                    </button>
                </div>
            </form>
            <!-- FIM FORM -->

        </div>
        <!-- FIM CARD FORMAS DE PAGAMENTO -->

    </div>

</x-app-layout>