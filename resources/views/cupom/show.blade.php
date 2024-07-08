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
                <h2 class="my-3 fw-bolder fs-1">{{$cupom->codigo}}</span>
                </h2>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- CARDS -->
        <div class="row">
            <div class="col">
                <div class="bg-white rounded border p-3">
                    <h3 class="fw-bold">{{$cupom->usos}}</h3>
                    <p class="p-0 m-0 text-secondary">usos</p>
                </div>
            </div>
            <div class="col">
                <div class="bg-white rounded border p-3">
                    @php
                    $total_desconto = 0;
                    @endphp

                    @foreach($cupom->uso_cupom->pluck('pedido') as $pedido)

                    @if($cupom->tipo_desconto == 1)
                    @php
                    $total_desconto += $cupom->desconto;
                    @endphp

                    @elseif($cupom->tipo_desconto == 2)
                    @php
                    $total_desconto += ($pedido->total_sem_desconto * $cupom->desconto) / 100;
                    @endphp

                    @endif
                    @endforeach
                    <h3 class="fw-bold">R$ {{number_format($total_desconto, 2, ',', '.')}}</h3>
                    <p class="p-0 m-0 text-secondary">valor total de desconto concedido</p>
                </div>
            </div>
        </div>
        <!-- FIM CARDS -->

        <!-- TABLE -->
        @if(isset($cupom->uso_cupom))

        <table class="table table-padrao border-top table align-middle my-3">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Valor pago</th>
                    <th scope="col">Valor do desconto</th>
                    <th scope="col">Data do uso</th>
                </tr>
            </thead>
            <tbody>
                <!-- CUPONS -->
                @foreach ($cupom->uso_cupom as $uso_cupom)
                <tr>
                    <td>{{$uso_cupom->id}}</td>
                    <td>{{$uso_cupom->cliente->nome}}</td>
                    <td>{{number_format($uso_cupom->pedido->total, 2, ',', '.')}}</td>
                    @if($pedido->uso_cupom->cupom->tipo_desconto == 1)
                    <td class="text-danger">
                        R$ {{ number_format($pedido->uso_cupom->cupom->desconto, 2, ',', '.') }}
                    </td>
                    @else
                    <td class="text-danger">
                        R$ {{ number_format(($pedido->total_sem_desconto * $cupom->desconto) / 100, 2, ',', '.') }}
                    </td>
                    @endif
                    <td>{{\Carbon\Carbon::parse($uso_cupom->data_uso)->format('d/m/Y')}}</td>
                </tr>
                @endforeach
                <!-- FIM CUPONS -->

            </tbody>
        </table>
        @endif

        <!-- FIM TABLE -->

    </div>

</x-app-layout>