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
                    href="{{ route('movimentacao.create') }}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Nova movimentação
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- FORM -->
        <form action="{{ route('movimentacao.index') }}" method="get" autocomplete="off">
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
                            <input type="date" name="data_inicio" id="inputData"
                                value="{{ old('data_inicio') ? old('data_inicio') : request('data_inicio') }}"
                                class="form-control @error('data_inicio') is-invalid @enderror">
                        </div>
                        <div class="col-md-3">
                            <label for="inputData" class="form-label">Data fim</label>
                            <input type="date" name="data_fim" id="inputData"
                                value="{{ old('data_fim') ? old('data_fim') : request('data_fim') }}"
                                class="form-control @error('data_fim') is-invalid @enderror">
                        </div>
                        <div class="col-md-3">
                            <label for="inputLoja" class="form-label">Loja</label>
                            <input type="text" name="" readonly disabled id="inputLoja" value="{{$dados['loja']->nome}}"
                                class="form-control">
                            <input type="hidden" name="loja_id" value="{{$dados['loja']->id}}">
                        </div>
                        <div class="col-md-3">
                            <label for="inputContaCorrente" class="form-label">Conta corrente</label>
                            <select id="inputContaCorrente" name="conta_corrente_id"
                                class="form-select form-control @error('conta_corrente_id') is-invalid @enderror">
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
        @if(isset($movimentacoes) && $movimentacoes->isNotEmpty())

        <!-- VARIAVEL SALDO ANTERIOR -->
        @php
        $saldo_anterior = $dados['saldo_anterior']->saldo ?? $movimentacoes[0]->conta_corrente->saldo_inicial;
        $saldo_movimentacao = $saldo_anterior;
        @endphp

        <!-- SALDOS -->
        <div class="row g-3 mt-1 mb-3">
            <div class="col-md-3">
                <div class="d-flex bg-white align-items-center p-3 shadow-sm rounded">
                    <span class="material-symbols-outlined bg-light p-2 rounded fs-3 text-padrao bg-gray-100">
                        date_range
                    </span>
                    <div class="ml-3">
                        <p class="m-0 fw-semibold">
                            Saldo anterior
                            {{!is_null($dados['saldo_anterior']) ? \Carbon\Carbon::parse($dados['saldo_anterior']->data)->format('d/m/Y') : ''}}
                        </p>
                        <p class="m-0">
                            R$ {{number_format($saldo_anterior, 2, ',', '.')}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex bg-white align-items-center p-3 shadow-sm rounded">
                    <span class="material-symbols-outlined bg-light p-2 rounded fs-3 text-padrao bg-gray-100">
                        attach_money
                    </span>
                    <div class="ml-3">
                        <p class="m-0 fw-semibold">
                            Saldo atual
                        </p>
                        <p class="m-0">
                            R$ {{number_format($movimentacoes[0]->conta_corrente->saldo->last()->saldo, 2, ',', '.')}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex bg-white align-items-center p-3 shadow-sm rounded">
                    <span class="material-symbols-outlined bg-light p-2 rounded fs-3 text-padrao bg-gray-100">
                        storefront
                    </span>
                    <div class="ml-3">
                        <p class="m-0 fw-semibold">
                            Loja
                        </p>
                        <p class="m-0">
                            {{$movimentacoes[0]->conta_corrente->loja->nome}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex bg-white align-items-center p-3 shadow-sm rounded">
                    <span class="material-symbols-outlined bg-light p-2 rounded fs-3 text-padrao bg-gray-100">
                        attach_money
                    </span>
                    <div class="ml-3">
                        <p class="m-0 fw-semibold">
                            Conta Corrente
                        </p>
                        <p class="m-0">
                            {{$movimentacoes[0]->conta_corrente->nome}}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FIM SALDOS -->

        <div class="bg-white p-3 rounded border">

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
                        <th scope="col">ID</th>
                        <th scope="col">Cliente/Fornecedor</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Data</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- MOVIMENTAÇÃO -->
                    @foreach ($movimentacoes as $movimentacao)
                    <tr>
                        <td>
                            <a href="{{ $movimentacao->tipo == 0 ? route('contas_pagar.indexAll', ['parcela_id' => $movimentacao->parcela_lancamento_id]) : route('contas_receber.indexAll', ['parcela_id' => $movimentacao->parcela_lancamento_id]) }}"
                                class="text-padrao">
                                {{$movimentacao->id}}
                            </a>
                        </td>
                        @if($movimentacao->tipo == 0)
                        <td class="text-uppercase">
                            {{$movimentacao->parcela_lancamento->lancamento->fornecedor->nome}}
                        </td>
                        @else
                        <td class="text-uppercase">
                            {{$movimentacao->parcela_lancamento->lancamento->cliente->nome}}
                        </td>
                        @endif
                        <td class="text-uppercase">
                            {{$movimentacao->parcela_lancamento->lancamento->categoria_financeiro->nome }}
                        </td>
                        <td>{{$movimentacao->parcela_lancamento->lancamento->descricao}}</td>
                        <td>{{\Carbon\Carbon::parse($movimentacao->data_movimentacao)->format('d/m/Y') }}</td>
                        <td class="fw-bold {{$movimentacao->tipo == 0 ? 'text-danger' : 'text-success'}}">
                            {{$movimentacao->tipo == 0 ? '- ' : ''}}
                            R$ {{number_format($movimentacao->valor, 2, ',', '.')}}
                        </td>
                        <td class="text-secondary">
                            @php
                            $saldo_movimentacao = $movimentacao->tipo == 0 ? $saldo_movimentacao - $movimentacao->valor
                            : $saldo_movimentacao + $movimentacao->valor;
                            @endphp
                            {{number_format($saldo_movimentacao, 2, ',', '.')}}
                        </td>
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