<x-layout-cardapio>
    <div class="container">
        <h1 class="mt-5 mb-4">Detalhes do Produto</h1>
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('storage/imagens_produtos/'.$produto->imagem) }}" class="rounded img-fluid mb-3"
                    alt="{{$produto->nome}}">
            </div>
            <div class="col-md-6">
                <h2>{{$produto->nome}}</h2>
                <p>{{$produto->descricao}}</p>
                <p><strong>Preço: </strong>R$ {{number_format($produto->preco, 2, ',', '.')}}</p>
                <form action="/adicionar-ao-carrinho" method="post">

                    <div class="rounded border">
                        <p>Adicionar batata</p>
                    </div>
                    <div class="input-group mt-3">
                        <input type="number" id="quantidade" name="quantidade" class="form-control" value="1" min="1">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Adicionar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container">

        <h2></h2>
        <p></p>
    </div>
</x-layout-cardapio>