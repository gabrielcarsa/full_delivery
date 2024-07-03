<x-app-layout>

    <!-- CONTAINER -->
    <div class="container">

        <!-- HEADER -->
        <div class="row">
            <div class="col">
                <h2 class="my-3 fw-bolder fs-2">Criar cupom</span>
                </h2>
            </div>
        </div>
        <!-- FIM HEADER -->

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


        <!-- FORM -->
        <form class="row g-3" action="{{!empty($cupom) ? '/cupom/alterar/' . $cupom->id : '/cupom/cadastrar/'}}"
            method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @if(!empty($cupom))
            @method('PUT')
            @endif

            <div class="col-md-6 form-floating">
                <input type="text" class="form-control @error('codigo') is-invalid @enderror" name="codigo"
                    id="floatingInput" value="{{!empty($cupom) ? $cupom->codigo : old('codigo')}}" placeholder="TESTE10"
                    required>
                <label for="floatingInput" class="text-secondary fw-semibold">Código</label>
            </div>
            <div class="col-md-6 form-floating">
                <select class="form-select" id="tipo_desconto" name="tipo_desconto" aria-label="Tipo desconto"
                    required>
                    <option selected>Selecione uma opção</option>
                    <option value="1">Valor fixo</option>
                    <option value="2">Porcentagem</option>
                </select>
                <label for="tipo_desconto">Tipo de desconto</label>
            </div>

            <div class="col-md-4 form-floating">
                <input type="text" class="form-control @error('desconto') is-invalid @enderror" name="desconto"
                    id="floatingInput" value="{{!empty($cupom) ? $cupom->desconto : old('desconto')}}" placeholder="10"
                    required>
                <label for="floatingInput" class="text-secondary fw-semibold">Desconto</label>
            </div>
            <div class="col-md-4 form-floating">
                <input type="date" class="form-control @error('data_validade') is-invalid @enderror"
                    name="data_validade" id="floatingInput" required
                    value="{{!empty($cupom) ? $cupom->data_validade : old('data_validade')}}" placeholder="10/10/2025">
                <label for="floatingInput" class="text-secondary fw-semibold">Data de validade</label>
            </div>
            <div class="col-md-4 form-floating">
                <input type="number" class="form-control @error('limite_uso') is-invalid @enderror" name="limite_uso"
                    id="floatingInput" value="{{!empty($cupom) ? $cupom->limite_uso : old('limite_uso')}}"
                    placeholder="2">
                <label for="floatingInput" class="text-secondary fw-semibold">Limite de uso por usuário</label>
            </div>


            <div class="col-12 form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2"
                    style="height: 100px" name="descricao"></textarea>
                <label for="floatingTextarea2" class="text-secondary fw-semibold">Descrição</label>
            </div>


            <!-- BTN SUBMIT -->
            <div class="col-6"></div>
            <div class="col d-flex justify-content-end">
                <a href="" class="btn active w-100 mx-1">Voltar</a>
                <button type="submit" class="btn btn-primary w-100 mx-1">Cadastrar</button>

            </div>

        </form>
        <!-- FIM FORM -->

    </div>
    <!-- FIM CONTAINER -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        $(document).on('input', 'input[name^="desconto"]', function() {
            var selectedOption = $('#tipo_desconto').val();

            if (selectedOption == '1') { // Se o tipo de desconto for "Valor fixo"
                // Remova os caracteres não numéricos
                var unmaskedValue = $(this).val().replace(/\D/g, '');

                // Adicione a máscara apenas ao input de valor relacionado à mudança
                $(this).val(mask(unmaskedValue));
            }
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