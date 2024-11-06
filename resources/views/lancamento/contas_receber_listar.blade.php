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
        <div class="row">
            <div class="col">
                <h2 class="my-3 fw-bolder fs-1">
                    Contas a receber
                </h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn bg-padrao text-white m-0 py-1 px-5 fw-bold d-flex align-items-center justify-content-center"
                    href="{{ route('lancamento.novo', ['varPagarOuReceber' => 1]) }}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Novo recebimento
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- FORM -->
        <form action="" method="post" autocomplete="off">
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
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="inputCategoria" class="form-label">
                                Categoria
                            </label>
                            <select id="inputCategoria" name="categoria_financeiro_id" class="form-select form-control">
                                <option value="1" select>
                                    -- Selecione --
                                </option>
                                <option value="0">
                                    Não dísponivel
                                </option>
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="inputCliente" class="form-label">
                                Cliente
                            </label>
                            <select id="inputCliente" name="cliente_id" class="form-select form-control">
                                <option value="1" select>
                                    -- Selecione --
                                </option>
                                <option value="0">
                                    Não dísponivel
                                </option>
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="inputContaBancaria" class="form-label">
                                Conta bancária
                            </label>
                            <select id="inputContaBancaria" name="conta_bancaria_id" class="form-select form-control">
                                <option value="1" select>
                                    -- Selecione --
                                </option>
                                <option value="0">
                                    Não dísponivel
                                </option>
                            </select>
                        </div>

                    </div>
                    <!-- FIM ROW -->

                    <!-- ROW -->
                    <div class="row my-3">
                        <div class="col-sm-2">
                            <label for="inputIdParcela" class="form-label">
                                ID parcela
                            </label>
                            <input type="text" name="parcela_id" class="form-control" id="inputIdParcela"
                                placeholder="Ex.: 1584">
                        </div>
                        <div class="col-sm-2">
                            <label for="inputDataVencimentoDe" class="form-label">
                                Data início
                            </label>
                            <input type="date" name="periodoDe"
                                value="{{!empty($contas) ? $contas->nome : old('periodoDe')}}" class="form-control"
                                id="inputDataVencimentoDe">
                        </div>
                        <div class="col-sm-2">
                            <label for="inputDataVencimentoAte" class="form-label">
                                Data fim
                            </label>
                            <input type="date" name="periodoAte"
                                value="{{!empty($contas) ? $contas->nome : old('periodoAte')}}" class="form-control"
                                id="inputDataVencimentoAte">
                        </div>
                        <div class="col-sm-6">
                            <label for="inputsChecksTipoPeriodo" class="form-label">
                                Tipo período
                            </label>
                            <div class="inputsChecksTipoPeriodo">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipoPeriodo"
                                        id="periodoLancamento" value="0">
                                    <label class="form-check-label" for="periodoLancamento">
                                        Lançamento
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipoPeriodo"
                                        id="periodoVencimento" value="1">
                                    <label class="form-check-label" for="periodoVencimento">
                                        Vencimento
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipoPeriodo"
                                        id="periodoRecebimento" value="2">
                                    <label class="form-check-label" for="periodoRecebimento">
                                        Recebimento
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipoPeriodo" id="periodoBaixa"
                                        value="3">
                                    <label class="form-check-label" for="periodoBaixa">
                                        Baixa
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- ROW -->
                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <label for="inputsChecksTipoPeriodo" class="form-label">
                                    Situação
                                </label>
                                <div class="inputsChecksTipoPeriodo">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="situacao"
                                            id="periodoLancamento" value="3" checked>
                                        <label class="form-check-label" for="periodoLancamento">
                                            Todos
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="situacao"
                                            id="periodoVencimento" value="0">
                                        <label class="form-check-label" for="periodoVencimento">
                                            A vencer
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="situacao"
                                            id="periodoRecebimento" value="1">
                                        <label class="form-check-label" for="periodoRecebimento">
                                            Pagos
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- FIM ROW -->

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


    </div>

</x-app-layout>