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
            <h2 class="fs-5 fw-semibold">
                {{$produto->nome}}
            </h2>
        </div>
    </div>
    <!-- FIM NAVBAR PRODUTO -->

    <!-- PRODUTO -->
    <div class="container mb-5" style="margin-top: 70px;">
        <div class="row">

            <!-- IMAGEM PRODUTO -->
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <img src="{{ $produto->imagem == null ? (empty($produto->imagemIfood) ? asset('storage/images/sem-imagem.png') : $produto->imagemIfood) : asset('storage/' . $data['categoria_produto'][0]->loja->nome . '/imagens_produtos/' . $produto->imagem) }}"
                    class="rounded img-fluid mb-3" alt="{{$produto->nome}}">
            </div>
            <!-- FIM IMAGEM PRODUTO -->

            <!-- DESCRIÇÃO PRODUTO -->
            <div class="col-md-6">
                <p class="m-0 text-secondary">{{$produto->descricao}}</p>
                <p class="mb-3 fw-semibold"> R$ {{number_format($produto->preco, 2, ',', '.')}}</p>
                <hr>
                <!-- FORM PRODUTO OPCINAL -->
                <form
                    action="/adicionar-carrinho/{{$produto->id}}?loja_id={{$data['loja_id']}}&consumo_local_viagem_delivery={{$data['consumo_local_viagem_delivery']}}&endereco_selecionado={{$data['endereco_selecionado']}}"
                    method="post">
                    @csrf

                    <!-- CATEGORIAS DE OPCIONAIS -->
                    @foreach ($produto->categoria_opcional as $categoria_opcional)
                    <!-- CARD DE OPCIONAIS -->
                    <div class="bg-body-tertiary p-3 my-1">
                        <div class="row">
                            <h4 class="col-6 fw-bold fs-6 m-0">{{$categoria_opcional->nome}}</h4>
                            @if($categoria_opcional->is_required == true)
                            <div class="col-6">
                                <p class="bg-dark rounded text-white m-0 text-center fw-bold" style="font-size: 10px">
                                    OBRIGATÓRIO</p>
                            </div>
                            @endif
                        </div>

                        <!-- OPCIONAIS -->
                        @foreach($categoria_opcional->opcional_produto as $opcional)
                        <div class="row my-2">
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
                        @endforeach
                        <!-- FIM OPCIONAIS -->

                    </div>
                    <!-- FIM CARD DE OPCIONAIS -->

                    @endforeach
                    <!-- FIM CATEGORIAS DE OPCIONAIS -->


                    <div class="mt-2">
                        <label for="obsTextArea" class="form-label fw-semibold mt-3"><i class="fa-solid fa-message"></i>
                            Deseja adicionar alguma observação?</label>
                        <textarea class="form-control" placeholder="Ex.: Tirar picles, carne ao ponto..."
                            id="obsTextArea" name="observacao"></textarea>
                    </div>

                    <!-- QUANTIDADE E BTN AÇÃO FIXO BOTTOM -->
                    <div class="bg-white fixed-bottom p-3 shadow-lg d-flex w-100">
                        <div class="d-flex rounded px-3 py-1" style="background-color: #EDEDED">
                            <button type="button" id="decrement-btn" class="mr-1">
                                <span class="material-symbols-outlined fs-2 d-flex align-items-center fw-semibold" style="color: #FD0146 !important">
                                    remove
                                </span>
                            </button>
                            <input type="text" id="quantidade" name="quantidade" class="form-control" value="1" min="1">
                            <button type="button" id="increment-btn" class="ml-1">
                                <span class="material-symbols-outlined fs-2 d-flex align-items-center fw-semibold" style="color: #FD0146 !important">
                                    add
                                </span>
                            </button>
                        </div>
                        <div class="d-flex align-items-center justify-content-end mx-2 w-100">
                            <button type="submit" class="p-2 text-white fw-semibold rounded w-100" style="background-color: #FD0146 !important">
                                Adicionar
                            </button>
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