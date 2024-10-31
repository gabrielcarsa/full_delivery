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
                    Categoria Financeiro
                </h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn bg-padrao text-white m-0 py-1 px-5 fw-bold d-flex align-items-center justify-content-center"
                    href="{{ route('categoria_financeiro.novo') }}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Nova categoria
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

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
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- categorias -->
                        @foreach ($categorias['categorias_receber'] as $categoria)
                        <tr>
                            <th scope="row">{{$categoria->id}}</th>
                            <td class="text-uppercase">{{$categoria->nome}}</td>
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
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- categorias -->
                        @foreach ($categorias['categorias_pagar'] as $categoria)
                        <tr>
                            <th scope="row">{{$categoria->id}}</th>
                            <td class="text-uppercase">{{$categoria->nome}}</td>
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