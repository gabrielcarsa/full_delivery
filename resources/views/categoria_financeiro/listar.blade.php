<x-app-layout>

    <div class="container-padrao">

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

                <form action="{{route('categoria_financeiro.store')}}" method="post">
                    @csrf
                    <!-- ROW -->
                    <div class="row my-3">


                        <div class="col-sm-4">
                            <label for="inputTipo" class="form-label">
                                Tipo
                            </label>
                            <select id="inputTipo" name="tipo"
                                class="form-select form-control @error('tipo') is-invalid @enderror">
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
                            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                                id="inputNome" placeholder="Ex.: Salário, Aluguel, Venda de ABCDE..."
                                autocomplete="off">
                        </div>

                    </div>
                    <!-- FIM ROW -->

                    <div class="d-flex">
                        <button type="submit" class="btn bg-padrao text-white px-4 fw-semibold">
                            Salvar
                        </button>
                    </div>

                </form>


            </div>
            <!-- FIM CARD FORM BODY -->

        </div>
        <!-- FIM CARD FORM -->

        @if(isset($categorias))

        <!-- TABLES CATEGORIAS -->
        <div class="d-flex justify-content-between">

            <div class="w-100 bg-white border rounded p-3 mx-1">

                <p class="fs-4 fw-bold">
                    Categorias de contas a receber
                </p>

                <!-- TABLE -->
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col" class="col-md-1">ID</th>
                            <th scope="col" class="col-md-6">Nome</th>
                            <th scope="col" class="col-md-3">Cadastrado por</th>
                            <th scope="col" class="col-md-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- categorias -->
                        @foreach ($categorias['categorias_receber'] as $categoria)
                        <tr>
                            <td>{{$categoria->id}}</td>
                            <td class="">
                                <p class="m-0 fw-semibold text-">
                                    {{$categoria->nome}}
                                </p>
                                @if($categoria->is_order == true)
                                <p class="m-0 text-secondary">
                                    Esta categoria é criada automáticamente para ser vinculada a todos pedidos
                                    recebidos.
                                </p>
                                @endif
                            </td>
                            <td class="text-truncate" style="max-width: 30px">
                                {{$categoria->usuario_cadastrador->name}}
                            </td>
                            <td>
                                <a href="" data-bs-toggle="modal" class="text-primary text-decoration-none"
                                    data-bs-target="#editarModal{{$categoria->id}}">
                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>
                                </a>
                                <a href="" data-bs-toggle="modal" class="text-danger text-decoration-none"
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
                                            <p class="modal-title fs-5" id="exampleModalLabel">
                                                Excluir {{$categoria->nome}}?
                                            </p>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Essa ação é irreversível! Tem certeza?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Não</button>
                                            <form
                                                action="{{ route('categoria_financeiro.excluir', ['id' => $categoria->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    Sim, eu tenho
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- MODAL EXCLUIR -->

                            <!-- MODAL EDITAR -->
                            <div class="modal fade" id="editarModal{{$categoria->id}}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <p class="modal-title fs-5" id="exampleModalLabel">
                                                Renomear {{$categoria->nome}}?
                                            </p>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form
                                            action="{{ route('categoria_financeiro.edit', ['id' => $categoria->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">

                                                <label for="inputNome" class="form-label">
                                                    Novo nome
                                                </label>
                                                <input type="text" name="nome"
                                                    class="form-control @error('nome') is-invalid @enderror"
                                                    id="inputNome"
                                                    placeholder="Ex.: Salário, Aluguel, Venda de ABCDE..."
                                                    autocomplete="off">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn bg-padrao text-white">
                                                    Salvar
                                                </button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- MODAL EDITAR -->
                        </tr>
                        @endforeach
                        <!-- FIM categorias -->

                    </tbody>
                </table>
                <!-- FIM TABLE -->
            </div>

            <div class="w-100 bg-white border rounded p-3 mx-1">

                <p class="fs-4 fw-bold">
                    Categorias de contas a pagar
                </p>

                <!-- TABLE -->
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col" class="col-md-1">ID</th>
                            <th scope="col" class="col-md-6">Nome</th>
                            <th scope="col" class="col-md-3">Cadastrado por</th>
                            <th scope="col" class="col-md-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- categorias -->
                        @foreach ($categorias['categorias_pagar'] as $categoria)
                        <tr>
                            <td>{{$categoria->id}}</td>
                            <td class="text-uppercase">{{$categoria->nome}}</td>
                            <td class="text-truncate" style="max-width: 30px">
                                {{$categoria->usuario_cadastrador->name}}
                            </td>
                            <td>
                                <a href="" data-bs-toggle="modal" class="text-primary text-decoration-none"
                                    data-bs-target="#editarModal{{$categoria->id}}">
                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>
                                </a>
                                <a href="" data-bs-toggle="modal" class="text-danger text-decoration-none"
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
                                            <p class="modal-title fs-5" id="exampleModalLabel">
                                                Excluir {{$categoria->nome}}?
                                            </p>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Essa ação é irreversível! Tem certeza?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Não</button>
                                            <form
                                                action="{{ route('categoria_financeiro.excluir', ['id' => $categoria->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    Sim, eu tenho
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- MODAL EXCLUIR -->

                            <!-- MODAL EDITAR -->
                            <div class="modal fade" id="editarModal{{$categoria->id}}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <p class="modal-title fs-5" id="exampleModalLabel">
                                                Renomear {{$categoria->nome}}?
                                            </p>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form
                                            action="{{ route('categoria_financeiro.edit', ['id' => $categoria->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">

                                                <label for="inputNome" class="form-label">
                                                    Novo nome
                                                </label>
                                                <input type="text" name="nome"
                                                    class="form-control @error('nome') is-invalid @enderror"
                                                    id="inputNome"
                                                    placeholder="Ex.: Salário, Aluguel, Venda de ABCDE..."
                                                    autocomplete="off">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn bg-padrao text-white">
                                                    Salvar
                                                </button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- MODAL EDITAR -->

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