<x-app-layout>

    <div class="container">
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

        <!-- HEADER -->
        <div class="row">
            <div class="col">
                <h2 class="mt-3 fw-bolder fs-1">Selecione uma Loja</h2>
                <p class="m-0 text-secondary">
                    Para realizar as tarefas no sistema <span class="fw-bold">é necessário escolher uma loja para se
                        conectar</span>, visto que é possível ter mais de 1 Loja cadastrada no Foomy.
                </p>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn bg-padrao text-white m-0 py-1 px-5 fw-bold d-flex align-items-center justify-content-center"
                    href="{{route('loja.editar')}}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Cadastrar Loja
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->


        <!-- LOJAS -->
        @if($lojas)

        @foreach($lojas as $loja)

        <!-- CARD LOJA -->
        <div
            class="d-flex align-items-center border-3 bg-white p-3 rounded m-3 {{ session('lojaConectado') && session('lojaConectado')['id'] == $loja->id ? 'border-padrao' : '' }}">

            <!-- LOGO LOJA -->
            <img src='{{asset("storage/$loja->nome/$loja->logo")}}' width="250" alt="Logo {{$loja->nome}}"
                class="rounded-circle">
            <!-- FIM LOGO LOJA -->

            <!-- INFO LOJA -->
            <div class="mx-3 d-block">
                <!-- LOJA CIRCULO STATUS -->
                @if($loja->state == "OK" || $loja->state == "WARNING")
                <div class="d-flex align-items-center my-2">
                    <span class="material-symbols-outlined mr-1 text-success"
                        style="font-variation-settings: 'FILL' 1;">
                        check_circle
                    </span>
                    <p class="m-0 fw-semibold">
                        Loja aberta
                    </p>
                </div>

                @else
                <div class="d-flex align-items-center my-2">
                    <span class="material-symbols-outlined mr-1 text-danger" style="font-variation-settings: 'FILL' 1;">
                        error
                    </span>
                    <p class="m-0 fw-semibold">
                        Loja fechada
                    </p>
                </div>
                @endif
                <!-- FIM LOJA CIRCULO STATUS -->

                <h2 class="fs-2 fw-bold m-0">
                    {{$loja->nome}}
                </h2>

                <p class="text-secondary">
                    {{$loja->descricao}}
                </p>
                <p>
                    {{$loja->rua}}, {{$loja->numero}} -
                    {{$loja->bairro}}, {{$loja->cidade}} {{$loja->estado}}.
                    {{$loja->cep}}
                </p>

                @if(!session('lojaConectado') || session('lojaConectado')['id'] != $loja->id)
                <form action="{{route('loja.choose', ['id' => $loja->id])}}" method="post">
                    @csrf
                    <button type="submit" class="p-2 text-white fw-semibold rounded w-100 bg-padrao">
                        Escolher loja
                    </button>
                </form>
                @endif

            </div>
            <!-- FIM INFO LOJA -->

        </div>
        <!-- CARD LOJA -->

        @endforeach
        <!-- FIM LOJAS -->

        <!-- SE NÃO HOUVER LOJAS -->
        @else
        <div class="container-fluid mt-5 mb-5 d-flex flex-column align-items-center">
            <img src="{{asset("storage/images/logo.png")}}" width="150px" alt="Foomy"></a>
            <h3 class="fw-semibold fs-4 mt-4">Bem vindo! Vamos começar essa jornada com o Foomy?</h3>
            <p>Comece configurando as informações do seu loja!</p>
            <a href="{{route('loja.editar')}}" class="btn btn-primary px-5">Iniciar</a>
        </div>
        <!-- FIM SE NÃO HOUVER LOJAS -->

        @endif


    </div>
</x-app-layout>