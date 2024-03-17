<x-app-layout>

    <!-- Dropdown Card -->
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 fw-semibold fs-5">Cadastro Opcional de {{ $produto->nome }}</h2>
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
                action="{{!empty($opcional) ? '/opcional_produto/alterar/' . Auth::user()->id . '/' . $opcional->id : '/opcional_produto/cadastrar/' . $produto->id . '/' . Auth::user()->id}}"
                method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                @if(!empty($opcional))
                @method('PUT')
                @endif

                <div class="col-md-6">
                    <label for="inputNome" class="form-label">Nome</label>
                    <input type="text" name="nome" value="{{!empty($opcional) ? $opcional->nome : old('nome')}}"
                        class="form-control" id="inputNome" maxlength="100" required>
                </div>
                <div class="col-md-6">
                    <label for="inputDescricao" class="form-label">Descrição</label>
                    <input type="text" name="descricao"
                        value="{{!empty($opcional) ? $opcional->descricao : old('descricao')}}" class="form-control"
                        id="inputDescricao" maxlength="500" required>
                </div>
                <div class="col-md-4">
                    <label for="inputPreco" class="form-label">Preço</label>
                    <input type="text" name="preco"
                        value="{{!empty($opcional) ? number_format($opcional->preco, 2, ',', '.') : old('preco')}}"
                        class="form-control" id="inputPreco" required>
                </div>
                <div class="col-md-8">
                    <div class="card text-bg-info" style="width: 100%;">
                        <div class="card-header">Dica</div>
                        <div class="card-body">
                            <h5 class="card-title">Opcionais</h5>
                            <p class="card-text">
                                Estudos mostram que na hora de comprar um produto se houver opcionais com preços que
                                impliquem benefícios para o cliente ele tem grande tendência a comprar o opcional do que
                                comprar separadamente o mesmo produto com mesmo valor.
                            </p>
                        </div>
                    </div>
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