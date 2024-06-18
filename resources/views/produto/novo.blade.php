<x-app-layout>

    <!-- Dropdown Card -->
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 fw-semibold fs-5">Cadastro de Produto</h2>
        </div>
        <!-- Card Body -->
        <div class="card-body">
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

            <form class="row g-3"
                action="{{!empty($produto) ? '/produto/alterar/' . Auth::user()->id . '/' . $produto->id : '/produto/cadastrar/' . $categoria->id . '/' . Auth::user()->id}}"
                method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                @if(!empty($produto))
                @method('PUT')
                @endif

                @if(empty($produto))
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputImagem">Imagem</label>
                    <input type="file" class="form-control" name="imagem" id="inputImagem" required>
                </div>
                @endif

                <div class="col-md-6">
                    <label for="inputNome" class="form-label">Nome</label>
                    <input type="text" name="nome" value="{{!empty($produto) ? $produto->nome : old('nome')}}"
                        class="form-control" id="inputNome" maxlength="100" required>
                </div>
                <div class="col-md-6">
                    <label for="inputDescricao" class="form-label">Descrição</label>
                    <input type="text" name="descricao"
                        value="{{!empty($produto) ? $produto->descricao : old('descricao')}}" class="form-control"
                        id="inputDescricao" maxlength="500" required>
                </div>
                <div class="col-md-4">
                    <label for="inputPreco" class="form-label">Preço</label>
                    <input type="text" name="preco" value="{{!empty($produto) ? number_format($produto->preco, 2, ',', '.') : old('preco')}}"
                        class="form-control" id="inputPreco" required>
                </div>
                <div class="col-md-2">
                    <label for="inputTipoDisponibilidade" id="disponibilidade"
                        class="form-label">Disponibilidade</label>
                    <select id="inputTipoDisponibilidade" name="disponibilidade" class="form-select form-control">
                        <option value="1" {{!empty($produto) && $produto->disponibilidade == 1 ? 'select' : ''}}>
                            Dísponivel</option>
                        <option value="0" {{!empty($produto) && $produto->disponibilidade == 0 ? 'select' : ''}}>Não
                            dísponivel</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="inputQtdPessoa" class="form-label">Serve quantas pessoas?</label>
                    <input type="number" name="quantidade_pessoa"
                        value="{{ !empty($produto) ? $produto->quantidade_pessoa : (old('quantidade_pessoa') != null ? old('quantidade_pessoa') : '1') }}"
                        class="form-control" id="inputQtdPessoa" min="1" required>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        $(document).on('input', 'input[id^="inputPreco"]', function() {
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