<x-app-layout>

    <div class="container">

        <!-- MENSAGENS -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- FIM MENSAGENS -->

        <!-- HEADER -->
        <div class="">
            <h2 class="my-3 fw-bolder fs-1">
                @if($varOperacao == "alterarValor")
                Alterar valor
                @elseif($varOperacao == "alterarVencimento")
                Alterar data de vencimento
                @endif
            </h2>
        </div>
        <!-- FIM HEADER -->

        <div class="bg-white rounded p-3 border">
            @if($varOperacao == "alterarValor")
            <form action="{{ route('parcela.updateValorParcela') }}" method="post">
            @elseif($varOperacao == "alterarVencimento")
            <form action="{{ route('parcela.updateVencimentoParcela') }}" method="post">
            @endif
                @csrf
                @method('PUT')

                @if($varOperacao == "alterarValor")
                <div class="col-2">
                    <label for="inputValor" class="form-label">
                        Valor
                    </label>
                    <input type="text" name="valor_parcela"
                        class="form-control @error('valor_parcela') is-invalid @enderror" id="inputValor">
                </div>

                <p class="text-secondary">
                    *O valor será alterado para todas parcelas selecionadas
                </p>
                @elseif($varOperacao == "alterarVencimento")
                <div class="col-2">
                    <label for="inputVencimento" class="form-label">
                        Vencimento da 1ª parcela
                    </label>
                    <input type="date" name="data_vencimento"
                        class="form-control @error('data_vencimento') is-invalid @enderror" id="inputVencimento">
                </div>
                @endif

                <div class="border rounded p-3 my-3">
                    <p class="fw-semibold">
                        {{count($parcelas)}} parcelas a serem alteradas:
                    </p>

                    <!-- PARCELAS -->
                    @foreach ($parcelas as $parcela)
                    <div class="row my-2">
                        <div class="col-md-1">
                            <label for="inputIdParcelas" class="form-label">ID</label>
                            <input type="text" name="" value="{{ $parcela[0]->id }}" readonly disabled
                                class="form-control" id="inputIdParcelas">
                            <input type="hidden" name="parcela_id[]" value="{{ $parcela[0]->id }}">
                        </div>
                        <div class="col-md-1">
                            <label for="" class="form-label">Nº parcela</label>
                            <input type="text" name="numero_parcela"
                                value="{{ $parcela[0]->numero_parcela }} / {{ $parcela[0]->lancamento->quantidade_parcela }}"
                                readonly disabled class="form-control" id="">
                        </div>
                        <div class="col-md-3">
                            <label for="" class="form-label">Categoria</label>
                            <input type="text" name="categoria"
                                value="{{ $parcela[0]->lancamento->categoria_financeiro->nome }}" readonly disabled
                                class="form-control" id="">
                        </div>
                        <div class="col-md-3">
                            <label for="inputDataVencimentoParcelas" class="form-label">
                                Data de vencimento
                            </label>
                            <input type="text" name="data_vencimento"
                                value="{{ \Carbon\Carbon::parse( $parcela[0]->data_vencimento )->format('d/m/Y') }}"
                                readonly disabled class="form-control" id="inputDataVencimentoParcelas">
                        </div>
                        <div class="col-md-3">
                            <label for="inputValorParcelas" class="form-label">Valor</label>
                            <input type="text" name="valor_parcela"
                                value="{{ number_format($parcela[0]->valor, 2, ',', '.') }}" readonly disabled
                                class="form-control" id="inputValorParcelas">
                        </div>
                    </div>

                    @endforeach
                    <!-- FIM PARCELAS -->

                </div>

                <div class="p-3 d-flex justify-content-end">
                    <button type="submit" class="btn bg-padrao text-white px-5 fw-semibold">
                        Salvar
                    </button>
                </div>

            </form>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        $(document).on('input', 'input[id^="inputValor"]', function() {
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