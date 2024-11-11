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
            <form action="" method="post">
                @csrf

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

                <div class="border rounded p-3 my-3 text-center">
                    <p class="fw-semibold">
                        Parcelas a serem alteradas:
                    </p>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Loja</th>
                                <th scope="col">Nº</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Data de vencimento</th>
                                <th scope="col">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- PARCELAS -->
                            @foreach ($parcelas as $parcela)
                            <tr>
                                <td>{{$parcela[0]->id}}</td>
                                <td>{{$parcela[0]->lancamento->loja->nome}}</td>
                                <td>{{$parcela[0]->numero_parcela}} de {{$parcela[0]->lancamento->quantidade_parcela}}
                                </td>
                                <td>{{$parcela[0]->lancamento->categoria_financeiro->nome }}</td>
                                <td>{{\Carbon\Carbon::parse($parcela[0]->data_vencimento)->format('d/m/Y') }}</td>
                                <td>R$ {{number_format($parcela[0]->valor, 2, ',', '.')}}</td>
                            </tr>
                            @endforeach
                            <!-- FIM PARCELAS -->
                        </tbody>
                    </table>
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