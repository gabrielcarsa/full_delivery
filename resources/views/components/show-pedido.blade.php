<!-- INFORMAÇÕES -->

<div class="row px-3">
    <div class="col">
        <p class="m-0 d-flex align-items-center text-uppercase">
            <span class="material-symbols-outlined mr-1 fs-5 text-secondary" style="font-variation-settings: 'FILL' 1;">
                person
            </span>
            @if($pedido->cliente_id != null)
            {{$pedido->cliente->nome}}
            @else
            {{$pedido->nome_cliente}}
            @endif
        </p>
    </div>
    <div class="col">
        @if($pedido->cliente_id != null)
        <p class="m-0 d-flex align-items-center">
            <span class="material-symbols-outlined mr-1 fs-5 text-secondary" style="font-variation-settings: 'FILL' 1;">
                call
            </span>
            {{$pedido->cliente->telefone}}
        </p>
        @endif
    </div>
</div>

<div class="px-3">
    <!-- CONSUMO -->
    @if($pedido->consumo_local_viagem_delivery == 1)
    <p class="m-0 d-flex align-items-center">
        <span class="material-symbols-outlined mr-1 fs-5 text-secondary" style="font-variation-settings: 'FILL' 1;">
            table_restaurant
        </span>
        Mesa {{$pedido->mesa->nome}}
    </p>

    @elseif($pedido->consumo_local_viagem_delivery == 2)
    <p class="m-0 d-flex align-items-center">
        <span class="material-symbols-outlined mr-1 fs-5 text-secondary" style="font-variation-settings: 'FILL' 1;">
            shopping_bag
        </span>
        Para viagem
    </p>

    @elseif($pedido->consumo_local_viagem_delivery == 3)
    <p class="m-0 d-flex align-items-center">
        <span class="material-symbols-outlined mr-1 fs-5 text-secondary" style="font-variation-settings: 'FILL' 1;">
            two_wheeler
        </span>
        {{$pedido->entrega->rua}} {{$pedido->entrega->numero}},
        {{$pedido->entrega->bairro}}, {{$pedido->entrega->cidade}}/{{$pedido->entrega->estado}}.
        {{$pedido->entrega->complemento}}
    </p>
    @endif
    <!-- FIM CONSUMO -->
</div>

@if($pedido->consumo_local_viagem_delivery == 3)
<p class="m-0 px-3 d-flex align-items-center">
    <span class="material-symbols-outlined mr-1 fs-5 text-secondary" style="font-variation-settings: 'FILL' 1;">
        calendar_clock
    </span>
    Previsão de entrega: 18:10 - 18:25
</p>
@endif

<p class="m-0 px-3 d-flex align-items-center">
    <span class="material-symbols-outlined mr-1 fs-5 text-secondary" style="font-variation-settings: 'FILL' 1;">
        schedule
    </span>
    Recebido em
    {{\Carbon\Carbon::parse($pedido->feito_em)->format('d/m/Y')}} -
    {{\Carbon\Carbon::parse($pedido->feito_em)->format('H:i')}}
</p>
<!-- FIM INFORMAÇÕES -->

<!-- PAGAMENTO -->
@if($pedido->consumo_local_viagem_delivery == 3)
<div class="bg-white rounded border p-3 my-2">
    <p class="fw-bolder fs-5 m-0 p-0">Pagamento</p>
    <div class="">

        <!-- FORMA PAGAMENTO -->
        @if($pedido->forma_pagamento_loja->id != null)
        <p class="p-0 m-0 fs-6">
            Cobrar do cliente na entrega <strong>R$ {{number_format($pedido->total, 2, ',', '.')}} no
                {{$pedido->forma_pagamento_loja->nome}}</strong>
        </p>
        <p class="text-secondary m-0 p-0">
            O entregador deve cobrar esse valor no ato da entrega.
        </p>

        @else
        <p class="p-0 m-0">
            Cliente pagou via site/app <strong>R$ {{number_format($pedido->total, 2, ',', '.')}} no
                {{$pedido->forma_pagamento_foomy->nome}}</strong>
        </p>
        @endif

        <!-- FIM FORMA PAGAMENTO -->

    </div>
</div>
@endif

<!-- FIM PAGAMENTO -->

