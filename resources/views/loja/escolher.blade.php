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

    <div class="container-padrao">

        <!-- LOJAS -->
        @if($lojas)

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
                    href="">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Cadastrar Loja
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        @foreach($lojas as $loja)

        <!-- CARD LOJA -->
        <div
            class="d-flex align-items-center border-3 bg-white p-3 rounded m-3 {{ session('lojaConectado') && session('lojaConectado')['id'] == $loja->id ? 'border-padrao' : '' }}">

            <!-- LOGO LOJA -->
            @if($loja->logo != null)
            <img src='{{asset("storage/$loja->nome/$loja->logo")}}' width="250px" class="rounded-circle">
            @else
            <img src='{{asset("storage/images/logo-black.png")}}' width="250px" class="rounded-circle">
            @endif
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
                @else
                <a href="{{route('loja')}}" class="btn bg-padrao fw-semibold text-white">
                    Ir para loja
                </a>
                @endif

            </div>
            <!-- FIM INFO LOJA -->

        </div>
        <!-- CARD LOJA -->

        @endforeach
        <!-- FIM LOJAS -->

        <!-- SE NÃO HOUVER LOJAS -->
        @else
        <div class="d-flex align-items-center justify-content-center">
            <div>
                <p class="m-0 fs-1 my-3 fw-regular">
                    Olá, <span class="fw-semibold">{{Auth::user()->name}}</span>
                </p>

                <p class="m-0 fs-3 my-3 fw-medium">
                    Vamos dar os primeiros passos e criar sua loja aqui?<br>
                    É bem rápido, menos de 5 minutos.
                </p>
                <div class="d-flex justify-content-center my-5">
                    <img src="{{asset("storage/images/criar-loja.svg")}}" width="300px" alt="Foomy">
                </div>
                <a href="{{ route('loja.create') }}" class="btn bg-padrao text-white fw-semibold w-100">
                    Criar loja
                </a>
            </div>

        </div>
        <!-- FIM SE NÃO HOUVER LOJAS -->

        @endif


    </div>
</x-app-layout>