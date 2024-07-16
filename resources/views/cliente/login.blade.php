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

            <p class="fs-5 fw-semibold">Entrar</p>

            <div class="d-flex my-3">
                <a href="" class="btn btn-outline-primary w-100">Google</a>
            </div>

            <hr>

            <!-- FORM -->
            <form action="{{ route('cliente.login') }}" method="post">
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
                    <button type="submit" class="btn btn-primary w-100 ">
                        Entrar
                    </button>
                </div>
            </form>
            <!-- FIM FORM -->

            <div class="row mt-3">
                <div class="col">
                    <a href="{{ route('cliente.register') }}" class="text-dark">Cadastre-se</a>
                </div>
                <div class="col">
                    <a href="" class="text-dark">Esqueceu senha</a>
                </div>
            </div>
        </div>
        <!-- FIM CARD LOGIN -->

    </div>
    <!-- FIM FUNDO -->

</x-layout-cardapio>