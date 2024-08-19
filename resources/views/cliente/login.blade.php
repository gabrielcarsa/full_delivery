<x-layout-cardapio>
    <!-- FUNDO -->
    <div class="d-flex align-items-center justify-content-center bg-light">

        <div class="row bg-white rounded m-3">

            <!-- TEXTO LOGIN -->
            <div class="col-sm-4 d-flex align-items-center justify-content-center rounded p-3 bg-padrao m-0">
                <div>
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $data['loja']->nome . '/' . $data['loja']->logo) }}"
                            class="rounded-circle" style="max-width: 40px;">
                    </div>
                    <h3 class="fs-2 fw-bold text-white">
                        Bem-vindo <br>
                        de volta!
                    </h3>
                    <p class="text-white fs-6 d-flex align-items-center mt-3">
                        <span class="material-symbols-outlined mr-1">
                            check_circle
                        </span>
                        Pedidos para entrega.
                    </p>
                    <p class="text-white fs-6 d-flex align-items-center">
                        <span class="material-symbols-outlined mr-1">
                            check_circle
                        </span>
                        Cupons de desconto e muito mais.
                    </p>
                    <p class="text-white fs-6 d-flex align-items-center">
                        <span class="material-symbols-outlined mr-1">
                            check_circle
                        </span>
                        Ofertas e preços exclusivos.
                    </p>
                </div>
            </div>
            <!-- FIM TEXTO LOGIN -->

            <div class="col-sm-8 d-flex align-items-center justify-content-center">
                <!-- CARD LOGIN -->
                <div class="card-login p-3">

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

                    <p class="fs-3 fw-bold text-center text-padrao">Entrar</p>

                    <!-- FORM -->
                    @if(isset($data))
                    <form
                        action="{{ route('cliente.login',  ['loja_id' => $data['loja_id'], 'consumo_local_viagem' => 3]) }}"
                        method="post">
                        @else
                        <form action="{{ route('cliente.login') }}" method="post">
                            @endif
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" id="floatingInput"
                                    placeholder="name@example.com">
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" name="password" class="form-control" id="floatingPassword"
                                    placeholder="Password">
                                <label for="floatingPassword">Senha</label>
                            </div>
                            <div class="d-flex mt-3">
                                <button type="submit" class="btn bg-padrao w-100 text-white fw-semibold">
                                    Entrar
                                </button>
                            </div>
                            
                            <p class="text-secondary my-3 text-center">
                                Ou entre com
                            </p>

                            <div class="d-flex my-3">
                                <a href="" class="btn btn-outline-primary w-100">Google</a>
                            </div>
                        </form>
                        <!-- FIM FORM -->

                        <a href="" class="fs-6 d-flex align-items-center text-decoration-none my-1">
                            <span class="material-symbols-outlined mr-1">
                                lock
                            </span>
                            Esqueceu senha
                        </a>
                        <a href="{{ route('cliente.register') }}"
                            class="fs-6 d-flex align-items-center text-decoration-none my-1">
                            <span class="material-symbols-outlined mr-1">
                                account_circle
                            </span>
                            Criar conta
                        </a>

                </div>
                <!-- FIM CARD LOGIN -->
            </div>
        </div>

    </div>
    <!-- FIM FUNDO -->

</x-layout-cardapio>