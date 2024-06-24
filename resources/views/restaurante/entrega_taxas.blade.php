<x-app-layout>

    <!-- CONTEUDO -->
    <div class="container">

        <!-- HEADER -->
        <h2 class="my-3 fw-bold fs-1">Taxas de Entrega</h2>
        <!-- FIM HEADER -->

        <!-- BODY -->

        <!-- SE HOUVER RESTAURANTE -->
        @if($restaurante != null)

        <!-- VERIFICAR QUAL OPÇÃO DE ENTREGA -->
        @if($restaurante->is_taxa_entrega_free == true )

        <!-- GRATUITA -->
        <div class="bg-white text-bg-light mb-3 p-3 rounded border" style="max-width: 18rem;">
            <div class="row">
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <span class="material-symbols-outlined fs-1 fw-bolder">
                        sports_motorsports
                    </span>
                </div>
                <div class="col-md-8">
                    <h5 class="card-title fw-bold fs-2 m-0 p-0">
                        R$ 0,00
                    </h5>
                    <p class="mb-1 p-0 text-secondary">
                        qualquer localidade
                    </p>
                </div>
            </div>
        </div>

        @elseif($restaurante->taxa_por_km_entrega != null)

        <!-- POR KM -->
        <div class="bg-white text-bg-light mb-3 p-3 rounded border" style="max-width: 18rem;">
            <div class="row">
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <span class="material-symbols-outlined fs-1 fw-bolder">
                        sports_motorsports
                    </span>
                </div>
                <div class="col-md-8">
                    <h5 class="card-title fw-bold fs-2 m-0 p-0">
                        R$ {{number_format($restaurante->taxa_por_km_entrega, 2, ',', '.')}}
                    </h5>
                    <p class="mb-1 p-0 text-secondary">
                        por km
                    </p>

                </div>
            </div>
        </div>

        @elseif($restaurante->taxa_entrega_fixa != null)

        <!-- TAXA FIXA -->
        <div class="bg-white text-bg-light mb-3 p-3 rounded border" style="max-width: 18rem;">
            <div class="row">
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <span class="material-symbols-outlined fs-1 fw-bolder">
                        sports_motorsports
                    </span>
                </div>
                <div class="col-md-8">
                    <h5 class="card-title fw-bold fs-2 m-0 p-0">
                        R$ {{number_format($restaurante->taxa_entrega_fixa, 2, ',', '.')}}
                    </h5>
                    <p class="mb-1 p-0 text-secondary">
                        qualquer localidade
                    </p>

                </div>
            </div>
        </div>

        @else

        <!-- ERRO -->
        <div class="card text-bg-light mb-3" style="max-width: 18rem;">
            <div class="card-header">Taxa de Entrega</div>
            <div class="card-body">
                <h5 class="card-title fw-bold fs-2">
                    ERRO
                </h5>
                <p class="card-text text-secondary">
                    Fale com o suporte.
                </p>
            </div>
        </div>

        @endif

        @endif

        <h6 class="fw-regular fs-4">Escolha outras opções de taxas de entrega:</h6>

        <div class="row">

            <!-- CARDS ENTREGA -->

            <div class="col-sm-3">
                <div class="bg-white p-3 text-center rounded shadow relative" style="height: 300px;">
                    <p class="text-secondary fs-6 m-0 p-0">taxa de entrega</p>
                    <h3 class="fw-bold">GRÁTIS</h3>
                    <div class="my-2">
                        <p>Entrega grátis para todas localidades.</p>

                        @if($restaurante->is_taxa_entrega_free != true)

                        <!-- BTN ACAO -->
                        <form action="{{ route('restaurante.taxa_entrega_free', ['id' => $restaurante->id]) }}"
                            method="POST">
                            @csrf
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary px-5 absolute bottom-0 mb-3">
                                    Escolher
                                </button>
                            </div>
                        </form>
                        <!-- FIM BTN -->

                        @else
                        <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                            <span class="material-symbols-outlined fs-1 fw-regular text-success">
                                check_circle
                            </span>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="bg-white p-3 text-center rounded shadow relative" style="height: 300px;">
                    <p class="text-secondary fs-6 m-0 p-0">taxa de entrega</p>
                    <h3 class="fw-bold">Por KM</h3>
                    <div class="my-2">
                        <p class="m-0">Valor da entrega será calculado</p>
                        <p class="fw-semibold m-0">
                            D x P
                        </p>
                        <p class="text-secondary fw-regular m-0" style="font-size:12px">
                            D: distância em km
                        </p>
                        <p class="text-secondary fw-regular m-0" style="font-size:12px">
                            P: Preço por km
                        </p>

                        @if($restaurante->taxa_por_km_entrega == null)

                        <!-- BTN ACAO -->
                        <form action="{{ route('restaurante.taxa_por_km_entrega', ['id' => $restaurante->id]) }}"
                            method="POST" class="my-2">
                            @csrf
                            <div class="form-floating mt-1">
                                <input type="text"
                                    class="form-control @error('taxa_por_km_entrega') is-invalid @enderror"
                                    id="inputTaxaPorKM" placeholder="1,00" name="taxa_por_km_entrega">
                                <label for="inputTaxaPorKM">Preço por km</label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary px-5 mt-2 absolute bottom-0 mb-3">
                                    Escolher
                                </button>
                            </div>
                        </form>
                        <!-- FIM BTN -->

                        @else
                        <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                            <span class="material-symbols-outlined fs-1 fw-regular text-success">
                                check_circle
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="bg-white p-3 text-center rounded shadow relative" style="height: 300px;">
                    <p class="text-secondary fs-6 m-0 p-0">taxa de entrega</p>
                    <h3 class="fw-bold">FIXA</h3>
                    <div class="my-2">
                        <p>Taxa de entrega fixa para todas localidades.</p>

                        @if($restaurante->taxa_entrega_fixa == null)

                        <!-- BTN ACAO -->
                        <form action="{{ route('restaurante.taxa_entrega_fixa', ['id' => $restaurante->id]) }}"
                            method="POST" class="my-2">
                            @csrf
                            <div class="form-floating mt-1">
                                <input type="text" class="form-control @error('taxa_entrega_fixa') is-invalid @enderror"
                                    id="inputTaxaFixa" placeholder="1,00" name="taxa_entrega_fixa">
                                <label for="inputTaxaFixa">Preço fixo</label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary px-5 mt-2 absolute bottom-0 mb-3">
                                    Escolher
                                </button>
                            </div>
                        </form>
                        <!-- FIM BTN -->

                        @else
                        <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                            <span class="material-symbols-outlined fs-1 fw-regular text-success">
                                check_circle
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- FIM SE HOUVER RESTAURANTE -->

        <!-- FIM BODY -->

    </div>
    <!-- FIM CONTEUDO -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        $(document).on('input', 'input[id^="inputTaxaPorKM"]', function() {
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

    $(document).ready(function() {
        $(document).on('input', 'input[id^="inputTaxaFixa"]', function() {
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