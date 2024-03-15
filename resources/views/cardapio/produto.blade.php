<x-layout-cardapio>
    <a href="#" onclick="history.go(-1); return false;" class="btn btn-light rounded-circle border"><i
            class="fas fa-arrow-left"></i></a>
    <div class="container mt-1">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('storage/imagens_produtos/'.$produto->imagem) }}" class="rounded img-fluid mb-3"
                    alt="{{$produto->nome}}">
            </div>
            <div class="col-md-6">
                <h2>{{$produto->nome}}</h2>
                <p class="text-secondary">{{$produto->descricao}}</p>
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