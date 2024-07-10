<x-layout-cardapio>

    <!-- NENHUM RESTAURANTE SELECIONADO -->

    @if($data['loja_id'] == null)

    <div class="vh-100 d-flex align-items-center justify-content-center wallpaper-cardapio">

        <!-- APRESENTAÇÃO -->
        <div>
            <h2 class="text-white fs-1 fw-bolder text-center">Olá, bem vindo!</h2>
            <p class="text-light text-center">Vamos começar escolhendo uma loja?</p>

            <div class="row">

                <!-- LOJAS -->
                @foreach($data['lojas'] as $loja)

                <!-- CARDS -->
                <div class="col bg-white m-3 p-3 rounded" style="width: 300px;">
                    <div class="d-flex justify-content-center">
                        <img src='{{asset("storage/$loja->nome/$loja->logo")}}' alt="" width="100" class="rounded">
                    </div>

                    <h3 class="fs-4 fw-bolder my-2 text-center">{{$loja->nome}}</h3>

                    <p class="d-flex align-items-center text-secondary">
                        <span class="material-symbols-outlined mr-2">
                            location_on
                        </span>
                        <span>
                            {{$loja->rua}}, {{$loja->numero}} {{$loja->bairro}} - {{$loja->cidade}} {{$loja->estado}}
                        </span>
                    </p>

                    <div class="d-flex justify-content-center">
                        <a href="?loja_id={{$loja->id}}" class="btn btn-primary px-5">Escolher</a>
                    </div>

                </div>

                @endforeach
            </div>

        </div>

    </div>

    <!-- RESTAURANTE SELECIONADO ## CARDAPIO ## -->

    @else
    <div class="cardapio-loja d-flex align-items-center justify-content-center">

        <div class="bg-white m-3 p-3 rounded border" style="max-width: 400px;">

            <div class="d-flex align-items-center justify-content-center">
                <img src="{{ asset('storage/' . $data['categoria_produto'][0]->loja->nome . '/' . $data['categoria_produto'][0]->loja->logo) }}"
                    class="rounded-circle" style="max-width: 80px;">
            </div>
            <div class="px-3">
                <h2 class="fs-2 fw-bolder my-2">{{$data['categoria_produto'][0]->loja->nome}}</h2>
                <p class="text-secondary m-0 p-0 mb-2">{{$data['categoria_produto'][0]->loja->descricao}}</p>

                <div class="" style="font-size: 13px">
                    <!-- VERIFICAR SE ESTÁ ABERTO -->
                    @if($data['categoria_produto'][0]->loja->is_open)
                    <p class="d-flex align-items-center text-success fw-semibold m-0 p-0">
                        <span class="material-symbols-outlined">
                            radio_button_checked
                        </span>
                        <span>
                            Aberto
                        </span>
                    </p>

                    @else
                    <p class="d-flex align-items-center text-danger fw-semibold m-0 p-0">
                        <span class="material-symbols-outlined mr-1">
                            radio_button_unchecked
                        </span>
                        <span>
                            Fechado
                        </span>
                    </p>
                    @endif

                    <p class="d-flex align-items-center m-0 p-0 text-secondary">
                        <span class="material-symbols-outlined mr-1">
                            attach_money
                        </span>
                        <span>
                            Pedido minímo: R$ 20,00
                        </span>
                    </p>
                    <p class="d-flex align-items-center m-0 p-0 text-secondary">
                        <span class="material-symbols-outlined mr-1">
                            location_on
                        </span>
                        <span>
                            {{$data['categoria_produto'][0]->loja->rua}},
                            {{$data['categoria_produto'][0]->loja->numero}}
                            {{$data['categoria_produto'][0]->loja->bairro}} -
                            {{$data['categoria_produto'][0]->loja->cidade}}
                            {{$data['categoria_produto'][0]->loja->estado}}
                        </span>
                    </p>

                </div>

                <!-- Button trigger modal -->
                <a href="" class="btn border d-flex justify-content-center mt-3" data-bs-toggle="modal"
                    data-bs-target="#modalHorarios">
                    Mais sobre
                </a>

                <!-- Modal -->
                <div class="modal fade" id="modalHorarios" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Horários Funcionamento</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
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
    </div>


    <div class="bg-body-tertiary">
        <div class="p-3 container">

            <div class="d-flex align-items-center justify-content-center">

                @foreach($data['categoria_produto'] as $categoria)

                <a href="#{{$categoria->nome}}" class="btn btn-dark m-1">{{$categoria->nome}}</a>

                @endforeach
            </div>

            <div class="cardapio-lista bg-body-body">

                @foreach($data['categoria_produto'] as $categoria)

                <h3 id="{{$categoria->nome}}" class="my-3 fw-bolder">{{$categoria->nome}}</h3>
                <div class="row">

                    @foreach($categoria->produto as $produto)

                    <div class="col-md-6">
                        <a href="{{ route('cardapio.produto', ['loja_id' => $data['loja_id'], 'produto_id' => $produto->id_produto]) }}"
                            class="text-decoration-none text-reset">
                            <div class="card mb-2 px-3">
                                <div class="card-grid">
                                    <div class="centralizar-img">
                                        <img src="{{ asset('storage/' . $data['categoria_produto'][0]->loja->nome . '/imagens_produtos/' . $produto->imagem) }}"
                                            class="rounded img-produto" alt="{{$produto->nome}}"
                                            style="min-width: 80px;">
                                    </div>
                                    <div class="card-texto-grid">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$produto->nome}}</h5>
                                            <p class="text-secondary text-truncate">{{$produto->descricao}}
                                            </p>
                                            <p>Serve 1 pessoa</p>
                                            <p class="fw-800"><strong>R$
                                                    {{number_format($produto->preco, 2, ',', '.')}}</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>
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
                        href="{{ route('cardapio', ['loja_id' => request('loja_id')]) }}">
                        <span class="material-symbols-outlined">
                            menu_book
                        </span>
                        <span>
                            Cardápio
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center {{ request()->routeIs('cardapio.carrinho') ? 'text-reset' : 'text-secondary'}}"
                        href="{{ route('cardapio.carrinho', ['loja_id' => $data['loja_id']]) }}">
                        <span class="material-symbols-outlined">
                            shopping_cart
                        </span>
                        <span>
                            Carrinho
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center {{ request()->routeIs('pedidos') ? 'text-reset' : 'text-secondary'}}"
                        href="#">
                        <span class="material-symbols-outlined">
                            receipt_long
                        </span>
                        <span>
                            Pedidos
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex flex-column align-items-center {{ request()->routeIs('conta') ? 'text-reset' : 'text-secondary'}}"
                        href="#">
                        <span class="material-symbols-outlined">
                            account_circle
                        </span>
                        <span>
                            Conta
                        </span>
                    </a>

                </li>
            </ul>
        </div>
    </div>

    @endif

</x-layout-cardapio>