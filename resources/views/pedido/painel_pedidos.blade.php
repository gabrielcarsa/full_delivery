<x-app-layout>

    <!-- PEDIDOS -->
    <div class="row m-0">

        <!-- MENU LATERAL PEDIDOS -->
        <div class="col-md-auto m-0 p-0" style="overflow-y: auto; overflow-x: hidden; height: 100vh">
            <div class="bg-white border-end m-0 p-3" style="max-width: 400px">

                <!-- HEADER -->
                <div class="p-0 m-0">
                    <div class="row">
                        <div class="col d-flex justify-content-center w100">
                            <a href="{{ route('pedido.novo') }}" class="btn btn-primary">
                                Simular pedido
                            </a>
                        </div>
                        <div class="col d-flex justify-content-center w100">
                            <a href="" class="btn btn-secondary">
                                Configurações
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col d-flex align-items-center">
                            <div class="dropdown">
                                <button class="btn btn-outline-dark dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Filtrar
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Pendentes</a></li>
                                    <li><a class="dropdown-item" href="#">Em preparo</a></li>
                                    <li><a class="dropdown-item" href="#">A caminho</a></li>
                                    <li><a class="dropdown-item" href="#">Concluido</a></li>
                                    <li><a class="dropdown-item" href="#">Rejeitado</a></li>
                                    <li><a class="dropdown-item" href="#">Cancelado</a></li>
                                </ul>
                            </div>
                            <div class="m-1">
                                <a href="" class="btn btn-primary d-flex align-items-center">
                                    <span class="material-symbols-outlined">
                                        search
                                    </span>
                                </a>

                            </div>
                        </div>
                        <div class="col fw-semibold fs-4 text-secondary d-flex align-items-center justify-content-end">
                            <p class="">
                                {{isset($data['pedidos']) ? $data['pedidos']->count() : '0'}}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- FIM HEADER -->

                <!-- MENU PEDIDOS -->
                <div>
                    @if(isset($data['pedidos']))

                    @foreach($data['pedidos'] as $pedido)

                    <!-- COLLAPSE PEDIDOS -->
                    <div class="bg-light rounded border m-2 {{isset($data['pedido']) && $data['pedido']->id == $pedido->id ? 'border-dark border-4' : '' }}">
                        @if($pedido->status == 0)
                        <div class="bg-warning m-0 p-0 text-center">
                            <p class="m-0 p-0 fw-bold">PENDENTE</p>
                        </div>
                        @elseif($pedido->status == 1)

                        @elseif($pedido->status == 2)

                        @elseif($pedido->status == 3)

                        @elseif($pedido->status == 4)

                        @elseif($pedido->status == 5)

                        @endif
                        <p class="text-secondary fs-6 px-2 m-0"># {{$pedido->id}}</p>

                        <!-- HEADER COLLAPSE PEDIDOS -->
                        <div class="row px-2">
                            <div class="col-md-8">
                                <h4 class="fw-bold fs-4">{{$pedido->cliente->nome}}</h4>
                            </div>
                            <div class="col-md-4 d-flex justify-content-end">
                                <p>{{\Carbon\Carbon::parse($pedido->data_pedido)->format('H:i')}}</p>
                            </div>
                        </div>
                        <!-- FIM HEADER COLLAPSE PEDIDOS -->

                        <!-- CORPO COLLAPSE PEDIDOS -->
                        <div class="text-secondary fw-medium px-2">
                            @if($pedido->consumo_local_viagem_delivery == 1)
                            <p class="p-0 m-0">
                                Consumo no local
                            </p>

                            @elseif($pedido->consumo_local_viagem_delivery == 2)
                            <p class="p-0 m-0">
                                Para viagem
                            </p>

                            @elseif($pedido->consumo_local_viagem_delivery == 3)
                            <p class="p-0 m-0">
                                {{$pedido->entrega->rua}},
                                {{$pedido->entrega->bairro}},
                                {{$pedido->entrega->numero}}
                            </p>

                            @endif
                            <p class="p-0 m-0">{{$pedido->forma_pagamento_entrega->forma}}</p>
                        </div>
                        <!-- FIM CORPO COLLAPSE PEDIDOS -->

                        <!-- BTN COLLAPSE PEDIDOS -->
                        <div class="row m-3">
                            <a href="{{route('pedido.show', ['id' => $pedido->id])}}" class="btn btn-primary">Ver
                                detalhes</a>
                        </div>

                    </div>

                    @endforeach

                    @endif

                </div>
                <!-- FIM MENU PEDIDOS -->

            </div>
        </div>
        <!-- FIM MENU LATERAL PEDIDOS -->

        <!-- CONTEUDO PEDIDOS -->
        <div class="col m-0 p-3" style="overflow-y: auto; overflow-x: hidden; height: 100vh">
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

            <!-- PEDIDO DETALHE -->
            @if(isset($data['pedido']))
            <x-show-pedido :pedido="$data['pedido']" />
            @endif

        </div>
        <!-- FIM CONTEUDO PEDIDOS -->

    </div>

    <!-- FIM PEDIDOS -->

</x-app-layout>