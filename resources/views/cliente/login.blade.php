<x-layout-cardapio>
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

                <div class="mb-3 d-flex justify-content-center">
                    <img src="{{ asset('storage/' . $data['loja']->nome . '/' . $data['loja']->logo) }}"
                        class="rounded-circle" style="max-width: 100px;">
                </div>

                <p class="fs-2 fw-bold m-0">
                    Bem vindo de volta
                </p>
                <p class="text-secondary mt-0 mb-3">
                    Entre novamente na sua conta para ter acesso ao mundo {{$data['loja']->nome}}.
                </p>

                <!-- FORM -->
                @if(isset($data))
                <form
                    action="{{ route('cliente.login',  ['loja_id' => $data['loja_id'], 'consumo_local_viagem_delivery' => 3]) }}"
                    method="post">
                    @else
                    <form action="{{ route('cliente.login') }}" method="post">
                        @endif

                        @csrf
                        <div class="form-floating mb-3 mt-5">
                            <input type="phone" name="telefone" class="form-control" id="inputTelefone"
                                placeholder="(DD) 9999-9999" required>
                            <label for="inputTelefone">Telefone</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" name="password" class="form-control" id="floatingPassword"
                                placeholder="Password" required>
                            <label for="floatingPassword">Senha</label>
                        </div>
                        <a href="" class="text-decoration-none text-padrao d-flex justify-content-end">
                            Esqueceu sua senha?
                        </a>

                        <div class="d-flex mt-5">
                            <button type="submit"
                                class="btn bg-padrao w-100 text-white fw-semibold p-2 rounded rounded-pill">
                                Entrar
                            </button>
                        </div>
                        <p class="mt-3 text-secondary text-center">
                            Não tem conta? <a href="{{ route('cliente.register') }}" class="text-padrao">Cadastre-se</a>
                        </p>

                        <hr>
                        <p class="col m-0 text-dark text-center">
                            Ou entre com
                        </p>

                        <div class="d-flex my-3">
                            <a href="" class="text-padrao p-3 fs-1 border rounded rounded-circle shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                    class="bi bi-google" viewBox="0 0 16 16">
                                    <path
                                        d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z" />
                                </svg>
                            </a>
                        </div>
                    </form>
                    <!-- FIM FORM -->
            </div>
        </div>

    </div>

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