<!-- PEDIDO -->
<div class="bg-white rounded border p-3 my-2">
    <div class="d-flex align-items-center justify-content-between">
        <p class="fw-bolder fs-5 m-0 p-0">Pedido</p>

        <!-- STATUS -->
        @if($pedido->status == 0)
        <p class="border border-danger text-danger py-1 px-2 rounded-pill m-0">
            Pendente
        </p>

        @elseif($pedido->status == 1)
        <p class="bg-warning py-1 px-2 rounded-pill m-0">
            Em preparo
        </p>

        @elseif($pedido->status == 2)
        <p class="bg-primary py-1 px-2 rounded-pill m-0 text-white">
            A caminho
        </p>

        @elseif($pedido->status == 3)
        <p class="bg-success py-1 px-2 rounded-pill m-0 text-white">
            Concluído
        </p>

        @elseif($pedido->status == 4)
        <p class="bg-danger py-1 px-2 rounded-pill m-0 text-white">
            Rejeitado
        </p>

        @elseif($pedido->status == 5)
        <p class="bg-secondary py-1 px-2 rounded-pill m-0 text-white">
            Cancelado
        </p>

        @endif
        <!-- FIM STATUS -->
    </div>

    <div class="px-3 py-1 m-2">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Qtnd</th>
                    <th scope="col">Item</th>
                    <th scope="col">Unidade</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>

            <tbody>
                <!-- Variáveis PHP -->
                @php
                $total_sem_entrega = 0;
                $isset_opcionais = false;
                @endphp

                <!-- Exibir itens do pedido -->
                @foreach ($pedido->item_pedido as $item)

                <!-- Incrementando sobre valor total -->
                @php
                $total_sem_entrega += $item->subtotal;
                @endphp


                <tr class="p-0 m-0">
                    <td class="bg-white {{$item->situacao == 1 ? 'text-decoration-line-through text-secondary' : '' }}">
                        <span class="d-flex align-items-center">
                            @if($item->quantidade >= 2)
                            <a class="d-flex align-items-center bg-padrao text-decoration-none rounded-circle"
                                href="{{ route('pedido.remover_quantidade', ['item_id' => $item->id, 'pedido_id' => $pedido->id]) }}">
                                <span class="material-symbols-outlined text-white fs-6 fw-bold">
                                    remove
                                </span>
                            </a>
                            @endif
                            <span class="mx-2">
                                {{ $item->quantidade }}x
                            </span>
                            <a class="d-flex align-items-center bg-padrao text-decoration-none rounded-circle"
                                href="{{ route('pedido.adicionar_quantidade', ['item_id' => $item->id, 'pedido_id' => $pedido->id]) }}">
                                <span class="material-symbols-outlined text-white fs-6 fw-bold">
                                    add
                                </span>
                            </a>
                        </span><br>
                    </td>
                    <td class="bg-white {{$item->situacao == 1 ? 'text-decoration-line-through text-secondary' : '' }}">
                        <span class="fw-bold">
                            {{ $item->produto->nome }}
                        </span>
                        <!-- OBSERVAÇÃO -->
                        @if($item->observacao != null)
                        <p class="m-0" style="font-size: 14px;">
                            Obs.: {{$item->observacao}}
                        </p>
                        @endif
                        <!-- FIM OBSERVAÇÃO -->
                    </td>
                    <td class="bg-white {{$item->situacao == 1 ? 'text-decoration-line-through text-secondary' : '' }}">
                        <span>
                            R$ {{number_format($item->preco_unitario, 2, ',', '.')}}
                        </span>
                    </td>
                    <td class="bg-white {{$item->situacao == 1 ? 'text-decoration-line-through text-secondary' : '' }}">
                        <span>
                            R$ {{number_format($item->subtotal, 2, ',', '.')}}
                        </span>
                    </td>
                    <td class="bg-white">
                        <div class="dropdown">
                            <a class="btn d-flex align-items-center ml-2" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">
                                    more_vert
                                </span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item text-danger" data-bs-toggle="modal"
                                        data-bs-target="#exluirItemModal{{$item->id}}">
                                        Excluir item
                                    </a>
                                </li>
                            </ul>
                            <!-- MODAL EXCLUIR -->
                            <div class="modal fade" id="exluirItemModal{{$item->id}}" tabindex="-1"
                                aria-labelledby="exluirItemModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <p class="modal-title fs-5" id="exluirItemModalLabel">
                                                Excluir {{$item->produto->nome}}?
                                            </p>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                Esse produto tem {{$item->quantidade}} quantidade(s), todas
                                                quantidades serão excluídas.
                                            </p>
                                            <p>Essa ação é irreversível! Tem certeza?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn border-padrao text-padrao"
                                                data-bs-dismiss="modal">
                                                Não
                                            </button>
                                            <a href="{{ route('pedido.deletar_item', ['item_id' => $item->id, 'pedido_id' => $pedido->id]) }}"
                                                class="btn bg-padrao text-white fw-semibold">
                                                Sim, eu tenho
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- MODAL EXCLUIR -->
                        </div>
                    </td>
                </tr>

                <!--VERIFICAR SE EXISTE OPCIONAIS -->
                @foreach ($item->produto->categoria_opcional as $categoria_opcional)

                <!-- VERIFICAR SE EXISTE ALGUM OPCIONAL RELACIONADO A ESTA CATEGORIA -->
                @php

                // Filtra os opcionais do item_pedido que pertencem à categoria atual
                $opcionais_relacionados = $item->opcional_item->
                filter(function($opcional_item) use ($categoria_opcional) {
                return $categoria_opcional->opcional_produto->contains('id',$opcional_item->opcional_produto_id);
                });
                if($opcionais_relacionados->isNotEmpty()){
                $isset_opcionais = true;
                }
                @endphp

                @endforeach
                <!-- FIM VERIFICAR SE EXISTE OPCIONAIS -->

                @if($isset_opcionais == true)
                <tr style="font-size:14px">
                    <td></td>
                    <td></td>
                    <td>

                        <!-- CATEGORIAS DE OPCIONAIS -->
                        @foreach ($item->produto->categoria_opcional as $categoria_opcional)

                        <!-- VERIFICAR SE EXISTE ALGUM OPCIONAL RELACIONADO A ESTA CATEGORIA -->
                        @php

                        // Filtra os opcionais do item_pedido que pertencem à categoria atual

                        $opcionais_relacionados = $item->opcional_item->filter(function($opcional_item) use
                        ($categoria_opcional) {
                        return $categoria_opcional->opcional_produto->contains('id',
                        $opcional_item->opcional_produto_id);
                        });

                        @endphp

                        @if($opcionais_relacionados->isNotEmpty())
                        <p class="col-6 fw-bold m-0 text-secondary">{{$categoria_opcional->nome}}</p>

                        <!-- OPCIONAIS -->
                        @foreach($opcionais_relacionados as $opcional_item)

                        <!-- VERIFICAR OPCIONAIS -->
                        @php
                        // Obter os detalhes do opcional_produto relacionado
                        $opcional_produto = $categoria_opcional->opcional_produto->firstWhere('id',
                        $opcional_item->opcional_produto_id);
                        @endphp

                        <p class="m-0 text-secondary">
                            {{$opcional_produto->nome}}
                        </p>

                        <!-- Incrementando sobre valor total -->
                        @php
                        $total_sem_entrega += $opcional_item->preco_unitario * $item->quantidade;
                        @endphp
                        @endforeach
                        <!-- FIM OPCIONAIS -->
                        @endif

                        @endforeach
                        <!-- FIM CATEGORIAS DE OPCIONAIS -->

                    </td>
                    <td>
                        <!-- CATEGORIAS DE OPCIONAIS -->
                        @foreach ($item->produto->categoria_opcional as $categoria_opcional)
                        <!-- OPCIONAIS -->
                        @foreach($categoria_opcional->opcional_produto as $opcional)

                        <!-- VERIFICAR OPCIONAIS -->
                        @php
                        // Verifica se o opcional está relacionado ao item_pedido
                        $opcional_item = $item['opcional_item']->firstWhere('opcional_produto_id', $opcional->id);
                        @endphp

                        @if($opcional_item)
                        <p class="text-secondary">
                            + R$ {{number_format($opcional->preco, 2, ',', '.')}}
                        </p>
                        @endif

                        @endforeach
                        <!-- FIM OPCIONAIS -->

                        @endforeach
                        <!-- FIM CATEGORIAS DE OPCIONAIS -->
                    </td>
                    <td>
                        <!-- CATEGORIAS DE OPCIONAIS -->
                        @foreach ($item->produto->categoria_opcional as $categoria_opcional)
                        <!-- OPCIONAIS -->
                        @foreach($categoria_opcional->opcional_produto as $opcional)

                        <!-- VERIFICAR OPCIONAIS -->
                        @php
                        // Verifica se o opcional está relacionado ao item_pedido
                        $opcional_item = $item['opcional_item']->firstWhere('opcional_produto_id', $opcional->id);

                        //Resetar variável
                        $isset_opcionais = false;
                        @endphp

                        @if($opcional_item)
                        <p class="text-secondary">
                            + R$ {{number_format($opcional->preco * $item->quantidade, 2, ',', '.')}}
                        </p>
                        @endif

                        @endforeach
                        <!-- FIM OPCIONAIS -->

                        @endforeach
                        <!-- FIM CATEGORIAS DE OPCIONAIS -->
                    </td>
                    <td></td>
                </tr>
                @endif

                @endforeach

            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3" class="fw-bold bg-white">Subtotal</td>
                    <td class="bg-white">R$ {{number_format($total_sem_entrega, 2, ',', '.')}}</td>
                    <td class="bg-white"></td>
                </tr>
                @if($pedido->consumo_local_viagem_delivery == 3)
                <tr>
                    <td colspan="3" class="fw-bold bg-white">Entrega</td>
                    <td class="bg-white">R$ {{number_format($pedido->entrega->taxa_entrega, 2, ',', '.')}}</td>
                    <td class="bg-white"></td>
                </tr>
                @endif

                @if(!empty($pedido->uso_cupom))
                <tr>
                    <td colspan="3" class="fw-regular bg-white">Cupom - {{ $pedido->uso_cupom->cupom->codigo }}</td>
                    @if($pedido->uso_cupom->cupom->tipo_desconto == 1)
                    <td class="text-danger bg-white">
                        - R$ {{ number_format($pedido->uso_cupom->cupom->desconto, 2, ',', '.') }}
                    </td>
                    @else
                    <td class="text-danger bg-white">- {{ $pedido->uso_cupom->cupom->desconto }} %</td>
                    @endif
                    <td class="bg-white"></td>
                </tr>
                @endif
                <tr>
                    <td colspan="3" class="fw-bold bg-white">Total</td>
                    <td class="fw-bolder bg-white"> R$ {{number_format($pedido->total, 2, ',', '.')}}</td>
                    <td class="bg-white"></td>
                </tr>
            </tfoot>

        </table>

    </div>

</div>
<!-- FIM PEDIDO -->