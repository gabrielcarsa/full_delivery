<!-- CLIENTE -->
<div class="px-3">
    <p class="m-0 d-flex fw-semibold align-items-center text-uppercase">
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

@if($pedido->cliente_id != null)
<div class="px-3">
    <p class="m-0 d-flex align-items-center">
        <span class="material-symbols-outlined mr-1 fs-5 text-secondary" style="font-variation-settings: 'FILL' 1;">
            call
        </span>
        {{ preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $pedido->cliente->telefone) }}
    </p>
</div>
@endif
<!-- FIM CLIENTE -->

<!-- CONSUMO -->
<div class="px-3">
    @if($pedido->tipo == "DINE_IN")
    <p class="m-0 d-flex align-items-center">
        <span class="material-symbols-outlined mr-1 fs-5 text-secondary" style="font-variation-settings: 'FILL' 1;">
            table_restaurant
        </span>
        Mesa {{$pedido->mesa->nome}}
    </p>

    @elseif($pedido->tipo == "TAKEOUT")
    <p class="m-0 d-flex align-items-center">
        <span class="material-symbols-outlined mr-1 fs-5 text-secondary" style="font-variation-settings: 'FILL' 1;">
            shopping_bag
        </span>
        Para viagem
    </p>
    @endif
</div>
<!-- FIM CONSUMO -->

<!-- HORÁRIOS -->
@if($pedido->tipo == "DELIVERY" && $pedido->via_ifood == false)
<p class="m-0 px-3 d-flex align-items-center">
    <span class="material-symbols-outlined mr-1 fs-5 text-secondary" style="font-variation-settings: 'FILL' 1;">
        calendar_clock
    </span>
    Previsão de entrega:
    {{ \Carbon\Carbon::parse($pedido->feito_em)->addMinutes($pedido->entrega->tempo_min)->format('H:i') }}
    -
    {{ \Carbon\Carbon::parse($pedido->feito_em)->addMinutes($pedido->entrega->tempo_max)->format('H:i') }}
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
<!-- FIM HORÁRIOS -->

<p class="m-0 px-3 d-flex align-items-center">
    <span class="material-symbols-outlined mr-1 fs-5 text-secondary" style="font-variation-settings: 'FILL' 1;">
        info
    </span>
    {{$pedido->observacao}}
</p>

<!-- ENTREGA -->
@if($pedido->tipo == "DELIVERY")
<div class="bg-white rounded border p-3 my-2">
    <p class="fw-bolder fs-5 m-0 p-0">Entrega</p>
    <p class="m-0">
        {{$pedido->entrega->rua}} {{$pedido->entrega->numero}},
        {{$pedido->entrega->bairro}}, {{$pedido->entrega->cidade}}/{{$pedido->entrega->estado}}.
        {{$pedido->entrega->complemento}}
    </p>
</div>
@endif
<!-- FIM ENTREGA -->

<!-- PAGAMENTO -->
<div class="bg-white rounded border p-3 my-2">
    <p class="fw-bolder fs-5 m-0 p-0">Pagamento</p>

    @if($pedido->tipo == "DELIVERY")
    <p class="p-0 m-0 fs-6">
        {{$pedido->status == 1 ? 'Pago' : 'Cobrar no ato da entrega'}} <strong>R$
            {{number_format($pedido->total, 2, ',', '.')}} - {{$pedido->forma_pagamento->nome}}</strong>
    </p>
    @elseif($pedido->tipo == "TAKEOUT")
    <p class="p-0 m-0 fs-6">
        {{$pedido->status == 1 ? 'Pago' : 'Cobrar na retirada'}} <strong>R$
            {{number_format($pedido->total, 2, ',', '.')}} - {{$pedido->forma_pagamento->nome}}</strong>
    </p>
    @elseif($pedido->tipo == "DINE_IN")
    <p class="p-0 m-0 fs-6">
        {{$pedido->status == 1 ? 'Pago' : 'Cobrar na mesa/caixa'}} <strong>R$
            {{number_format($pedido->total, 2, ',', '.')}} - {{$pedido->forma_pagamento->nome}}</strong>
    </p>
    @endif
