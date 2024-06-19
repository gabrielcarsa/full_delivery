<x-app-layout>
    <!-- Card Consulta -->
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 fw-semibold fs-5">{{$produto->nome}} - Promoção</h2>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="row">
                <div class="d-flex mb-3">
                    <div class="card text-bg-light">
                        <div class="card-header">Dica</div>
                        <div class="card-body">
                            <p class="card-text">
                                - O preço inserido aqui vai ser o preço de compra desde produto, logo, o preço colocado
                                anteriormente apenas servirá como referência e não será exercido.
                            </p>
                            <p class="card-text">
                                - Para tirar da promoção basta zerar e salvar.
                            </p>
                        </div>
                    </div>
                </div>
                <form action="{{'/produto/promocao/' . $produto->id}}" method="post" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2 mx-1">
                        <div class="col-5 border rounded p-3 mx-1">
                            <p class="form-label">Preço Original</p>
                            <p class="fw-bold fs-3">R$ {{number_format($produto->preco, 2, ',', '.')}}</p>
                            </div>
                        <div class="col-5 border rounded p-3 mx-1">
                            <label for="inputPrecoPromocao" class="form-label">Preço com desconto</label>
                            <input type="text" name="preco_promocao"
                                value="{{!empty($produto->preco_promocao) ? number_format($produto->preco_promocao, 2, ',', '.') : old('preco_promocao')}}"
                                class="form-control" id="inputPrecoPromocao" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary px-5">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        $(document).on('input', 'input[id^="inputPrecoPromocao"]', function() {
            // Remova os caracteres não numéricos
            var unmaskedValue = $(this).val().replace(/\D/g, '');

            // Adicione a máscara apenas ao input de valor relacionado à mudança
            $(this).val(mask(unmaskedValue));
        });

        function mask(value) {
            // Converte o valor para número
            var numberValue = parseFloat(value) / 100;

            // Formata o número com vírgula como separador decimal e duas casas decimais
            return numberValue.toLocaleString('pt-BR', {
                minimumFractionDigits: 2
            });
        }
    });
    </script>
</x-app-layout>