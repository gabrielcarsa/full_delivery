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
                <a class="btn bg-white text-padrao mr-2 py-1 shadow-sm px-2 fw-semibold d-flex align-items-center justify-content-center"
                    href="{{ route('categoria_produto.importarCardapioIfood') }}">
                    <span class="material-symbols-outlined mr-1">
                        upgrade
                    </span>
                    Importar cardápio iFood
                </a>
                <a class="btn bg-padrao text-white m-0 py-1 px-5 shadow-sm fw-semibold d-flex align-items-center justify-content-center"
                    href="{{ route('categoria_produto.novo') }}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Categoria
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

        <!-- CATEGORIAS E PRODUTOS -->
        @if(isset($categorias))

        <!-- CATEGORIAS -->
        @foreach ($categorias as $categoria)
        <div class="my-3 p-0 bg-white border rounded">

            <!-- HEADER CATEGORIA -->
            <div class="border-bottom p-3 d-flex align-items-center justify-content-between">

                <!-- TITULO CATEGORIA -->
                <div class="">
                    <p class="m-0 text-secondary" style="font-size: 13px !important;">
                        ID {{$categoria->id}}
                    </p>
                    <p class="m-0 fw-bold fs-5 d-flex align-items-center">
                        {{$categoria->nome}}
                        <span class="material-symbols-outlined mx-2"
                            style="font-variation-settings: 'FILL' 1; font-size: 10px">
                            circle
                        </span>
                        <span class="text-secondary fw-medium" style="font-size: 13px !important;">
                            ordem de exibição: {{$categoria->ordem}}
                        </span>
                    </p>
                </div>
                <!-- FIM TITULO CATEGORIA -->

                <div class="d-flex align-items-center">
                    <!-- ADD BTN -->
                    <a class="btn border-padrao text-padrao mx-3 my-0 py-1 px-3 fw-semibold d-flex align-items-center justify-content-center"
                        href="{{ route('produto.novo', ['categoria_produto_id' => $categoria->id]) }}">
                        <span class="material-symbols-outlined mr-1">
                            add
                        </span>
                        Produto
                    </a>
                    <!-- FIM ADD BTN -->

                    <!-- BTN DROPDOWN AÇÕES -->
                    <div class="dropdown d-flex justify-content-end">
                        <button class="text-padrao" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="material-symbols-outlined">
                                more_vert
                            </span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('categoria_produto.editar', ['id' => $categoria->id]) }}">
                                    Editar
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="" data-bs-toggle="modal" class="acoes-listar text-danger"
                                    data-bs-target="#exampleModal{{$categoria->id}}">
                                    Excluir
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- FIM BTN DROPDOWN AÇÕES -->

                    <!-- MODAL EXCLUIR -->
                    <div class="modal fade" id="exampleModal{{$categoria->id}}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p class="fs-5 fw-semibold" id="exampleModalLabel">
                                        Excluir {{$categoria->nome}}?
                                    </p>
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
                </div>

            </div>
            <!-- FIM HEADER CATEGORIA -->

            <!-- PRODUTOS -->
            @foreach($categoria->produto as $produto)

            @if($produto != null)
            <div class="border-bottom d-flex align-items-start justify-content-between p-3">
                <div class="d-flex relative">
                    <!-- LOGO DESTACAR PRODUTO -->
                    @if($produto->destacar == true)
                    <div class="position-absolute start-0 top-0 bg-warning py-1 px-2 d-flex align-items-center rounded">
                        <p class="text-white p-0 m-0" style="font-size: 13px !important;">
                            DESTACADO
                        </p>
                    </div>
                    @endif
                    <!-- FIM LOGO DESTACAR PRODUTO -->

                    <!-- IMAGEM PRODUTO -->
                    <img src="{{ asset('storage/'.$categoria->loja->nome.'/imagens_produtos/'.$produto->imagem) }}"
                        style="width: 120px;" class="">
                    <!-- FIM IMAGEM PRODUTO -->

                    <div class="px-2">
                        <p class="m-0 fw-semibold">
                            {{$produto->nome}}
                        </p>
                        <p class="text-truncate text-secondary m-0" style="max-width: 200px">
                            {{$produto->descricao}}
                        </p>
                        <p class="text-truncate m-0">
                            Serve {{$produto->quantidade_pessoa}}
                            {{$produto->quantidade_pessoa == 1 ? 'pessoa' : 'pessoas'}}
                        </p>
                        @if($produto->tempo_preparo_min_minutos != null && $produto->tempo_preparo_max_minutos != null)
                        <p class="m-0 text-secondary">
                            {{$produto->tempo_preparo_min_minutos}} -
                            {{$produto->tempo_preparo_max_minutos}} minutos de preparo
                        </p>
                        @endif
                        <!-- se houver promoção -->
                        @if($produto->preco_promocao != null)
                        <div class="d-flex">
                            <p class="fw-regular text-secondary text-truncate m-0 text-decoration-line-through">R$
                                {{number_format($produto->preco, 2, ',', '.')}}</p>
                            <p class="mx-2">por</p>
                            <p class="fw-semibold text-truncate m-0">R$
                                {{number_format($produto->preco_promocao, 2, ',', '.')}}</p>
                        </div>
                        <!-- se não houver promoção -->
                        @else
                        <p class="fw-semibold text-truncate">R$ {{number_format($produto->preco, 2, ',', '.')}}</p>
                        @endif
                    </div>

                </div>

                <!-- BTN DROPDOWN AÇÕES -->
                <div class="dropdown d-flex justify-content-end">
                    <button class="text-padrao" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="material-symbols-outlined">
                            more_vert
                        </span>
                    </button>
                    <ul class="dropdown-menu p-0">
                        <li>
                            <a href="{{ route('categoria_opcional', ['produto_id' => $produto->id]) }}"
                                class="dropdown-item">
                                Opcionais
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a href="{{ route('produto.editar', ['id' => $produto->id]) }}" class="dropdown-item">
                                Editar
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a href="{{ route('produto.promocao', ['id' => $produto->id]) }}" class="dropdown-item">
                                Promoção
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="px-3">
                            <!-- BTN DESTACAR PRODUTO -->
                            <form action="{{ route('produto.destacar', ['id' => $produto->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="">
                                    Destacar
                                </button>
                            </form>
                            <!-- FIM BTN DESTACAR PRODUTO -->
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal{{$produto->id}}"
                                class="dropdown-item">
                                Excluir
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- FIM BTN DROPDOWN AÇÕES -->

                <!-- MODAL EXCLUIR PRODUTO -->
                <div class="modal fade" id="exampleModal{{$produto->id}}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir
                                    {{$produto->nome}}?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Essa ação é irreversível! Tem certeza?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                                <form action="{{ route('produto.excluir', ['id' => $produto->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Sim, eu
                                        tenho</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIM MODAL EXCLUIR PRODUTO -->

            </div>
            @endif

            @endforeach
            <!-- FIM PRODUTOS -->

        </div>
        <!-- FIM CATEGORIAS -->
        @endforeach
        @endif
        <!-- FIM CATEGORIAS E PRODUTOS -->
    </div>

</x-app-layout>