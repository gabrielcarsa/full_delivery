<x-layout-cardapio>
    <!-- NAVBAR -->
    <div class="d-flex bg-white fixed-top p-2">
        <a href="#" onclick="history.go(-1); return false;"
            class="text-dark text-decoration-none d-flex align-items-center m-0">
            <span class="material-symbols-outlined">
                arrow_back
            </span>
        </a>
        <div class="d-flex align-items-center justify-content-center" style="flex: 1;">
            <h2 class="fs-5 fw-semibold">
                Criar conta
            </h2>
        </div>
    </div>
    <!-- FIM NAVBAR -->

    <!-- FUNDO -->
    <div class="bg-light">
        <div class="vh-100 container d-flex align-items-center justify-content-center">

            <div>
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

                <p class="fs-2 fw-bold m-0">
                    Crie sua conta
                </p>
                <p class="text-secondary mt-0 mb-3">
                    É rápido, fácil, simples e você terá acesso a todos os nossos benefícios.
                </p>


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
                        <button type="submit"
                            class="btn bg-padrao w-100 text-white fw-semibold p-2 rounded rounded-pill">
                            Cadastrar
                        </button>
                    </div>
                </form>
                <!-- FIM FORM -->
            </div>

        </div>
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