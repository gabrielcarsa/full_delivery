<x-app-layout>

    <div class="container-padrao">

        <!-- LOJAS -->
        @if($stores)

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


        @foreach($stores as $store)

        <!-- CARD LOJA -->
        <div
            class="d-flex align-items-center border-3 bg-white p-3 rounded m-3 {{ session('selected_store') && session('selected_store')['id'] == $store->id ? 'border-padrao' : '' }}">

            <!-- LOGO LOJA -->
            @if($store->logo != null)
            <img src='{{asset("storage/$store->nome/$store->logo")}}' width="250px" class="rounded-circle">
            @else
            <img src='{{asset("storage/images/logo-black.png")}}' width="250px" class="rounded-circle">
            @endif
            <!-- FIM LOGO LOJA -->

            <!-- INFO LOJA -->
            <div class="mx-3 d-block">
                <!-- LOJA CIRCULO STATUS -->
                @if($store->state == "OK" || $store->state == "WARNING")
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
                    {{$store->name}}
                </h2>

                <p class="text-secondary">
                    {{$store->description}}
                </p>
                <p>
                    {{$store->street}}, {{$store->number}} -
                    {{$store->neghborhood}}, {{$store->city}} {{$store->state}}.
                    {{$store->zip_code}}
                </p>

                @if(!session('selected_store') || session('selected_store')['id'] != $store->id)
                <form action="{{route('store.select', ['id' => $store->id])}}" method="post">
                    @csrf
                    <button type="submit" class="p-2 text-white fw-semibold rounded w-100 bg-padrao">
                        Escolher loja
                    </button>
                </form>
                @else
                <a href="{{route('store.show', ['store' => $store->id])}}" class="btn bg-padrao fw-semibold text-white">
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
        <div class="row g-3 my-auto">

            <div class="col-md-4 my-auto">

                <p class="m-0 fs-1 m-0 fw-bold">
                    Olá, <span class="text-padrao">{{Auth::user()->name}}</span>
                </p>

                <p class="m-0 fw-medium">
                    Vamos dar os primeiros passos e criar sua loja aqui? É bem simples, vamos preencher as informações
                    abaixo:
                </p>
                <ul class="my-3">
                    <li class="d-flex my-1">
                        <span class="rounded-circle px-2 mr-2 bg-clear text-white fw-bold">
                            1
                        </span>
                        <p class="m-0 fw-light">
                            Informações básicas
                        </p>
                    </li>
                    <li class="d-flex my-1">
                        <span class="rounded-circle px-2 mr-2 bg-clear text-white fw-bold">
                            2
                        </span>
                        <p class="m-0 fw-light">
                            Contato
                        </p>
                    </li>
                    <li class="d-flex my-1">
                        <span class="rounded-circle px-2 mr-2 bg-clear text-white fw-bold">
                            3
                        </span>
                        <p class="m-0 fw-light">
                            Localização
                        </p>
                    </li>
                    <li class="d-flex my-1">
                        <span class="rounded-circle px-2 mr-2 bg-clear text-white fw-bold">
                            4
                        </span>
                        <p class="m-0 fw-light">
                            Taxas
                        </p>
                    </li>
                </ul>
                <p class="m-0 fw-medium">
                    Não vai levar 5 minutos!
                </p>
                <a href="{{ route('store.create') }}" class="btn bg-padrao text-white fw-semibold w-100 my-3 shadow">
                    Criar loja
                </a>
            </div>
            <div class="col-md-8 px-5">
                <img src="https://img.freepik.com/fotos-gratis/vista-lateral-homem-sentado-na-mesa_23-2149930931.jpg?t=st=1738087488~exp=1738091088~hmac=a4efcdf1cd98c817d0b06928409f1de7531e577b89a214aa7cf662071981c6a3&w=740"
                    alt="" class="w-100 rounded-5 shadow">
            </div>


        </div>
        <!-- FIM SE NÃO HOUVER LOJAS -->

        @endif

    </div>


</x-app-layout>