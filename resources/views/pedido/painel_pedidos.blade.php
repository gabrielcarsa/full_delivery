<x-app-layout>

    <!-- PEDIDOS -->
    <div class="row">

        <!-- MENU LATERAL PEDIDOS -->
        <div class="col-md-4">
            <div class="bg-white border-end m-0 p-2" style="max-width: 400px">

                <!-- HEADER -->
                <div class="p-0 m-0">
                    <div class="row">
                        <div class="col d-flex justify-content-center w100">
                            <a href="{{ route('pedido.novo') }}" class="btn btn-warning">
                                Simular pedido
                            </a>
                        </div>
                        <div class="col d-flex justify-content-center w100">
                            <a href="" class="btn btn-secondary">
                                Configurações
                            </a>
                        </div>
                    </div>
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

                <!-- OPÇÃO PEDIDOS -->
                @if(isset($data['pedidos']))

                @foreach($data['pedidos'] as $pedido)

                <!-- COLLAPSE PEDIDOS PENDENTES -->
                <div class="bg-light rounded shadow-sm p-2 m-2">
                    <p class="text-secondary fs-6 p-0 m-0"># {{$pedido->id}}</p>
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="fw-bold fs-4">{{$pedido->cliente}}</h4>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
                            <p>{{\Carbon\Carbon::parse($pedido->data_pedido)->format('H:i')}}</p>
                        </div>
                    </div>
                    <div class="text-secondary fw-medium">
                        <p class="p-0 m-0">{{$pedido->rua}}, {{$pedido->bairro}}, {{$pedido->numero}}</p>
                        <p class="p-0 m-0">{{$pedido->forma_pagamento}}</p>
                    </div>
                    <div class="row m-3">
                        <a href="{{route('pedido.show', ['id' => $pedido->id])}}" class="btn btn-primary">Ver detalhes</a>
                    </div>
                </div>

                @endforeach

                @endif

            </div>
        </div>
        <!-- FIM MENU LATERAL PEDIDOS -->

        <!-- CONTEUDO PEDIDOS -->
        <div class="col-md-8">
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
            <x-show-pedido :pedido="$data['pedido']"/>
            @endif
            
        </div>
        <!-- FIM CONTEUDO PEDIDOS -->

    </div>

    <!-- FIM PEDIDOS -->

</x-app-layout>