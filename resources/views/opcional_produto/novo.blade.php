<x-app-layout>

    <!-- CONTAINER -->
    <div class="container">

        <!-- TITULO -->
        <h2 class="my-3 fw-bolder fs-3">
            {{ empty($opcional) ? 'Cadastro Opcional de "'.$categoria_opcional->nome . '"': 'Alterar '.$opcional->nome }}
        </h2>
        <!-- FIM TITULO -->


        <!-- MENSAGENS SUCESSO OU ERRO-->
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
        <!-- FIM MENSAGENS SUCESSO OU ERRO-->

        <!-- FORM -->
        <form class="col-6"
            action="{{!empty($opcional) ? '/opcional_produto/alterar/' . Auth::user()->id . '/' . $opcional->id : '/opcional_produto/cadastrar/' . $categoria_opcional->id . '/' . Auth::user()->id}}"
            method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @if(!empty($opcional))
            @method('PUT')
            @endif

            <!-- CAMPOS -->
            <div class="m-1">
                <label for="inputNome" class="form-label">Nome</label>
                <input type="text" name="nome" value="{{!empty($opcional) ? $opcional->nome : old('nome')}}"
                    class="form-control" id="inputNome" maxlength="100" required>
            </div>
            <div class="m-1">
                <label for="inputDescricao" class="form-label">Descrição</label>
                <input type="text" name="descricao"
                    value="{{!empty($opcional) ? $opcional->descricao : old('descricao')}}" class="form-control"
                    id="inputDescricao" maxlength="500" required>
            </div>
            <div class="m-1">
                <label for="inputPreco" class="form-label">Preço</label>
                <input type="text" name="preco"
                    value="{{!empty($opcional) ? number_format($opcional->preco, 2, ',', '.') : old('preco')}}"
                    class="form-control" id="inputPreco" required>
            </div>

            <div class="col-12 d-flex mt-3">
                <button type="submit" class="btn btn-primary w-100">
                    Cadastrar
                </button>
            </div>
        </form>
        <!-- FIM FORM -->

    </div>
    <!-- FIM CONTAINER -->


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