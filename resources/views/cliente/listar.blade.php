<x-app-layout>

    <!-- CARD -->
    <div class="card mb-4 mt-4">
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

        <!-- CARD HEADER -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 fw-semibold fs-5">Pesquisar Clientes</h2>
            <a class="btn btn-primary" href="{{ route('cliente.novo') }}">Cadastrar</a>
        </div>
        <!-- FIM CARD HEADER -->

        <!-- CARD BODY -->
        <div class="card-body">
            <form class="row g-3" action="/cliente" method="get" autocomplete="off">
                @csrf
                <div class="col-md-6">
                    <label for="inputNome" class="form-label">Nome</label>
                    <input type="text" name="nome" value="{{request('nome')}}" class="form-control" id="inputNome">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Consultar</button>
                </div>
            </form>
        </div>
        <!-- FIM CARD BODY -->
    </div>

    <!-- CARD CONSULTA -->
    @if(isset($clientes))
    <div class="card mb-4 mt-4">

        <!-- CARD HEADER -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between dropdown">
            <h2 class="m-0 fw-semibold fs-5">Consulta Clientes</h2>
            <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Exportar
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">PDF</a></li>
            </ul>
        </div>
        <!-- FIM CARD HEADER -->

        <!-- CARD BODY -->
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- CLIENTES -->
                    @foreach ($clientes as $cliente)
                    <tr>
                        <th scope="row">{{$cliente->id}}</th>
                        <td>{{$cliente->nome}}</td>
                        <td>{{$cliente->cpf}}</td>
                        <td>{{$cliente->telefone}}</td>
                        <td>{{$cliente->email}}</td>
                        <td>
                            <a href="{{ route('cliente.editar', ['id' => $cliente->id]) }}"
                                class="acoes-listar text-decoration-none">
                                <span class="material-symbols-outlined">
                                    edit
                                </span>
                            </a>
                            <a href="" data-bs-toggle="modal" class="acoes-listar text-danger"
                                data-bs-target="#exampleModal{{$cliente->id}}">
                                <span class="material-symbols-outlined">
                                    delete
                                </span>
                            </a>
                        </td>

                        <!-- MODAL EXCLUIR -->
                        <div class="modal fade" id="exampleModal{{$cliente->id}}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir
                                            {{$cliente->nome}}?</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Essa ação é irreversível! Tem certeza?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Não</button>
                                        <form action="{{ route('cliente.excluir', ['id' => $cliente->id]) }}"
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
                    <!-- FIM CLIENTES -->

                </tbody>
            </table>
        </div>
        <!-- FIM CARD BODY -->

    </div>
    @endif
    <!-- FIM CARD CONSULTA -->

</x-app-layout>