<x-layout-cardapio>
    <div class="nav-produto d-flex p-0 fixed-top p-1 bg-light border shadow-sm">
        <div class="d-flex align-items-center">
            <a href="#" onclick="history.go(-1); return false;" class="btn btn-light rounded-circle"><i
                    class="fas fa-arrow-left"></i></a>
        </div>
        <div class="d-flex align-items-center justify-content-center text-center" style="flex: 1;">
            <h2 class="fs-5">{{$produto[0]->nome}}</h2>
        </div>
    </div>

    <div class="container" style="padding-top: 70px;">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('storage/imagens_produtos/'.$produto[0]->imagem) }}" class="rounded img-fluid mb-3"
                    alt="{{$produto[0]->nome}}">
            </div>
            <div class="col-md-6">
                <p class="text-secondary">{{$produto[0]->descricao}}</p>
                <form action="/adicionar-carrinho/{{$produto[0]->id}}?restaurante_id={{$restaurante_id}}" method="post">
                    @csrf

                    <div class="bg-body-tertiary p-3 ">

                        <h5>Algo mais?</h5>
                        @foreach($produto as $opcional)
                        @if(!empty($opcional->nome_opcional))
                        <hr>
                        <div class="row">
                            <div class="col-10">
                                <p class="m-0">{{$opcional->nome_opcional}}</p>
                                <p class="m-0 text-secondary">{{$opcional->descricao_opcional}}</p>
                                <p class="m-0">+ R$ {{number_format($opcional->preco_opcional, 2, ',', '.')}}</p>
                            </div>
                            <div class="col-2 d-flex align-items-center">
                                <input type="checkbox" class="checkbox-produto-opcional" name="opcionais[]"
                                    value="{{$opcional->id_opcional}}">
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>

                    <div class="mt-2">
                        <label for="obsTextArea" class="form-label fw-semibold mt-3"><i class="fa-solid fa-message"></i>
                            Deseja adicionar alguma observação?</label>
                        <textarea class="form-control" placeholder="Ex.: Tirar picles, carne ao ponto..."
                            id="obsTextArea" name="observacao"></textarea>
                    </div>

                    <div class="input-group mt-3 fixed-bottom p-3 shadow-sm bg-light">
                        <button type="button" class="btn btn-outline-dark">-</button>
                        <input type="number" id="quantidade" name="quantidade" class="form-control" value="1" min="1">
                        <button type="button" class="btn btn-outline-dark">+</button>
                        <div class="mx-1"></div>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success">Adicionar R$
                                {{number_format($produto[0]->preco, 2, ',', '.')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layout-cardapio>