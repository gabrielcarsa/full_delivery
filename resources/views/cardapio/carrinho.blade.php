<x-layout-cardapio>
    <div class="nav-produto d-flex p-0 fixed-top p-1 bg-light border shadow-sm">
        <div class="d-flex align-items-center">
            <a href="#" onclick="history.go(-1); return false;" class="btn btn-light rounded-circle"><i
                    class="fas fa-arrow-left"></i></a>
        </div>
        <div class="d-flex align-items-center justify-content-center text-center" style="flex: 1;">
            <h2 class="fs-5">Carrinho de Compras</h2>
        </div>
    </div>

    @if(empty($carrinho))
    <div class="d-flex justify-content-center align-items-center" style="padding-top: 70px;">
        <div class="m-5">
            <h3>Ops!</h3>
            <p>Parece que seu carrinho está vazio!</p>
            <a href="#" onclick="history.go(-1); return false;" class="btn btn-primary">Ir para cardápio</a>
        </div>
    </div>
    @else
    <div class="container">
        <div class="row" style="padding-top: 70px;">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        Itens no Carrinho
                    </div>
                    <div class="card-body">

                        <ul class="list-group">
                            @php
                            $valor_total = 0;
                            @endphp
                            @foreach($carrinho as $item)
                            @php
                            $valor_total += $item['produto']->preco;
                            @endphp
                            <li class="list-group-item">
                                <p class="m-0 p-0 text-truncate"><strong>1x</strong> {{$item['produto']->nome}}</p>
                                <p class="m-0 p-0 text-secondary text-truncate">{{$item['observacao']}}</p>
                                <p class="m-0 p-0 text-truncate">R$
                                    {{number_format($item['produto']->preco, 2, ',', '.')}}</p>

                                @if(!empty($item['opcionais']))
                                <div class="border p-1 rounded">
                                    @foreach($item['opcionais'] as $opcional)
                                    <p class="m-0 p-0 text-truncate text-secondary"> - {{$opcional->nome}} R$
                                        {{number_format($opcional->preco, 2, ',', '.')}}</p>
                                    @endforeach
                                </div>
                                @endif

                            </li>
                            @endforeach

                            <div class="mt-3">
                                <a href="{{ route('cardapio.esvaziarCarrinho') }}" class="btn btn-danger">Limpar
                                    carrinho</a>
                            </div>

                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="mt-3 fixed-bottom p-3 shadow-sm bg-light">
        <div class="">
            <a href="" class="btn btn-success">Adicionar R$
                {{number_format($valor_total, 2, ',', '.')}}</a>
        </div>
    </div>

    @endif

</x-layout-cardapio>