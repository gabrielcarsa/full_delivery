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
        <h2 class="my-3 fw-bolder fs-1">
            Categoria Financeiro
        </h2>
        <!-- FIM HEADER -->

        <!-- CARD FORM -->
        <div class="border rounded mb-3">

            <!-- CARD FORM HEADER -->
            <div class="p-3 border-bottom">
                <p class="m-0 fs-5 fw-bold">
                    Nova categoria
                </p>
            </div>
            <!-- FIM CARD FORM HEADER -->

            <!-- CARD FORM BODY -->
            <div class="bg-white p-3">

                <form action="{{ route('categoria_financeiro.store') }}" method="post">
                    @csrf
                    <!-- ROW -->
                    <div class="row my-3">


                        <div class="col-sm-4">
                            <label for="inputTipo" class="form-label">
                                Tipo
                            </label>
                            <select id="inputTipo" name="tipo" class="form-select form-control">
                                <option value="0" select>
                                    -- Selecione --
                                </option>
                                <option value="1">
                                    Conta a receber
                                </option>
                                <option value="2">
                                    Conta a pagar
                                </option>
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="inputNome" class="form-label">
                                Nome da categoria
                            </label>
                            <input type="text" name="nome" class="form-control" id="inputNome"
                                placeholder="Ex.: Salário, Aluguel, Venda de ABCDE...">
                        </div>

                    </div>
                    <!-- FIM ROW -->

                </form>

                <div class="d-flex">
                    <button type="submit" class="btn bg-padrao text-white px-4 fw-semibold">
                        Salvar
                    </button>
                </div>

            </div>
            <!-- FIM CARD FORM BODY -->

        </div>
        <!-- FIM CARD FORM -->

        @if(isset($categorias))

        <!-- TABLES CATEGORIAS -->
        <div class="row">

            <div class="col-sm-5 bg-white border rounded p-3">

                <p class="fs-4 fw-bold">
                    Categorias de contas a receber
                </p>

                <!-- TABLE -->
                <table class="table table-padrao border-top table align-middle">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Cadastrado por</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- categorias -->
                        @foreach ($categorias['categorias_receber'] as $categoria)
                        <tr>
                            <th scope="row">{{$categoria->id}}</th>
                            <td class="text-uppercase">{{$categoria->nome}}</td>
                            <td>{{$categoria->usuario_cadastrador->nome}}</td>
                            <td>
                                <a href="" class="acoes-listar text-decoration-none">
                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>
                                </a>
                                <a href="" data-bs-toggle="modal" class="acoes-listar text-danger"
                                    data-bs-target="#exampleModal{{$categoria->id}}">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </a>
                            </td>

                            <!-- MODAL EXCLUIR -->
                            <div class="modal fade" id="exampleModal{{$categoria->id}}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir
                                                {{$categoria->nome}}?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Essa ação é irreversível! Tem certeza?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Não</button>
                                            <form action="" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Sim, eu
                                                    tenho</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- MODAL EXCLUIR -->

                        </tr>
                        @endforeach
                        <!-- FIM categorias -->

                    </tbody>
                </table>
                <!-- FIM TABLE -->
            </div>

            <div class="col-sm-2"></div>

            <div class="col-sm-5 bg-white border rounded p-3">

                <p class="fs-4 fw-bold">
                    Categorias de contas a pagar
                </p>

                <!-- TABLE -->
                <table class="table table-padrao border-top table align-middle">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Cadastrado por</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- categorias -->
                        @foreach ($categorias['categorias_pagar'] as $categoria)
                        <tr>
                            <th scope="row">{{$categoria->id}}</th>
                            <td class="text-uppercase">{{$categoria->nome}}</td>
                            <td>{{$categoria->usuario_cadastrador->nome}}</td>
                            <td>
                                <a href="" class="acoes-listar text-decoration-none">
                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>
                                </a>
                                <a href="" data-bs-toggle="modal" class="acoes-listar text-danger"
                                    data-bs-target="#exampleModal{{$categoria->id}}">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </a>
                            </td>

                            <!-- MODAL EXCLUIR -->
                            <div class="modal fade" id="exampleModal{{$categoria->id}}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir
                                                {{$categoria->nome}}?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Essa ação é irreversível! Tem certeza?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Não</button>
                                            <form action="" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Sim, eu
                                                    tenho</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- MODAL EXCLUIR -->

                        </tr>
                        @endforeach
                        <!-- FIM categorias -->

                    </tbody>
                </table>
                <!-- FIM TABLE -->
            </div>
        </div>

        @endif
        <!-- FIM TABLES CATEGORIAS -->

    </div>

</x-app-layout>