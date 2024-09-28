<x-layout-cardapio>

    <!-- FUNDO -->
    <div class="vh-100 d-flex align-items-center justify-content-center bg-light">

        <!-- CARD LOGIN -->
        <div class="bg-white p-3 rounded border" style="width: 350px;">

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
            <p class="fs-5 fw-semibold">Registrar</p>

            <!-- FORM -->
            <form method="POST" action="{{ route('cliente.register') }}">
                @csrf
                <div class="form-floating my-1">
                    <input type="text" name="nome" class="form-control" id="floatingInput"
                        placeholder="name@example.com" autocomplete="off"
                        value="{{!empty($cliente) ? $cliente->nome : old('nome')}}">
                    <label for="floatingInput">Nome</label>
                </div>
                <div class="form-floating my-1">
                    <input type="phone" name="telefone" class="form-control" id="inputTelefone"
                        placeholder="name@example.com" autocomplete="off"
                        value="{{!empty($cliente) ? $cliente->telefone : old('telefone')}}">
                    <label for="inputTelefone">Telefone</label>
                </div>
                <div class="form-floating my-1">
                    <input type="password" name="senha" class="form-control" id="floatingPassword"
                        placeholder="Password" autocomplete="off">
                    <label for="floatingPassword">Senha</label>
                </div>
                <div class="form-floating my-1">
                    <input type="password" name="senha_confirmation" class="form-control" id="floatingPassword"
                        placeholder="Password" autocomplete="off">
                    <label for="floatingPassword">Confirmar senha</label>
                </div>
                <div class="d-flex mt-3">
                    <button type="submit" class="btn btn-primary w-100 ">
                        Cadastrar
                    </button>
                </div>
            </form>
            <!-- FIM FORM -->

        </div>
        <!-- FIM CARD LOGIN -->

    </div>
    <!-- FIM FUNDO -->

    <script>

    // Função para aplicar a máscara de telefone
    function aplicarMascaraTelefone(inputId) {
        const input = document.getElementById(inputId);

        input.addEventListener('input', function(e) {
            let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
            let formattedValue = '';

            if (value.length > 0) {
                formattedValue = '(' + value.slice(0, 2);

                if (value.length > 2) {
                    formattedValue += ') ' + value.slice(2, 7);
                }

                if (value.length > 7) {
                    formattedValue += '-' + value.slice(7, 11);
                }
            }

            input.value = formattedValue;
        });
    }
    // Aplicar a máscara para os campos de telefone
    aplicarMascaraTelefone('inputTelefone');

    </script>

</x-layout-cardapio>