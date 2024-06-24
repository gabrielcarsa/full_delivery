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
                <h2 class="my-3 fw-bolder fs-1">Categoria e produtos
                    <span class="text-secondary fs-3">
                        ({{$categorias->count()}})
                    </span>
                </h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn btn-primary m-0 py-1 px-5 fw-semibold d-flex align-items-center justify-content-center"
                    href="{{ route('categoria_produto.novo') }}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Cadastrar
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- HEADER TABLE -->
        <div class="row">
            <div class="col mb-3">
                <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Exportar
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">PDF</a></li>
                </ul>
            </div>
            <div class="col d-flex align-items-center justify-content-end">
                <form class="row" action="/cliente" method="get" autocomplete="off">
                    @csrf
                    <div class="col-8">
                        <input type="text" name="nome" value="{{request('nome')}}" class="form-control"
                            placeholder="Buscar por categoria">
                    </div>

                    <div class="col d-flex align-items-center justify-content-end p-0">
                        <button type="submit"
                            class="btn btn-primary fw-semibold d-flex align-items-center justify-content-center py-1 m-0 w-100">
                            <span class="material-symbols-outlined mr-1">
                                search
                            </span>
                            Consultar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- FIM HEADER TABLE -->

        <!-- TABLE -->
        @if(isset($categorias))
        <table class="table table-padrao border-top table align-middle">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Ordem de exibição</th>
                    <th scope="col">Restaurante</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>

                <!-- CATEGORIAS -->
                @foreach ($categorias as $categoria)
                <tr>
                    <th scope="row">{{$categoria->id}}</th>
                    <td><a class="btn btn-outline-primary"
                            href="{{ route('produtos', ['categoria_id' => $categoria->id]) }}">{{$categoria->nome}}</a>
                    </td>
                    <td>{{$categoria->descricao}}</td>
                    <td>{{$categoria->ordem}}</td>
                    <td>{{$categoria->restaurante}}</td>
                    <td>
                        <a href="{{ route('categoria_produto.editar', ['id' => $categoria->id]) }}"
                            class="acoes-listar text-decoration-none">
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
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                                    <form action="{{ route('categoria_produto.excluir', ['id' => $categoria->id]) }}"
                                        method="POST">
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
                <!-- FIM CATEGORIAS -->

            </tbody>
        </table>
        @endif

    </div>

</x-app-layout>