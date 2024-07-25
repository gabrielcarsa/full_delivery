<x-app-layout>

    @if(isset($categorias_opcionais))
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
                        ({{$categorias_opcionais->count()}})
                    </span>
                </h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn btn-primary m-0 py-1 px-5 fw-semibold d-flex align-items-center justify-content-center"
                    href="{{ route('categoria_opcional.novo', ['produto_id' => $produto->id]) }}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Cadastrar
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- CATEGORIAS E OPCIONAIS -->

        @foreach ($categorias_opcionais as $categoria_opcional)

        <div class="bg-white border rounded p-3">
            <div class="row d-flex align-items-center mb-3">
                <h4 class="col-6 fw-bold fs-5 m-0">{{$categoria_opcional->nome}}</h4>
                <div class="col-6 d-flex justify-content-end">
                    <a class="btn btn-outline-primary d-flex align-items-center justify-content-center"
                        href="{{ route('opcional_produto.novo', ['categoria_opcional_id' => $categoria_opcional->id]) }}">
                        <span class="material-symbols-outlined mr-1">
                            add
                        </span>
                        Cadastrar opcionais
                    </a>
                    <a href="" data-bs-toggle="modal" class="ml-3 btn btn-outline-danger d-flex align-items-center"
                        data-bs-target="#exampleModal{{$categoria_opcional->id}}">
                        <span class="material-symbols-outlined">
                            delete
                        </span>
                        Excluir categoria
                    </a>
                </div>
            </div>

            <div>
                @foreach($categoria_opcional->opcional_produto as $opcional)
                <div class="row my-1 mx-3 p-3 bg-light rounded">
                    <div class="col">
                        <p class="m-0 fw-semibold">{{$opcional->nome}}</p>
                        <p class="m-0 text-secondary text-truncate">{{$opcional->descricao}}</p>
                        <p class="m-0">R$ {{number_format($opcional->preco, 2, ',', '.')}}</p>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <a class="text-primary text-decoration-none"
                            href="{{ route('opcional_produto.editar', ['id' => $opcional->id]) }}">
                            <span class="material-symbols-outlined mr-1">
                                edit
                            </span>
                        </a>
                        <form action="{{ route('opcional_produto.excluir', ['id' => $opcional->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ml-3 text-danger text-decoration-none">
                                <span class="material-symbols-outlined">
                                    delete
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>


        <!-- MODAL EXCLUIR -->
        <div class="modal fade" id="exampleModal{{$categoria_opcional->id}}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir
                            {{$categoria_opcional->nome}}?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Essa ação é irreversível! Tem certeza?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                        <form action="{{ route('categoria_opcional.excluir', ['id' => $categoria_opcional->id]) }}"
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
        <!-- FIM MODAL EXCLUIR -->

        @endforeach
        <!-- FIM CATEGORIAS E OPCIONAIS -->


    </div>
    @endif

</x-app-layout>