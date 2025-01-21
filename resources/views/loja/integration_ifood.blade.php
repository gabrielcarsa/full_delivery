<x-app-layout>

    <!-- MENSAGENS -->
    @if(session('success'))
    <x-toasts-message type="success" message="{{ session('success') }}" />
    @endif

    @if(session('error'))
    <x-toasts-message type="danger" message="{{ session('error') }}" />
    @endif

    @if($errors->any())
    @foreach ($errors->all() as $error)
    <x-toasts-message type="danger" message="{{ $error }}" />
    @endforeach
    @endif
    <!-- FIM MENSAGENS -->

    <!-- CARD -->
    <div class="container-padrao">

        <!-- STEP 1 -->
        @if(!request('step'))

        <!-- LINHA -->
        <div class="row my-auto">

            <!-- COLUNA -->
            <div class="col-md-6">

                <div class="card my-auto p-3">

                    <p class="fw-bold text-secondary fs-4">
                        Etapa 1 de 2
                    </p>

                    <p class="fw-bold m-0 fs-4">
                        1. Clique <a target="blanck" href="{{$userCode['verificationUrlComplete']}}">aqui</a> para
                        ativar aplicativo por
                        código.
                    </p>
                    <p class="m-0">
                        Caso o link não funcione acesse: <span class="fw-bold">{{$userCode['verificationUrlComplete']}}
                        </span>e digite o código <span class="fw-bold">{{$userCode['userCode']}}</span>.
                    </p>
                    <p class="m-0 text-secondary">
                        Lembrando que esse código expira em 10min.
                    </p>
                    <hr>
                    <p class="fw-bold m-0 fs-4">
                        2. Clique no botão "Autorizar"
                    </p>
                    <p class="m-0">
                        Dessa forma, será autorizado a nossa plataforma a ter acesso á alguns dados da API do iFood para
                        integração entre
                        as plataformas funcionar.
                    </p>

                    <!-- FORM -->
                    <form class="my-3"
                        action="{{route('loja.store_integration_ifood', ['authorization_code_verifier' => $userCode['authorizationCodeVerifier']])}}"
                        method="post">
                        @csrf
                        <div class="my-3">
                            <x-button class="">
                                Próximo passo
                            </x-button>
                        </div>
                    </form>
                    <!-- FIM FORM -->

                </div>

            </div>
            <!-- FIM COLUNA -->

            <!-- COLUNA -->
            <div class="col-md-6">

                <img src='{{asset("storage/images/permitir-aplicativo-ifood.png")}}' class="w-100 mx-auto rounded">

            </div>
            <!-- FIM COLUNA -->

        </div>
        <!-- FIM LINHA -->


        <!-- STEP 2 -->
        @elseif(request('step') && request('step') == 2)

        <!-- LINHA -->
        <div class="row my-auto">

            <!-- COLUNA -->
            <div class="col-md-6">

                <div class="card my-auto p-3">

                    <p class="fw-bold text-secondary fs-4">
                        Etapa 2 de 2
                    </p>

                    <!-- FORM -->
                    <form class="row my-3"
                        action="{{route('loja.store_integration_ifood', ['step' => 2, 'authorization_code_verifier' => request('authorization_code_verifier')])}}"
                        method="post">
                        @csrf

                        <div class="col-12">
                            <x-label for="authorization_code" value="Código de autorização" />
                            <x-input placeholder="Ex.: AAAA-AAAA" id="authorization_code" type="text"
                                name="authorization_code" :value="old('authorization_code')" autofocus
                                autocomplete="off" />
                        </div>
                        <p class="text-secondary">
                            Cole aqui o código copiado do portal do parceiro.
                        </p>
                        <div class="col-sm-6 my-3">
                            <a class="btn btn-secondary w-100" href="{{route('loja.create_integration_ifood')}}">
                                Voltar
                            </a>
                        </div>
                        <div class="col-sm-6 my-3">
                            <x-button class="">
                                Finalizar
                            </x-button>
                        </div>
                    </form>
                    <!-- FIM FORM -->

                </div>

            </div>
            <!-- FIM COLUNA -->

            <!-- COLUNA -->
            <div class="col-md-6">

                <img src='{{asset("storage/images/codigo-autorizacao-ifood.png")}}' class="w-100 mx-auto rounded">

            </div>
            <!-- FIM COLUNA -->

        </div>
        <!-- FIM LINHA -->

        @endif

    </div>
    <!-- FIM CARD -->
</x-app-layout>