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
                Baixar parcela
            </h2>
        </div>
        <!-- FIM HEADER -->

        <div class="bg-white rounded p-3 border">

            <form action="" method="post">
                @csrf
                @method('PUT')

                <div class="border rounded p-3 my-3">
                    <p class="fw-semibold">
                        {{count($parcelas)}} parcelas a serem baixadas:
                    </p>

                    <!-- TABELA PARCELAS -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col" class="col-1">ID</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Data Vencimento</th>
                                <th scope="col">Valor pago/recebido</th>
                                <th scope="col">Data pag./rec.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($parcelas))
                            @foreach($parcelas as $index => $parcela)

                            <tr class="">
                                <th scope="row">
                                    <input type="text" name="" value="{{ $parcela[0]->id }}" readonly disabled
                                        class="form-control">
                                    <input type="hidden" name="parcela_id[]" value="{{ $parcela[0]->id }}">
                                </th>
                                <th scope="row">
                                    <input type="text" name="valor"
                                        value="{{ number_format($parcela[0]->valor, 2, ',', '.') }}" readonly disabled
                                        class="form-control">
                                </th>
                                <th scope="row">
                                    <input type="text" name="data_vencimento"
                                        value="{{ \Carbon\Carbon::parse( $parcela[0]->data_vencimento )->format('d/m/Y') }}"
                                        readonly disabled class="form-control">
                                </th>
                                <th scope="row">
                                    <input type="text" name="valor_pago[]" id="inputValorPago"
                                        value="{{ old('valor_pago.' . $index) != null ?  old('valor_pago.' . $index) : '' }}"
                                        class="form-control @error('valor_pago.' . $index) is-invalid @enderror">
                                </th>
                                <th scope="row">
                                    <input type="date" name="data[]"
                                        value="{{ old('data.' . $index) != null ?  old('data.' . $index) : '' }}"
                                        class="form-control @error('data.' . $index) is-invalid @enderror">
                                </th>
                            </tr>

                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <!-- FIM TABELA PARCELAS -->

                </div>

                <div class="row row-form-destacar">
                    <div class="col-md-4">
                        <label for="inputTitularConta" class="form-label">Conta corrente</label>
                        <select id="inputTitularConta" name="titular_conta_id" class="form-select form-control">
                            <option value="0" {{ old('titular_conta_id') == 0 ? 'selected' : '' }}>-- Selecione --
                            </option>
                            @foreach ($data['titular_conta'] as $t)
                            <option value="{{ $t->id_titular_conta }}"
                                {{ old('titular_conta_id') == $t->id_titular_conta ? 'selected' : '' }}>
                                @if(empty($t->nome))
                                {{$t->razao_social}}
                                @else
                                {{$t->nome}}
                                @endif
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="inputParcial" class="form-label">Baixa parcial? </label>
                        <input id="inputParcial" type="checkbox" name="baixa_parcial">
                    </div>
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
        $(document).on('input', 'input[id^="inputValorPago"]', function() {
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