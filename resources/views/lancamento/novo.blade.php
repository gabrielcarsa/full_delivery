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
                {{$varPagarOuReceber == 0 ? 'Nova conta a pagar' : 'Nova conta a receber'}}
            </h2>
        </div>
        <!-- FIM HEADER -->

        <div class="bg-white rounded p-3 border">
            <form action="{{ route('lancamento.store', ['varPagarOuReceber' => $varPagarOuReceber == 0 ? 0 : 1]) }}"
                method="post" autocomplete="off">
                @csrf
                <!-- LINHA -->
                <div class="row">
                    <div class="col-4">
                        <label for="inputLojas" class="form-label">
                            Loja
                        </label>
                        <select id="inputLojas" name="loja_id" class="form-select form-control">
                            <option value="1" select>
                                -- Selecione --
                            </option>
                            @if($data['lojas'] != null)
                            @foreach($data['lojas'] as $loja)
                            <option value="{{$loja->id}}">
                                {{$loja->nome}}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="inputClientesFornecedores" class="form-label">
                            {{$varPagarOuReceber == 0 ? 'Fornecedor' : 'Cliente'}}
                        </label>
                        <select id="inputClientesFornecedores" name="cliente_fornecedor_id"
                            class="form-select form-control">
                            <option value="1" select>
                                -- Selecione --
                            </option>

                            <!-- VERIFICANDO CLIENTE OU FORNCEDOR -->
                            @if($varPagarOuReceber == 0)

                            <!-- FORNECEDOR -->
                            @if($data['fornecedores'] != null)
                            @foreach($data['fornecedores'] as $fornecedor)
                            <option value="{{$fornecedor->id}}">
                                {{$fornecedor->nome}}
                            </option>
                            @endforeach
                            @endif

                            @else

                            <!-- CLIENTE -->
                            @if($data['clientes'] != null)
                            @foreach($data['clientes'] as $cliente)
                            <option value="{{$cliente->id}}">
                                {{$cliente->nome}}
                            </option>
                            @endforeach
                            @endif

                            @endif
                            <!-- FIM VERIFICANDO CLIENTE OU FORNCEDOR -->

                        </select>
                    </div>
                    <div class="col-4">
                        <label for="inputCategoria" class="form-label">
                            Categoria
                        </label>
                        <select id="inputCategoria" name="categoria_financeiro_id" class="form-select form-control">
                            <option value="1" select>
                                -- Selecione --
                            </option>
                            @if($data['categorias'] != null)
                            @foreach($data['categorias'] as $categoria)
                            <option value="{{$categoria->id}}">
                                {{$categoria->nome}}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                </div>
                <!-- FIM LINHA -->

                <!-- LINHA -->
                <div class="row my-3">
                    <div class="col-4">
                        <label for="inputDescricao" class="form-label">
                            Descrição
                        </label>
                        <input type="text" name="descricao"
                            class="form-control @error('descricao') is-invalid @enderror" id="inputDescricao">
                    </div>
                    <div class="col-2">
                        <label for="inputQtndParcela" class="form-label">
                            Quantidade de parcelas
                        </label>
                        <input type="text" name="quantidade_parcela"
                            class="form-control @error('quantidade_parcela') is-invalid @enderror"
                            id="inputQtndParcela">
                    </div>
                    <div class="col-2">
                        <label for="inputVencimento" class="form-label">
                            Vencimento da 1ª parcela
                        </label>
                        <input type="date" name="data_vencimento"
                            class="form-control @error('data_vencimento') is-invalid @enderror" id="inputVencimento">
                    </div>
                    <div class="col-2">
                        <label for="inputValor" class="form-label">
                            Valor
                        </label>
                        <input type="text" name="valor_parcela"
                            class="form-control @error('valor_parcela') is-invalid @enderror" id="inputValor">
                    </div>
                    <div class="col-2">
                        <label for="inputValor" class="form-label">
                            Valor da entrada
                        </label>
                        <input type="text" name="valor_entrada"
                            class="form-control @error('valor_entrada') is-invalid @enderror" id="inputValor">
                    </div>
                </div>
                <!-- FIM LINHA -->

                <div class="p-3 d-flex justify-content-end sticky-bottom">
                    <button type="submit" class="btn bg-padrao text-white px-5 fw-semibold">
                        Salvar
                    </button>
                </div>

                <div class="m-3 border p-3 rounded">
                    <p>
                        Observações
                    </p>
                    <p class="text-secondary m-0">
                        - O campo "Valor da entrada" é opcional e serve para quando existe uma conta com uma entrada com
                        valor diferente do valor das parcelas. Ex.: Entrada de R$ 200 e 9 parcelas de R$ 100.
                    </p>
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