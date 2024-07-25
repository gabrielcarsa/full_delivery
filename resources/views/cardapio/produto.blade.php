<x-layout-cardapio>

    <!-- NAVBAR PRODUTO -->
    <div class="d-flex bg-white fixed-top p-2">
        <a href="#" onclick="history.go(-1); return false;"
            class="text-dark text-decoration-none d-flex align-items-center m-0">
            <span class="material-symbols-outlined">
                arrow_back
            </span>
        </a>
        <div class="d-flex align-items-center justify-content-center" style="flex: 1;">
            <h2 class="fs-5 fw-bold">{{$produto->nome}}</h2>
        </div>
    </div>
    <!-- FIM NAVBAR PRODUTO -->

    <!-- PRODUTO -->
    <div class="container mb-5" style="margin-top: 70px;">
        <div class="row">

            <!-- IMAGEM PRODUTO -->
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <img src="{{ asset('storage/'.$loja->nome.'/imagens_produtos/'.$produto->imagem) }}"
                    class="rounded img-fluid mb-3" alt="{{$produto->nome}}">
            </div>
            <!-- FIM IMAGEM PRODUTO -->

            <!-- DESCRIÇÃO PRODUTO -->
            <div class="col-md-6">
                <p class="text-secondary">{{$produto->descricao}}</p>

                <!-- FORM PRODUTO OPCINAL -->
                <form action="/adicionar-carrinho/{{$produto->id}}?loja_id={{$data['loja_id']}}&consumo_local_viagem={{$data['consumo_local_viagem']}}&endereco_selecionado={{$data['endereco_selecionado']}}" method="post">

                    @csrf
                    <div class="bg-body-tertiary p-3 ">

                        <h5>Algo mais?</h5>

                        <!-- OPCIONAIS -->
                        @foreach($produto->opcional_produto as $opcional)

                        <!-- Se existir opcional -->
                        @if(!empty($opcional->nome))
                        <hr>
                        <div class="row">
                            <div class="col-10">
                                <p class="m-0">{{$opcional->nome}}</p>
                                <p class="m-0 text-secondary">{{$opcional->descricao}}</p>
                                <p class="m-0">+ R$ {{number_format($opcional->preco, 2, ',', '.')}}</p>
                            </div>
                            <div class="col-2 d-flex align-items-center">
                                <input type="checkbox" class="checkbox-produto-opcional" name="opcionais[]"
                                    value="{{$opcional->id}}">
                            </div>
                        </div>
                        @endif

                        @endforeach
                        <!-- FIM OPCIONAIS -->

                    </div>

                    <div class="mt-2">
                        <label for="obsTextArea" class="form-label fw-semibold mt-3"><i class="fa-solid fa-message"></i>
                            Deseja adicionar alguma observação?</label>
                        <textarea class="form-control" placeholder="Ex.: Tirar picles, carne ao ponto..."
                            id="obsTextArea" name="observacao"></textarea>
                    </div>

                    <!-- QUANTIDADE E BTN AÇÃO FIXO BOTTOM -->
                    <div class="bg-white fixed-bottom p-3 shadow-lg d-flex">
                        <button type="button" id="decrement-btn" class="btn btn-outline-dark">-</button>
                        <input type="number" id="quantidade" name="quantidade" class="form-control" value="1" min="1">
                        <button type="button" id="increment-btn" class="btn btn-outline-dark">+</button>
                        <div class="mx-1"></div>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success">Adicionar R$
                                {{number_format($produto->preco, 2, ',', '.')}}</button>
                        </div>
                    </div>
                    <!-- FIM QUANTIDADE E BTN AÇÃO FIXO BOTTOM -->

                </form>
                <!-- FIM FORM PRODUTO OPCINAL -->

            </div>
            <!-- FIM DESCRIÇÃO PRODUTO -->

        </div>

    </div>
    <!-- FIM PRODUTO -->

    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const incrementBtn = document.getElementById('increment-btn');
        const decrementBtn = document.getElementById('decrement-btn');
        const quantidadeInput = document.getElementById('quantidade');

        incrementBtn.addEventListener('click', () => {
            quantidadeInput.value = parseInt(quantidadeInput.value) + 1;
        });

        decrementBtn.addEventListener('click', () => {
            if (quantidadeInput.value > 1) {
                quantidadeInput.value = parseInt(quantidadeInput.value) - 1;
            }
        });
    });
    </script>

</x-layout-cardapio>