</div>
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
        <table class="table table-borderless">
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
                @endphp

                <!-- PEDIDOS FOREACH -->
                @foreach ($pedido->item_pedido as $item)

                <!-- Incrementando sobre valor total -->
                @php
                $total_sem_entrega += $item->subtotal;
                @endphp


                <tr class="p-0 m-0 border-top">
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
                @if($item->opcional_item != null)

                <!-- OPCIONAIS -->
                @foreach($item->opcional_item as $opcional_item)

                <tr style="font-size:14px" class="border-top m-0">
                    <td class="bg-light"></td>
                    <td class="bg-light">
                        <p class="fw-bold m-0 text-secondary">
                            {{$opcional_item->opcional_produto->categoria_opcional->nome}}
                        </p>
                        <p class="m-0 text-secondary">
                            {{$opcional_item->quantidade}}x {{$opcional_item->opcional_produto->nome}}
                        </p>
                    </td>
                    <td class="bg-light"></td>
                    <td class="bg-light text-secondary">
                        + R$ {{number_format($opcional_item->preco_unitario, 2, ',', '.')}}
                    </td>
                    <td class="bg-light"></td>
                </tr>

                <!-- CUSTOMIZACAO OPCIONAIS -->
                @if(isset($opcional_item->customizacao_opcional_item) &&
                $opcional_item->customizacao_opcional_item->isNotEmpty())
                <tr style="font-size:14px">
                    <td class="bg-light"></td>
                    <td class="bg-light">
                        <p class="ms-3 my-0 text-secondary fw-bold">
                            Customização de {{$opcional_item->opcional_produto->nome}}
                        </p>
                        @foreach($opcional_item->customizacao_opcional_item as $customizacao_opcional_item)
                        <p class="ms-3 my-0 text-secondary">
                            {{$customizacao_opcional_item->quantidade}}x
                            {{$customizacao_opcional_item->customizacao_opcional->nome}}
                        </p>
                        @endforeach
                    </td>
                    <td class="bg-light"></td>
                    <td class="bg-light text-secondary">
                        <p class="m-0 text-light">Preço</p>
                        @foreach($opcional_item->customizacao_opcional_item as $customizacao_opcional_item)
                        <p class="m-0 text-secondary">
                            + R$ {{number_format($customizacao_opcional_item->preco_unitario, 2, ',', '.')}}
                        </p>
                        @endforeach

                    </td>
                    <td class="bg-light"></td>
                </tr>
                @endif
                <!-- FIM CUSTOMIZACAO OPCIONAIS -->


                @endforeach
                <!-- FIM OPCIONAIS -->

                @endif
                <!-- FIM VERIFICAR SE EXISTE OPCIONAIS -->

                @endforeach
                <!-- FIM PEDIDOS FOREACH -->

            </tbody>

            <tfoot>
                <tr class="border-top">
                    <td colspan="3" class="fw-bold bg-white">Subtotal</td>
                    <td class="bg-white">R$ {{number_format($total_sem_entrega, 2, ',', '.')}}</td>
                    <td class="bg-white"></td>
                </tr>

                @if($pedido->via_ifood == 1)
                <tr class="border-top">
                    <td colspan="3" class="fw-bold bg-white">Taxa iFood</td>
                    <td class="bg-white">R$ {{number_format($pedido->taxa_ifood, 2, ',', '.')}}</td>
                    <td class="bg-white"></td>
                </tr>
                @endif

                @if($pedido->tipo == "DELIVERY")
                <tr class="border-top">
                    <td colspan="3" class="fw-bold bg-white">Entrega</td>
                    <td class="bg-white">R$ {{number_format($pedido->entrega->taxa_entrega, 2, ',', '.')}}</td>
                    <td class="bg-white"></td>
                </tr>
                @endif

                @if(!empty($pedido->uso_cupom))
                <tr class="border-top">
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
                <tr class="border-top">
                    <td colspan="3" class="fw-bold bg-white">Total</td>
                    <td class="fw-bolder bg-white"> R$ {{number_format($pedido->total, 2, ',', '.')}}</td>
                    <td class="bg-white"></td>
                </tr>
            </tfoot>

        </table>

    </div>

</div>
<!-- FIM PEDIDO -->