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
        <div class="row">
            <div class="col">
                <h2 class="my-3 fw-bolder fs-1">
                    Movimentações
                </h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn bg-padrao text-white m-0 py-1 px-5 fw-bold d-flex align-items-center justify-content-center"
                    href="">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Nova movimentação
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- FORM -->
        <form action="" method="get" autocomplete="off">
            @csrf

            <!-- CARD FORM -->
            <div class="border rounded">

                <!-- CARD FORM HEADER -->
                <div class="p-3 border-bottom">
                    <p class="m-0 fs-5 fw-bold">
                        Filtros para listagem
                    </p>
                </div>
                <!-- FIM CARD FORM HEADER -->

                <!-- CARD FORM BODY -->
                <div class="bg-white p-3">

                    <!-- ROW -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="inputData" class="form-label">Data início</label>
                            <input type="date" name="data_inicio" id="inputData" value="" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="inputData" class="form-label">Data fim</label>
                            <input type="date" name="data_fim" id="inputData" value="" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="inputLoja" class="form-label">Loja</label>
                            <input type="text" name="" readonly disabled id="inputLoja" value="{{$dados['loja']->nome}}"
                                class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="inputContaCorrente" class="form-label">Conta corrente</label>
                            <select id="inputContaCorrente" name="conta_corrente_id" class="form-select form-control">
                                <option value="0" {{ old('conta_corrente_id') == 0 ? 'selected' : '' }}>-- Selecione --
                                </option>
                                @foreach ($dados['contas_corrente'] as $conta)
                                <option value="{{ $conta->id }}"
                                    {{ old('conta_corrente_id') == $conta->id ? 'selected' : '' }}>
                                    {{$conta->nome}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <!-- FIM ROW -->

                    <div class="d-flex">
                        <button type="submit" class="btn bg-padrao text-white px-4 fw-semibold">
                            Consultar
                        </button>
                    </div>

                </div>
                <!-- FIM CARD FORM BODY -->

            </div>
            <!-- FIM CARD FORM -->

        </form>
        <!-- FIM FORM -->

        <!-- MOVIMENTAÇÕES -->
        @if(isset($movimentacoes))

        <div class="bg-white p-3 rounded border my-3">

            <!-- HEADER TABLE MOVIMENTAÇÕES -->
            <div class="mb-3">
                <button class="btn border-padrao text-padrao dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Exportar
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">PDF</a></li>
                </ul>
            </div>
            <!-- FIM HEADER TABLE MOVIMENTAÇÕES -->

            <!-- TABLE MOVIMENTAÇÕES  -->
            <table class="table table-hover table-bordered text-center">
                <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" id="selecionar_todos" name="selecionar_todos" />
                        </th>
                        <th scope="col">ID</th>
                        <th scope="col">Cliente/Fornecedor</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Data</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- MOVIMENTAÇÃO -->
                    @foreach ($movimentacoes as $movimentacao)
                    <tr>
                        <td>{{$movimentacao->id}}</td>
                        @if($movimentacao->tipo == 0)
                        <td>{{$movimentacao->lancamento->fornecedor->nome}}</td>
                        @else
                        <td>{{$movimentacao->lancamento->cliente->nome}}</td>
                        @endif
                        <td>{{$movimentacao->lancamento->categoria_financeiro->nome }}</td>
                        <td>{{$movimentacao->lancamento->descricao}}</td>
                        <td>{{\Carbon\Carbon::parse($movimentacao->data_movimentacao)->format('d/m/Y') }}</td>
                        <td>R$ {{number_format($movimentacao->valor, 2, ',', '.')}}</td>
                        <td></td>
                    </tr>
                    @endforeach
                    <!-- FIM MOVIMENTAÇÃO -->

                </tbody>
            </table>
            <!-- FIM TABLE MOVIMENTAÇÕES -->
            @endif
        </div>
        <!-- FIM MOVIMENTAÇÕES -->

    </div>


</x-app-layout>