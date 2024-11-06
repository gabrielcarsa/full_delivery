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
        <form action="{{route('contas_receber.indexAll')}}" method="get" autocomplete="off">
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

        <!-- PARCELAS -->
        @if(isset($parcelas))
        <div class="bg-white p-3 rounded border my-3">
            <!-- HEADER TABLE PARCELAS -->
            <div class="mb-3">
                <button class="btn border-padrao text-padrao dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Exportar
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">PDF</a></li>
                </ul>
            </div>
            <!-- FIM HEADER TABLE PARCELAS -->

            <!-- TABLE PARCELAS  -->
            <table class="table table-hover table-bordered text-center">
                <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" id="selecionar_todos" name="selecionar_todos" />
                        </th>
                        <th scope="col">ID</th>
                        <th scope="col">Loja</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Nº Parcela</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Vencimento</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PARCELAS -->
                    @foreach ($parcelas as $parcela)
                    <tr>
                        <td>
                            <input data-bs-toggle="collapse" data-bs-target="#collapse{{$parcela->id}}"
                                aria-expanded="false" aria-controls="collapse{{$parcela->id}}" type="checkbox" id=""
                                name="checkboxes[]" value="{{ $parcela->id }}" />
                        </td>
                        <td>{{$parcela->id}}</td>
                        <td>{{$parcela->lancamento->loja->nome}}</td>
                        <td>{{$parcela->lancamento->cliente->nome}}</td>
                        <td>{{$parcela->numero_parcela}} de {{$parcela->lancamento->quantidade_parcela}}</td>
                        <td>{{$parcela->lancamento->categoria_financeiro->nome }}</td>
                        <td>{{$parcela->lancamento->descricao}}</td>
                        <td>{{\Carbon\Carbon::parse($parcela->data_vencimento)->format('d/m/Y') }}</td>
                        <td>R$ {{number_format($parcela->valor, 2, ',', '.')}}</td>
                        <td>{{$parcela->situacao == 1 ? 'Recebido' : 'Em aberto'}}</td>
                    </tr>
                    @endforeach
                    <!-- FIM PARCELAS -->

                </tbody>
            </table>
            <!-- FIM TABLE PARCELAS -->
            @endif
        </div>
        <!-- FIM PARCELAS -->

    </div>

</x-app-layout>