<x-app-layout>

    <div class="container">

        <!-- MENSAGENS -->
        <div class="toast-container position-fixed top-0 end-0">
            @if(session('success'))
            <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true">
                <div class="d-flex align-items-center p-3">
                    <span class="material-symbols-outlined fs-1 text-success" style="font-variation-settings:'FILL' 1;">
                        check_circle
                    </span>
                    <div class="toast-body">
                        <p class="fs-5 m-0">
                            {{ session('success') }}
                        </p>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            @endif
            @if (session('error'))
            <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true">
                <div class="d-flex align-items-center p-3">
                    <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                        error
                    </span>
                    <div class="toast-body">
                        <p class="fs-5 m-0">
                            {{ session('error') }}
                        </p>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            @endif
            @if ($errors->any())
            <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true">
                <div class="d-flex align-items-center p-3">
                    <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                        error
                    </span>
                    <div class="toast-body">
                        @foreach ($errors->all() as $error)
                        <p class="fs-5 m-0">
                            {{ $error }}
                        </p>
                        @endforeach
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            @endif
        </div>
        <!-- FIM MENSAGENS -->

        <!-- HEADER -->
        <div class="d-flex align-items-center justify-content-between">
            <div class="">
                <h2 class="my-3 fw-bolder fs-1">
                    Movimentações
                </h2>
            </div>
            <div class="d-flex justify-content-end">
                <a class="btn border-padrao text-padrao mr-1" href="" id="adicionarMovimentacao">
                    Nova linha
                </a>
                <a class="btn border-padrao text-padrao" href="" id="removerMovimentacao">
                    Remover linha
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- CARD -->
        <div class="bg-white rounded shadow-sm p-3 my-3">

            <!-- BODY -->
            <div class="card-body">
                <p class="fw-semibold">
                    Cadastrar em massa movimentações
                </p>

                <!-- FORM -->
                <form action="{{ route('movimentacao.store') }}" method="post" autocomplete="off">
                    @csrf

                    <!-- LINHA -->
                    <div class="row bg-gray-100 p-3 rounded">
                        <div class="col-md-4">
                            <label for="inputData" id="data" class="form-label">Data da movimentação*</label>
                            <input type="date" name="data" value="{{ old('data') }}" required
                                class="form-control @error('data') is-invalid @enderror" id="inputData">
                        </div>
                        <div class="col-md-4">
                            <label for="inputLoja" class="form-label">Loja</label>
                            <input type="text" name="" readonly disabled id="inputLoja" value="{{$dados['loja']->nome}}"
                                class="form-control">
                            <input type="hidden" name="loja_id" value="{{$dados['loja']->id}}">
                        </div>
                        <div class="col-md-4">
                            <label for="inputContaCorrente" class="form-label">Conta corrente</label>
                            <select id="inputContaCorrente" name="conta_corrente_id" class="form-select form-control">
                                <option value="0" {{ old('conta_corrente_id') == 0 ? 'selected' : '' }}>-- Selecione --
                                </option>
                                @foreach ($dados['contas_corrente'] as $conta)
                                <option value="{{ $conta->id }}"
                                    {{ old('conta_corrente_id') == $conta->id ? 'selected' : '' }}>
                                    {{$conta->nome}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- FIM LINHA -->

                    <!-- LINHA -->
                    <div class="row my-3 movimentacao">

                        <div class="col-md-1">
                            <label for="inputTipoMovimentacao" id="tipo_movimentacao" class="form-label">Tipo*</label>
                            <select id="inputTipoMovimentacao" required name="movimentacoes[0][tipo_movimentacao]"
                                class="form-select form-control">
                                <option value="0" select>-- Selecione --</option>
                                <option value="1">Saída</option>
                                <option value="2">Entrada</option>
                            </select>
                        </div>

                        <div class="col-md-2" id="categoriaField">
                            <label for="inputCliente" class="form-label">
                                Categoria
                            </label>
                            <select id="inputCliente" required name="movimentacoes[0][categoria_financeiro_id]"
                                class="form-select form-control @error('categoria_financeiro_id') is-invalid @enderror">
                                <option value="0" {{ old('categoria_financeiro_id') == 0 ? 'selected' : '' }}>
                                    -- Selecione --
                                </option>
                                @foreach ($dados['categorias'] as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ old('categoria_financeiro_id') == $categoria->id ? 'selected' : '' }}>
                                    {{$categoria->nome}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 cliente-container">
                            <label for="inputCliente" class="form-label">
                                Cliente
                            </label>
                            <select id="inputCliente" required name="movimentacoes[0][cliente_id]"
                                class="form-select form-control @error('cliente_id') is-invalid @enderror">
                                <option value="0" {{ old('cliente_id') == 0 ? 'selected' : '' }}>
                                    -- Selecione --
                                </option>
                                @foreach ($dados['clientes'] as $cliente)
                                <option value="{{ $cliente->id }}"
                                    {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                    {{$cliente->nome}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 fornecedor-container">
                            <label for="inputFornecedor" class="form-label">
                                Fornecedor
                            </label>
                            <select id="inputFornecedor" required name="movimentacoes[0][fornecedor_id]"
                                class="form-select form-control @error('fornecedor_id') is-invalid @enderror">
                                <option value="0" {{ old('fornecedor_id') == 0 ? 'selected' : '' }}>
                                    -- Selecione --
                                </option>
                                @foreach ($dados['fornecedores'] as $fornecedor)
                                <option value="{{ $fornecedor->id }}"
                                    {{ old('fornecedor_id') == $fornecedor->id ? 'selected' : '' }}>
                                    {{$fornecedor->nome}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="inputDescricao" id="descricao" class="form-label">Descrição</label>
                            <input type="text" name="movimentacoes[0][descricao]" value="{{ old('descricao') }}"
                                class="form-control @error('descricao') is-invalid @enderror" id="inputDescricao">
                        </div>
                        <div class="col-md-2">
                            <label for="inputValor" id="valor" class="form-label">Valor</label>
                            <input type="text" name="movimentacoes[0][valor]" required value="{{ old('valor') }}"
                                class="form-control @error('valor') is-invalid @enderror" id="inputValor">
                        </div>

                    </div>
                    <!-- FIM LINHA -->

                    <div class="col-12">
                        <button type="submit" class="btn bg-padrao text-white fw-semibold">
                            Cadastrar
                        </button>
                    </div>
                </form>
                <!-- FORM -->

            </div>
            <!-- FIM BODY -->

        </div>
        <!-- FIM CARD -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
    $(document).ready(function() {

        //Dependendo do tipo da movimentação exibir Cliente ou Fornecedor
        $(document).on('change', 'select[name^="movimentacoes"][name$="[tipo_movimentacao]"]', function() {
            var selectedType = $(this).val(); // Valor selecionado (1 ou 2)
            var parentRow = $(this).closest('.movimentacao'); // Encontra a linha atual

            // Mostra/oculta os campos de cliente e fornecedor com base no tipo selecionado
            if (selectedType == '2') { // Entrada
                parentRow.find('.cliente-container').show();
                parentRow.find('.fornecedor-container').hide();
            } else if (selectedType == '1') { // Saída
                parentRow.find('.fornecedor-container').show();
                parentRow.find('.cliente-container').hide();
            } else {
                // Se nenhuma opção válida for selecionada, esconde ambos
                parentRow.find('.cliente-container, .fornecedor-container').hide();
            }
        });

        // Garante o estado inicial correto ao carregar a página ou adicionar novas linhas
        $('select[name^="movimentacoes"][name$="[tipo_movimentacao]"]').trigger('change');

        // Formatar campo valor em dinheiro com pontos e virgulas dos valores movimentações
        $(document).on('input', 'input[name^="movimentacoes["][name$="[valor]"]', function() {
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

        // Adiciona uma nova linha de movimentação ao clicar em "+"
        $(document).on('click', '#adicionarMovimentacao', function(e) {
            e.preventDefault();

            // Clona a div de movimentação
            var novaMovimentacao = $('.movimentacao:first').clone();

            // Limpa os valores dos campos clonados
            novaMovimentacao.find('input, select').val('');

            // Incrementa os índices dos campos clonados para garantir que o Laravel os interprete como um array
            novaMovimentacao.find('[name^="movimentacoes"]').each(function() {
                var newName = $(this).attr('name').replace(/\[\d+\]/, '[' + $('.movimentacao')
                    .length + ']');
                $(this).attr('name', newName);
            });

            // Adiciona a nova div de movimentação no final do formulário
            $('.movimentacao:last').after(novaMovimentacao);
        });

        // Remove a linha de movimentação ao clicar no botão de exclusão
        $(document).on('click', '#removerMovimentacao', function(e) {
            e.preventDefault(); // Impede o comportamento padrão do link
            // Verifique se há mais de uma linha de movimentação antes de remover
            if ($('.movimentacao').length > 1) {
                // Remova a última linha de movimentação
                $('.movimentacao:last').remove();
            } else {
                // Caso contrário, limpe os valores da última linha
                $('.movimentacao:last input, .movimentacao:last select').val('');
            }
        });
    });
    </script>

</x-app-layout>