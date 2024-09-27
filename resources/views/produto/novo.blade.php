<x-app-layout>

    <div class="container">
        <!-- TITULO -->
        <div class="my-3">
            <h2 class="m-0 fw-bolder fs-2 text-black">
                @if(!empty($produto))
                Alterar produto
                @else
                Cadastro de produto
                @endif
            </h2>
        </div>
        <!-- FIM TITULO -->

        <!-- MENSAGENS -->
        <div class="toast-container position-fixed top-0 end-0">
            @if(session('success'))
            <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true">
                <div class="d-flex align-items-center p-3">
                    <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
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

        <form class="row g-3"
            action="{{!empty($produto) ? '/produto/alterar/' . Auth::user()->id . '/' . $produto->id : '/produto/cadastrar/' . $categoria->id . '/' . Auth::user()->id}}"
            method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @if(!empty($produto))
            @method('PUT')
            @endif

            @if(empty($produto))
            <div class="input-group mb-0">
                <label class="input-group-text" for="inputImagem">Imagem</label>
                <input type="file" class="form-control" name="imagem" id="inputImagem" required>
            </div>
            <p class="fs-6 text-secondary m-0 pl-1">Imagem deve ser quadrada e ser jpeg,png ou jpg</p>
            @endif

            <div class="col-md-6">
                <label for="inputNome" class="form-label">Nome</label>
                <input type="text" name="nome" value="{{!empty($produto) ? $produto->nome : old('nome')}}"
                    class="form-control" id="inputNome" maxlength="100" placeholder="Ex.: X-Salada" required>
            </div>
            <div class="col-md-6">
                <label for="inputDescricao" class="form-label">Descrição</label>
                <input type="text" name="descricao"
                    value="{{!empty($produto) ? $produto->descricao : old('descricao')}}" class="form-control"
                    id="inputDescricao" maxlength="500" placeholder="Ex.: Delícioso sanduíche com 150g de carne..." required>
            </div>
            <div class="col-md-5">
                <label for="inputPreco" class="form-label">Preço</label>
                <input type="text" name="preco"
                    value="{{!empty($produto) ? number_format($produto->preco, 2, ',', '.') : number_format(old('preco'), 2, ',', '.') }}"
                    class="form-control" id="inputPreco" required>
            </div>
            <div class="col-md-4">
                <label for="inputTipoDisponibilidade" id="disponibilidade" class="form-label">Disponibilidade</label>
                <select id="inputTipoDisponibilidade" name="disponibilidade" class="form-select form-control">
                    <option value="1" {{!empty($produto) && $produto->disponibilidade == 1 ? 'select' : ''}}>
                        Dísponivel</option>
                    <option value="0" {{!empty($produto) && $produto->disponibilidade == 0 ? 'select' : ''}}>Não
                        dísponivel</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="inputQtdPessoa" class="form-label">Serve quantas pessoas?</label>
                <input type="number" name="quantidade_pessoa"
                    value="{{ !empty($produto) ? $produto->quantidade_pessoa : (old('quantidade_pessoa') != null ? old('quantidade_pessoa') : '1') }}"
                    class="form-control" id="inputQtdPessoa" min="1" required>
            </div>

            <div class="col-md-3">
                <label for="inputTempoPreparoMin" class="form-label">
                    Tempo de preparo mínimo (minutos)
                </label>
                <input type="number" name="tempo_preparo_min_minutos"
                    value="{{ !empty($produto) ? $produto->tempo_preparo_min_minutos : (old('tempo_preparo_min_minutos') != null ? old('tempo_preparo_min_minutos') : '1') }}"
                    class="form-control" id="inputTempoPreparoMin" placeholder="Em minutos" required>
            </div>
            <div class="col-md-3">
                <label for="inputTempoPreparoMin" class="form-label">
                    Tempo de preparo máximo (minutos)
                </label>
                <input type="number" name="tempo_preparo_max_minutos"
                    value="{{ !empty($produto) ? $produto->tempo_preparo_max_minutos : (old('tempo_preparo_max_minutos') != null ? old('tempo_preparo_max_minutos') : '1') }}"
                    class="form-control" id="inputTempoPreparoMin" placeholder="Em minutos" required>
            </div>

            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn bg-padrao text-white fw-semibold px-5">
                    Salvar
                </button>
            </div>
        </form>

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