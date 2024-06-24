<x-app-layout>

    @if(isset($opcionais))
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
                <h2 class="my-3 fw-bolder fs-1">Opcionais de {{$produto->nome}}
                    <span class="text-secondary fs-3">
                        ({{$opcionais->count()}})
                    </span>
                </h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn btn-primary m-0 py-1 px-5 fw-semibold d-flex align-items-center justify-content-center"
                    href="{{ route('opcional_produto.novo', ['produto_id' => $produto->id]) }}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Cadastrar
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- TABLE -->
        <table class="table table-padrao border-top table align-middle">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>

                <!-- OPCIONAIS -->
                @foreach ($opcionais as $opcional)
                <tr>
                    <th scope="row">{{$opcional->id}}</th>
                    <td>{{$opcional->nome}}</td>
                    <td>{{$opcional->descricao}}</td>
                    <td>R$ {{number_format($opcional->preco, 2, ',', '.')}}</td>
                    <td>
                        <a href="{{ route('opcional_produto.editar', ['id' => $opcional->id]) }}"
                            class="acoes-listar text-decoration-none">
                            <span class="material-symbols-outlined">
                                edit
                            </span>
                        </a>
                        <a href="" data-bs-toggle="modal" class="acoes-listar text-decoration-none text-danger"
                            data-bs-target="#exampleModal{{$opcional->id}}">
                            <span class="material-symbols-outlined">
                                delete
                            </span>
                        </a>
                    </td>

                    <!-- MODAL EXCLUIR -->
                    <div class="modal fade" id="exampleModal{{$opcional->id}}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir
                                        {{$opcional->nome}}?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Essa ação é irreversível! Tem certeza?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                                    <form action="{{ route('opcional_produto.excluir', ['id' => $opcional->id]) }}"
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
                    <!-- FIM MODAL EXCLUIR -->

                </tr>
                @endforeach
                <!-- FIM OPCIONAIS -->

            </tbody>
        </table>
        <!-- FIM TABLE -->

    </div>
    @endif

</x-app-layout>