<x-layout-cardapio>
    @if($data['restaurante_id'] == null)

    <div class="container my-3 mx-3 bg-body-tertiary">

        <h2 class="madimi-one-regular fs-2">Escolha o restaurante:</h2>

        @foreach($data['restaurantes'] as $restaurante)

        <a href="?restaurante_id={{$restaurante->id}}" class="btn btn-dark">{{$restaurante->nome}}</a>

        @endforeach

    </div>

    @else

    <div class="carrinho-botao fixed-top d-flex align-items-end justify-content-end">
        <a href="{{ route('carrinho.cardapio', ['restaurante_id' => $data['restaurante_id']]) }}" class="btn btn-primary btn-carrinho p-3 rounded">
            <span class="fas fa-shopping-cart fs-4"></span>
        </a>
    </div>

    <div class="restaurante-section">

        <div class="banner-img" style="background-image: url({{ asset('storage/images/banner.jpg')}});');">
        </div>

        <div class="container d-flex p-3 align-items-center justify-content-center">
            <div class="p-2">
                <img src="{{ asset('storage/logo/'.$data['restaurantes']->imagem) }}" class="logo-cardapio">
            </div>
            <div class="p-4">
                <h2>{{$data['restaurantes']->nome}}</h2>
                <p class="text-secondary">{{$data['restaurantes']->descricao}}</p>
            </div>
        </div>
        <div class="m-3 text-center">
            <p class=""><i class="fa-solid fa-circle-check text-success"></i> Aberto</p>
            <p class=""><i class="fa-solid fa-dollar-sign"></i> Pedido minímo: R$ 20,00</p>
            <!-- Button trigger modal -->
            <a href="" class="btn border" data-bs-toggle="modal" data-bs-target="#modalHorarios">
                Mais sobre
            </a>

            <!-- Modal -->
            <div class="modal fade" id="modalHorarios" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Horários Funcionamento</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="bg-body-tertiary">
        <div class="p-3 container">

            <div class="d-flex align-items-center justify-content-center">

                @foreach($data['categoria_cardapio'] as $categoria)

                <a href="#{{$categoria->nome}}" class="btn btn-dark m-1">{{$categoria->nome}}</a>

                @endforeach
            </div>

            <div class="cardapio-lista bg-body-body">
                @foreach($data['categoria_cardapio'] as $categoria)
                <h3 id="{{$categoria->nome}}" class="my-3 fw-bolder">{{$categoria->nome}}</h3>
                <div class="row">

                    @foreach($data['cardapio_resultados'] as $produto)

                    @if($categoria->id == $produto->categoria_id)

                    <div class="col-md-6">
                        <a href="{{ route('produto.cardapio', ['restaurante_id' => $data['restaurante_id'], 'produto_id' => $produto->id_produto]) }}" class="text-decoration-none text-reset">
                            <div class="card mb-2 px-3">
                                <div class="card-grid">
                                    <div class="centralizar-img">
                                        <img src="{{ asset('storage/imagens_produtos/'.$produto->imagem_produto) }}"
                                            class="rounded img-produto" alt="{{$produto->nome_produto}}">
                                    </div>
                                    <div class="card-texto-grid">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$produto->nome_produto}}</h5>
                                            <p class="text-secondary text-truncate">{{$produto->descricao_produto}}</p>
                                            <p>Serve 1 pessoa</p>
                                            <p class="fw-800"><strong>R$
                                                    {{number_format($produto->preco_produto, 2, ',', '.')}}</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>
                    @endif
                    @endforeach

                </div>

                @endforeach

            </div>


        </div>
    </div>

    <div class="app-bar fixed-bottom bg-white border-top p-2">
        <div class="container">
            <ul class="nav justify-content-around">
                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center {{ request()->routeIs('cardapio') ? 'text-reset' : 'text-secondary'}}"
                        href="{{ route('cardapio', ['restaurante_id' => request('restaurante_id')]) }}">
                        <i class="fa-solid fa-book-open"></i> <span>Cardápio</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center {{ request()->routeIs('pedidos') ? 'text-reset' : 'text-secondary'}}"
                        href="#">
                        <i class="fa-solid fa-receipt"></i><span>Pedidos</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center {{ request()->routeIs('conta') ? 'text-reset' : 'text-secondary'}}"
                        href="#">
                        <i class="fa-solid fa-user"></i><span>Conta</span></a>

                </li>
            </ul>
        </div>
    </div>

    @endif

</x-layout-cardapio>