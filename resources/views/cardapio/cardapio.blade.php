<x-layout-cardapio>
    @if($data['restaurante_id'] == null)

    <div class="container my-3 mx-3 bg-body-tertiary">

        <h2 class="madimi-one-regular fs-2">Escolha o restaurante:</h2>

        @foreach($data['restaurantes'] as $restaurante)

        <a href="?restaurante_id={{$restaurante->id}}" class="btn btn-dark">{{$restaurante->nome}}</a>

        @endforeach

    </div>

    @else

    <div class="restaurante-section bg-body-tertiary py-3">
        <div class="container d-flex p-3 align-items-center justify-content-center">
            <div class="p-2">
                <img src="{{ asset('storage/logo/'.$data['restaurantes']->imagem) }}" class="logo-cardapio">
            </div>
            <div class="p-4">
                <h2>{{$data['restaurantes']->nome}}</h2>
                <p class="text-secondary">{{$data['restaurantes']->descricao}}</p>
            </div>
        </div>
        <div class="my-3 mx-3">
            <p class="m-3">Aberto</p>
            <p class="m-3">Pedido minímo: R$ 20,00</p>
            <!-- Button trigger modal -->
            <a href="" class="m-3 text-reset" data-bs-toggle="modal" data-bs-target="#modalHorarios">
                Horários de funcionamento
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

    <div class="p-3 container">

        <div class="d-flex align-items-center justify-content-center">

            @foreach($data['categoria_cardapio'] as $categoria)

            <a href="#{{$categoria->nome}}" class="btn btn-dark m-1">{{$categoria->nome}}</a>

            @endforeach
        </div>

        <div class="cardapio-lista bg-body-body">
            @foreach($data['categoria_cardapio'] as $categoria)
            <h3 id="{{$categoria->nome}}" class="my-3">{{$categoria->nome}}</h3>
            <div class="row">

                @foreach($data['cardapio_resultados'] as $cardapio)

                @if($categoria->id == $cardapio->categoria_id)

                <div class="col-md-6 ">
                    <div class="card mb-2">
                        <div class="row g-0 d-flex flex-column flex-sm-row align-items-center">
                            <div class="col-sm-4 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('storage/imagens_produtos/'.$cardapio->imagem_produto) }}"
                                    class="rounded img-produto" alt="{{$cardapio->nome_produto}}">
                            </div>
                            <div class="col-sm-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{$cardapio->nome_produto}}</h5>
                                    <p class="text-secondary text-truncate">{{$cardapio->descricao_produto}}</p>
                                    <p>Serve 1 pessoa</p>
                                    <p class="fw-800"><strong>R$ {{$cardapio->preco_produto}}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach

            </div>

            @endforeach

        </div>


    </div>

    @endif

</x-layout-cardapio>