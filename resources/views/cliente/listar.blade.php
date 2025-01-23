<x-app-layout>

    <div class="container-padrao">

        <!-- HEADER -->
        <div class="row">
            <div class="col">
                <h2 class="my-3 fw-bolder fs-1">Clientes <span
                        class="text-secondary fs-3">({{$clientes->count()}})</span></h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn bg-padrao text-white m-0 py-1 px-5 fw-bold d-flex align-items-center justify-content-center"
                    href="{{ route('cliente.novo') }}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Cadastrar
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- CARD -->
        <div class="card p-3 shadow-sm">

            <!-- HEADER TABLE -->
            <div class="d-flex justify-content-between px-3">
                <div class="">
                    <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Exportar
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">PDF</a></li>
                    </ul>
                </div>
                <div class="">
                    <form class="row" action="/cliente" method="get" autocomplete="off">
                        @csrf
                        <div class="col-8">
                            <input type="text" name="nome" value="{{request('nome')}}" class="form-control"
                                placeholder="Buscar por nome">
                        </div>

                        <div class="col d-flex align-items-center justify-content-end p-0">
                            <button type="submit"
                                class="btn bg-padrao text-white fw-semibold d-flex align-items-center justify-content-center py-1 m-0 w-100">
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
            @if(isset($clientes))

            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col" class="col-md-1">ID</th>
                        <th scope="col" class="col-md-4">Nome</th>
                        <th scope="col" class="col-md-2">CPF</th>
                        <th scope="col" class="col-md-2">Telefone</th>
                        <th scope="col" class="col-md-1">Email</th>
                        <th scope="col" class="col-md-1">Qtnd pedidos</th>
                        <th scope="col" class="col-md-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- CLIENTES -->
                    @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{$cliente->id}}</td>
                        <td>
                            <p class="m-0 fw-semibold">
                                {{$cliente->nome}}
                            </p>
                            @if($cliente->is_client_default == true)
                            <p class="m-0 text-secondary">
                                Criado automáticamente para ser vinculada a clientes sem cadastro quando realizam
                                pedidos.
                            </p>
                            @endif
                        </td>
                        <td>{{$cliente->cpf}}</td>
                        <td>{{ preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $cliente->telefone) }}</td>
                        <td>{{$cliente->email}}</td>
                        <td>{{count($cliente->pedido)}}</td>
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
            @endif
            <!-- FIM TABLE -->
        </div>
        <!-- FIM CARD -->
    </div>

</x-app-layout>