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
                    {{$varPagarOuReceber == 0 ? 'Contas a pagar' : 'Contas a receber'}}
                </h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <div class="dropdown mr-2">
                    <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Ações
                    </button>
                    <ul class="dropdown-menu">
                        <li class="border-bottom py-2">
                            <a class="dropdown-item d-flex align-items-center" href="#" id="alterar-valor">
                                <span class="material-symbols-outlined mr-2">
                                    attach_money
                                </span>
                                Alterar valor parcela
                            </a>
                        </li>
                        <li class="border-bottom py-2">
                            <a class="dropdown-item d-flex align-items-center" href="#" id="alterar-vencimento">
                                <span class="material-symbols-outlined mr-2">
                                    edit_calendar
                                </span>
                                Alterar vencimento
                            </a>
                        </li>
                        <li class="border-bottom py-2">
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <span class="material-symbols-outlined mr-2">
                                    payments
                                </span>
                                Baixar parcela
                            </a>
                        </li>
                        <li class="border-bottom py-2">
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <span class="material-symbols-outlined mr-2">
                                    undo
                                </span>
                                {{$varPagarOuReceber == 0 ? 'Estornar pagamento' : 'Estornar recebimento'}}
                            </a>
                        </li>
                        <li class="py-2">
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <span class="material-symbols-outlined mr-2">
                                    delete
                                </span>
                                Estornar parcela
                            </a>
                        </li>
                    </ul>
                </div>
                <a class="btn bg-padrao text-white m-0 py-1 px-5 fw-bold d-flex align-items-center justify-content-center"
                    href="{{ route('lancamento.novo', ['varPagarOuReceber' => $varPagarOuReceber == 0 ? 0 : 1]) }}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    {{$varPagarOuReceber == 0 ? 'Novo pagamento' : 'Novo recebimento'}}
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- FORM -->
        <form action="{{route($varPagarOuReceber == 0 ? 'contas_pagar.indexAll' : 'contas_receber.indexAll')}}"
            method="get" autocomplete="off">
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
                            <label for="inputClienteFornecedor" class="form-label">
                                {{$varPagarOuReceber == 0 ? 'Fornecedor' : 'Cliente'}}
                            </label>
                            <select id="inputClienteFornecedor" name="cliente_fornecedor_id"
                                class="form-select form-control">
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
                                        id="periodoPagamento" value="2">
                                    <label class="form-check-label" for="periodoPagamento">
                                        Pagamento
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
                        <th scope="col">{{$varPagarOuReceber == 0 ? 'Fornecedores' : 'Clientes'}}</th>
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
                        @if($varPagarOuReceber == 0)
                        <td>{{$parcela->lancamento->fornecedor->nome}}</td>
                        @else
                        <td>{{$parcela->lancamento->cliente->nome}}</td>
                        @endif
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {


        // Captura o clique no Parcelas Reajustar
        $("#alterar-valor").click(function(event) {
            event.preventDefault();

            // Obtenha os valores dos checkboxes selecionados
            var checkboxesSelecionados = [];

            $("input[name='checkboxes[]']:checked").each(function() {
                checkboxesSelecionados.push($(this).val());
            });

            // Crie a URL com os valores dos checkboxes como parâmetros de consulta
            var url = "{{ route('parcela.editValorParcela') }}?checkboxes=" + checkboxesSelecionados
                .join(',');

            // Redirecione para a URL com os parâmetros
            window.location.href = url;
        });

        // Captura o clique no Alterar Data Vencimento
        $("#alterar-vencimento").click(function(event) {
            event.preventDefault();

            // Obtenha os valores dos checkboxes selecionados
            var checkboxesSelecionados = [];

            $("input[name='checkboxes[]']:checked").each(function() {
                checkboxesSelecionados.push($(this).val());
            });

            // Crie a URL com os valores dos checkboxes como parâmetros de consulta
            var url = "{{route('parcela.editVencimentoParcela')}}?checkboxes=" + checkboxesSelecionados
                .join(',');

            // Redirecione para a URL com os parâmetros
            window.location.href = url;
        });

        $("#baixar_parcela").click(function(event) {
            event.preventDefault();

            // Obtenha os valores dos checkboxes selecionados
            var checkboxesSelecionados = [];

            $("input[name='checkboxes[]']:checked").each(function() {
                checkboxesSelecionados.push($(this).val());
            });

            // Crie a URL com os valores dos checkboxes como parâmetros de consulta
            var url = "?checkboxes=" + checkboxesSelecionados
                .join(
                    ',') +
                "&origem=contas_pagar";

            // Redirecione para a URL com os parâmetros
            window.location.href = url;
        });

        $("#estornar_pagamento").click(function(event) {
            event.preventDefault();

            // Obtenha os valores dos checkboxes selecionados
            var checkboxesSelecionados = [];

            $("input[name='checkboxes[]']:checked").each(function() {
                checkboxesSelecionados.push($(this).val());
            });

            // Crie a URL com os valores dos checkboxes como parâmetros de consulta
            var url = "?checkboxes=" + checkboxesSelecionados.join(
                    ',') +
                "&origem=contas_pagar";

            // Redirecione para a URL com os parâmetros
            window.location.href = url;
        });

        $("#estornar_parcela").click(function(event) {
            event.preventDefault();

            // Obtenha os valores dos checkboxes selecionados
            var checkboxesSelecionados = [];

            $("input[name='checkboxes[]']:checked").each(function() {
                checkboxesSelecionados.push($(this).val());
            });

            // Crie a URL com os valores dos checkboxes como parâmetros de consulta
            var url = "?checkboxes=" + checkboxesSelecionados
                .join(
                    ',') +
                "&origem=contas_pagar";

            // Redirecione para a URL com os parâmetros
            window.location.href = url;
        });


        // Selecionar todos checkboxes
        $("#selecionar_todos").click(function() {
            // Obtém o estado atual do "Selecionar Todos" dentro da tabela atual
            var selecionarTodos = $(this).prop('checked');

            // Encontra os checkboxes individuais dentro da tabela atual e marca ou desmarca com base no estado do "Selecionar Todos"
            $(this).closest('table').find("input[name='checkboxes[]']").prop('checked',
                selecionarTodos);
        });


    });
    </script>

</x-app-layout>