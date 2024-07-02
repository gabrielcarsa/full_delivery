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
                <h2 class="my-3 fw-bolder fs-1">{{$data['categoria']->nome}}
                    <span class="text-secondary fs-3">
                        ({{$data['produtos']->count()}})
                    </span>
                </h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn btn-primary m-0 py-1 px-5 fw-semibold d-flex align-items-center justify-content-center"
                    href="{{ route('produto.novo', ['categoria_id' => $data['categoria']->id]) }}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Cadastrar
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- PRODUTOS GRID -->
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @if(isset($data['produtos']))

            <!-- PRODUTOS -->
            @foreach ($data['produtos'] as $produto)

            <!-- CARD PRODUTO -->
            <div class="col">
                <div class="card position-relative">

                    <!-- LOGO DESTACAR PRODUTO -->
                    @if($produto->destacar == true)
                    <div class="position-absolute start-0 top-0 bg-warning py-1 px-2 d-flex align-items-center rounded">
                        <p class="fs-6 text-white p-0 m-0">DESTACADO</p>
                    </div>
                    @endif

                    <!-- DROPDOWN PRODUTO AÇOES -->
                    <div class="dropdown position-absolute end-0 top-0">
                        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Ações
                        </button>
                        <ul class="dropdown-menu text-center">
                            <li><a href="{{ route('opcional_produto', ['produto_id' => $produto->id]) }}"
                                    class="dropdown-item">Opcionais</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a href="{{ route('produto.editar', ['id' => $produto->id]) }}"
                                    class="dropdown-item">Editar</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a href="{{ route('produto.promocao', ['id' => $produto->id]) }}"
                                    class="dropdown-item">Promoção</a></li>
                            <li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <!-- BTN DESTACAR PRODUTO -->
                                <form action="{{ route('produto.destacar', ['id' => $produto->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="">
                                        Destacar
                                    </button>
                                </form>
                                <!-- FIM BTN DESTACAR PRODUTO -->
                            </li>
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
                    <!-- FIM DROPDOWN PRODUTO AÇOES -->

                    <!-- IMAGEM PRODUTO -->
                    <img src="{{ asset('storage/'.$data['loja']->nome.'/imagens_produtos/'.$produto->imagem) }}"
                        style="max-width: 100%;" class="">
                    <!-- FIM IMAGEM PRODUTO -->

                    <!-- DESCRIÇÃO PRODUTO -->
                    <div class="card-body">
                        <h5 class="card-title text-truncate m-0">{{$produto->nome}}</h5>
                        <p class="text-truncate text-secondary m-0">{{$produto->descricao}}</p>
                        <p class="text-truncate m-0">Serve {{$produto->quantidade_pessoa}}
                            {{$produto->quantidade_pessoa == 1 ? 'pessoa' : 'pessoas'}}</p>

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
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Não</button>
                                        <form action="{{ route('produto.excluir', ['id' => $produto->id]) }}"
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
                        <!-- FIM MODAL EXCLUIR PRODUTO -->

                    </div>
                    <!-- FIM DESCRIÇÃO PRODUTO -->

                </div>
            </div>
            <!-- FIM CARD PRODUTO -->

            @endforeach
            <!-- FIM PRODUTOS -->
            @endif

        </div>
        <!-- FIM PRODUTOS GRID -->

    </div>


</x-app-layout>