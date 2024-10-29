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
                    href="{{ route('cliente.novo') }}">
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

            <div class="border rounded">

                <div class="p-3 border-bottom">
                    <p class="m-0 fs-5 fw-bold">
                        Filtros para listagem
                    </p>
                </div>

                <div class="bg-white p-3">

                    <div class="row">

                        <div class="col-4">
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

                        <div class="col-4">
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

                        <div class="col-4">
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

                    <div class="row my-3">
                        <div class="col-2">
                            <label for="inputDataVencimentoDe" class="form-label">
                                Data início
                            </label>
                            <input type="date" name="periodoDe"
                                value="{{!empty($contas) ? $contas->nome : old('periodoDe')}}" class="form-control"
                                id="inputDataVencimentoDe">
                        </div>
                        <div class="col-2">
                            <label for="inputDataVencimentoAte" class="form-label">
                                Data fim
                            </label>
                            <input type="date" name="periodoAte"
                                value="{{!empty($contas) ? $contas->nome : old('periodoAte')}}" class="form-control"
                                id="inputDataVencimentoAte">
                        </div>
                        <div class="col-6">
                            <label for="inputsChecksTipoPeriodo" class="form-label">
                                Tipo período
                            </label>
                            <div class="inputsChecksTipoPeriodo">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio1" value="option1">
                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio2" value="option2">
                                    <label class="form-check-label" for="inlineRadio2">2</label>
                                </div>
                                
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </form>
        <!-- FIM FORM -->


    </div>

</x-app-layout>