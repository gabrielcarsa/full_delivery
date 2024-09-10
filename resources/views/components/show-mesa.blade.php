<div class="my-3">

    <!-- HEADER MESA DETALHES -->
    <div class="d-flex justify-content-between align-items-center border p-3 rounded">
        <h4 class="m-0 fw-bold text-black">
            Mesa {{$data['mesa']->nome}}
        </h4>
        <div class="d-flex align-items-center">
            <p class="my-0 mx-1">
                <span class="fw-bold">
                    Abertura da mesa:
                </span>
                @if($data['mesa']->hora_abertura != null)
                {{\Carbon\Carbon::parse($data['mesa']->abertura)->format('d/m/Y')}} ás
                {{\Carbon\Carbon::parse($data['mesa']->hora_abertura)->format('H:i')}}
                @else
                00h00m
                @endif
            </p>

            <div class="dropdown">
                <a class="btn border d-flex align-items-center ml-2" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span class="material-symbols-outlined">
                        more_vert
                    </span>
                </a>

                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="#">
                            Mudar de mesa
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="#">
                            Cancelar mesa
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    <!-- HEADER MESA DETALHES -->

    <!-- Variáveis PHP -->
    @php
    $total_geral = 0;
    @endphp


    <!-- PEDIDOS -->
    <div class="p-3 my-2">

        <!-- PEDIDOS FOREACH -->
        @foreach ($data['pedidos'] as $pedido)

        <!-- NOME CLIENTE PEDIDO -->
        <div class="d-flex justify-content-between align-items-center fw-semibold pt-3">
            <div>
                <div class="d-flex align-items-center fs-4">
                    <span class="material-symbols-outlined mr-1 text-padrao" style="font-variation-settings: 'FILL' 1;">
                        person
                    </span>
                    <p class="m-0 text-uppercase">
                        @if($pedido->nome_cliente == null)
                        {{$pedido->cliente->nome }}
                        @else
                        {{$pedido->nome_cliente }}
                        @endif
                    </p>
                </div>
                <p class="m-0 text-secondary ">
                    Pedido ID: {{$pedido->id}}
                </p>
            </div>
            <a href="" class="btn border-padrao text-padrao d-flex align-items-center">
                <span class="material-symbols-outlined">
                    add
                </span>
                Adionar item
            </a>
        </div>
        <!-- FIM NOME CLIENTE PEDIDO -->


        <table class="table">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" name="selectAll" id="selectAll">
                    </th>
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

                <!-- Exibir itens do pedido -->
                @foreach ($pedido->item_pedido as $item)

                <!-- Incrementando sobre valor total -->
                @php
                $total_sem_entrega += $item->subtotal;
                @endphp


                <tr class="p-0 m-0">
                    <td class="bg-white">
                        <input type="checkbox" name="item_pedido_id[]" value="{{$pedido->id}}">
                    </td>
                    <td class="bg-white">
                        <span>
                            {{ $item->quantidade }}x
                        </span><br>
                    </td>
                    <td class="bg-white">
                        <span class="fw-bold">
                            {{ $item->produto->nome }}
                        </span>
                    </td>
                    <td class="bg-white">
                        <span>
                            R$ {{number_format($item->preco_unitario, 2, ',', '.')}}
                        </span>
                    </td>
                    <td class="bg-white">
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
                                    <a class="dropdown-item" href="#">
                                        Alterar quantidade
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#">
                                        Excluir item
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>

                @if(!$item->produto->categoria_opcional->isEmpty())
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
                    <td colspan="3" class="fw-bold bg-white">Total cliente</td>
                    <td class="bg-white"></td>
                    <td class="bg-white">R$ {{number_format($total_sem_entrega, 2, ',', '.')}}</td>
                    <td class="bg-white"></td>
                    @php
                    $total_geral += $total_sem_entrega;
                    @endphp
                </tr>
                @if($pedido->consumo_local_viagem_delivery == 3)
                <tr>
                    <td colspan="3" class="fw-bold bg-white">Entrega</td>
                    <td class="bg-white"></td>
                    <td class="bg-white">R$ {{number_format($pedido->entrega->taxa_entrega, 2, ',', '.')}}</td>
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

            </tfoot>

        </table>
        @endforeach
        <!-- FIM PEDIDOS FOREACH -->

    </div>
    <!-- FIM PEDIDOS -->

    <!-- VALORES -->
    <div class="d-flex justify-content-between px-3">
        <div>
            <p class="m-0 text-secondary">
                Subtotal mesa
            </p>
            <p class="m-0">
                R$ {{ number_format($total_geral, 2, ',', '.') }}
            </p>
        </div>
        <div>
            <p class="m-0 text-secondary">
                Taxa de serviço
            </p>
            <p class="m-0">
                @php
                $taxa_servico = $total_geral * ($data['mesa']->loja->taxa_servico / 100)
                @endphp
                R$ {{ number_format($taxa_servico, 2, ',', '.') }}
            </p>
        </div>
        <div>
            <p class="m-0 text-secondary">
                Total mesa
            </p>
            <p class="m-0 fw-bold">
                R$ {{ number_format($total_geral + $taxa_servico, 2, ',', '.') }}
            </p>
        </div>
    </div>
    <!-- FIM VALORES -->

    <!-- BOTÕES AÇÕES -->
    <div class="d-flex justify-content-end p-3 sticky-bottom bg-white">
        <a href="" class="btn border-padrao text-padrao mx-1">
            Transferir consumo
        </a>
        <a href="" class="btn bg-padrao text-white fw-semibold ml-1" data-bs-toggle="modal"
            data-bs-target="#modalPagamento">
            Fazer pagamento
        </a>
    </div>
    <!-- FIM BOTÕES AÇÕES -->

    <!-- MODAL -->
    <div class="modal fade modal-lg" id="modalPagamento" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5" id="exampleModalLabel">
                        Fazer pagamento
                    </p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col bg-light p-3 m-1">
                            <label for="inputValorPagar" class="form-label">Valor a pagar</label>
                            <input type="text" id="inputValorPagar" class="form-control" aria-describedby="aPagarHelp">
                            <div id="aPagarHelp" class="form-text">
                                o valor a pagar não pode ser maior que R$ {{ number_format($total_geral + $taxa_servico, 2, ',', '.') }}
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Não cobrar taxa de serviço
                                </label>
                            </div>
                        </div>
                        <div class="col bg-light p-3 m-1">
                            <p class="m-0">
                                Selecione uma opção
                            </p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1"
                                    value="option1">
                                <label class="form-check-label" for="inlineRadio1">Dinheiro</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2"
                                    value="option2">
                                <label class="form-check-label" for="inlineRadio2">Pix</label>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col bg-light p-3 m-1">
                            <div class="d-flex justify-content-between">
                                <p class="m-0">
                                    Valor pago:
                                </p>
                                <p class="m-0">
                                    R$ 0,00
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="m-0 fw-bold">
                                    Valor em aberto:
                                </p>
                                <p class="m-0 fw-bold">
                                    R$ {{ number_format($total_geral, 2, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        <div class="col bg-light p-3 m-1">
                            <div class="d-flex justify-content-between">
                                <p class="m-0">
                                    Subtotal:
                                </p>
                                <p class="m-0">
                                    R$ {{ number_format($total_geral, 2, ',', '.') }}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="m-0">
                                    Taxa de serviço:
                                </p>
                                <p class="m-0">
                                    R$ {{ number_format($taxa_servico, 2, ',', '.') }}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="m-0 fw-bold">
                                    Total a pagar:
                                </p>
                                <p class="m-0 fw-bold">
                                    R$ {{ number_format($total_geral + $taxa_servico, 2, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="text-padrao mx-3" data-bs-dismiss="modal">Voltar</button>
                    <button type="button" class="btn bg-padrao text-white fw-semibold ml-1 px-3">Pagar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM MODAL -->

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {


    // Selecionar todos checkboxes
    $("#selectAll").click(function() {
        // Obtém o estado atual do "Selecionar Todos" dentro da tabela atual
        var selecionarTodos = $(this).prop('checked');

        // Encontra os checkboxes individuais dentro da tabela atual e marca ou desmarca com base no estado do "Selecionar Todos"
        $(this).closest('table').find("input[name='item_pedido_id[]']").prop('checked',
            selecionarTodos);
    });


    $("#pagamento").click(function(event) {
        event.preventDefault();

        // Obtenha os valores dos checkboxes selecionados
        var checkboxesSelecionados = [];

        $("input[name='item_pedido_id[]']:checked").each(function() {
            checkboxesSelecionados.push($(this).val());
        });

        // Crie a URL com os valores dos checkboxes como parâmetros de consulta
        var url = "{{ route('pedido.pagamento') }}?item_pedido_id=" + checkboxesSelecionados.join(',');

        // Redirecione para a URL com os parâmetros
        window.location.href = url;
    });



});
</script>