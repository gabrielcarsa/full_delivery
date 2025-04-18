<div class="my-3">

    <!-- MENSAGENS -->
    <div class="toast-container position-fixed top-0 end-0">
        @if(session('success'))
        <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-autohide="true">
            <div class="d-flex align-items-center p-3">
                <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                    check_circle
                </span>
                <div class="toast-body">
                    <p class="fs-5 m-0">
                        {{ session('success') }}
                    </p>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif
        @if (session('error'))
        <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-autohide="true">
            <div class="d-flex align-items-center p-3">
                <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                    error
                </span>
                <div class="toast-body">
                    <p class="fs-5 m-0">
                        {{ session('error') }}
                    </p>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif
        @if ($errors->any())
        <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-autohide="true">
            <div class="d-flex align-items-center p-3">
                <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                    error
                </span>
                <div class="toast-body">
                    @foreach ($errors->all() as $error)
                    <p class="fs-5 m-0">
                        {{ $error }}
                    </p>
                    @endforeach
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>
    <!-- FIM MENSAGENS -->

    <!-- HEADER MESA DETALHES -->
    <div class="d-flex justify-content-between align-items-center border p-3 rounded">
        <h4 class="m-0 fw-bold text-black">
            Mesa {{$data['mesa']->nome}}
            @if($data['mesa']->is_ocupada != 1)
            <span class="bg-success px-2 ml-1 text-white rounded" style="font-size: 13px !important">
                Dísponivel
            </span>
            @elseif($data['mesa']->is_ocupada == 1 && $data['mesa']->valor_pago_parcial > 0)
            <span class="bg-padrao px-2 ml-1 text-white rounded" style="font-size: 13px !important">
                Pagamento parcial
            </span>
            @else
            <span class="bg-warning px-2 ml-1 text-white rounded" style="font-size: 13px !important">
                Ocupado
            </span>
            @endif
        </h4>
        <div class="d-flex align-items-center">
            <p class="my-0 mx-1">
                <span class="fw-bold">
                    Abertura da mesa:
                </span>
                @if($data['mesa']->hora_abertura != null)
                {{\Carbon\Carbon::parse($data['mesa']->hora_abertura)->format('d/m/Y')}} ás
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
                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#mudarMesaModal">
                            Mudar de mesa
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="#">
                            Cancelar mesa
                        </a>
                    </li>
                </ul>

                <!-- MODAL MUDAR MESA -->
                <div class="modal modal-md fade" id="mudarMesaModal" tabindex="-1" aria-labelledby="mudarMesaModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p class="modal-title fs-5 fw-semibold" id="mudarMesaModalLabel">
                                    Mudar de mesa
                                </p>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('mesa.mudar_mesa', ['mesa_atual_id' => $data['mesa']->id]) }}"
                                method="post">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row">
                                        <p>
                                            Transfira os pedidos para outra mesa.
                                        </p>
                                        <div class="col">
                                            <p class="m-0">
                                                De
                                            </p>
                                            <p class="m-0 fw-bold fs-5">
                                                Mesa {{$data['mesa']->nome}}
                                            </p>
                                        </div>
                                        <div class="col text-center">
                                            <div class="form-floating">
                                                <select class="form-select" id="floatingSelect" aria-label="Para"
                                                    name="mesa_nova_id">
                                                    <option selected>-- Selecione --</option>
                                                    @foreach($data['mesas'] as $mesa)
                                                    @if($mesa->id != $data['mesa']->id)
                                                    <option value="{{$mesa->id}}">Mesa {{$mesa->nome}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for="floatingSelect">Para</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn border-padrao text-padrao" data-bs-dismiss="modal">
                                        Fechar
                                    </button>
                                    <button type="submit" class="btn bg-padrao text-white fw-semibold px-3">
                                        Transferir
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- FIM MODAL MUDAR MESA -->

            </div>

        </div>
    </div>
    <!-- HEADER MESA DETALHES -->

    <form action="{{ route('pedido.pagamento', ['mesa_id' => $data['mesa']->id ]) }}" method="post">
        @csrf

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
                        <span class="material-symbols-outlined mr-1 text-padrao"
                            style="font-variation-settings: 'FILL' 1;">
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
                <a data-bs-toggle="modal" data-bs-target="#adicionarItemModal{{$pedido->id}}"
                    class="btn border-padrao text-padrao d-flex align-items-center">
                    <span class="material-symbols-outlined">
                        add
                    </span>
                    Adionar item
                </a>
                <!-- MODAL ADD -->
                <div class="modal fade" id="adicionarItemModal{{$pedido->id}}" tabindex="-1"
                    aria-labelledby="adicionarItemModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p class="modal-title fs-5" id="adicionarItemModalLabel">
                                    Adicionar item
                                </p>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Digite o nome do produto"
                                        aria-label="Produto" aria-describedby="button-addon2" name="pesquisaProduto">
                                    <button class="btn border-padrao d-flex align-items-center" type="button"
                                        id="pesquisarProduto{{$pedido->id}}" data-pedido-id="{{ $pedido->id }}">
                                        <span class="material-symbols-outlined text-padrao">
                                            search
                                        </span>
                                    </button>
                                </div>

                                <div class="exibirProdutos">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn border-padrao text-padrao" data-bs-dismiss="modal">
                                    Fechar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIM MODAL ADD -->
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
                    $isset_opcionais = false;
                    @endphp

                    <!-- Exibir itens do pedido -->
                    @foreach ($pedido->item_pedido as $item)

                    <!-- Incrementando sobre valor total -->
                    @php
                    $total_sem_entrega += $item->subtotal;
                    @endphp


                    <tr class="p-0 m-0">
                        <td class="bg-white">
                            @if($item->situacao != 1)
                            <input type="checkbox" name="item_pedido_id[]" value="{{$item->id}}">
                            @endif
                        </td>
                        <td
                            class="bg-white {{$item->situacao == 1 ? 'text-decoration-line-through text-secondary' : '' }}">
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
                        <td
                            class="bg-white {{$item->situacao == 1 ? 'text-decoration-line-through text-secondary' : '' }}">
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
                        <td
                            class="bg-white {{$item->situacao == 1 ? 'text-decoration-line-through text-secondary' : '' }}">
                            <span>
                                R$ {{number_format($item->preco_unitario, 2, ',', '.')}}
                            </span>
                        </td>
                        <td
                            class="bg-white {{$item->situacao == 1 ? 'text-decoration-line-through text-secondary' : '' }}">
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
                    Taxa de serviço ({{$data['mesa']->loja->taxa_servico}}%)
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
                        <!-- VARIÁVEIS -->
                        <input type="hidden" name="total_geral" value="{{$total_geral}}">
                        <input type="hidden" name="taxa_servico" value="{{$taxa_servico}}">
                        <input type="hidden" name="valor_pago_parcial" value="{{$data['mesa']->valor_pago_parcial}}">
                        <input type="hidden" name="pedidos"
                            value="{{ json_encode($data['pedidos']->pluck('id')->toArray()) }}">
                        <!-- FIM VARIÁVEIS -->

                        <div class="row">
                            <div class="col bg-light p-3 m-1">
                                <label for="inputValorPagar" class="form-label">Valor a pagar</label>
                                <input type="text" id="inputValorPagar" name="valorPagar" class="form-control"
                                    aria-describedby="aPagarHelp" required>
                                <div id="aPagarHelp" class="form-text">
                                    @if($data['mesa']->is_taxa_paga == true)
                                    o valor a pagar não pode ser maior que R$
                                    {{ number_format($total_geral- $data['mesa']->valor_pago_parcial, 2, ',', '.') }}
                                    @else
                                    o valor a pagar não pode ser maior que R$
                                    {{ number_format(($total_geral + $taxa_servico) - $data['mesa']->valor_pago_parcial, 2, ',', '.') }}
                                    @endif
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" value="true" name="sem_taxa_servico"
                                        id="sem_taxa_servico"
                                        {{$data['mesa']->is_taxa_paga == true ? 'checked disabled' : ''}}>
                                    <label class="form-check-label" for="sem_taxa_servico">
                                        Não cobrar taxa de serviço
                                    </label>
                                </div>
                            </div>
                            <div class="col bg-light p-3 m-1">
                                <p class="m-0">
                                    Selecione uma opção
                                </p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        value="option1">
                                    <label class="form-check-label" for="inlineRadio1">Dinheiro</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        value="option2">
                                    <label class="form-check-label" for="inlineRadio2">Pix</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        value="option2">
                                    <label class="form-check-label" for="inlineRadio2">Crédito</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        value="option2">
                                    <label class="form-check-label" for="inlineRadio2">Débito</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col bg-light p-3 m-1">
                                @if($data['mesa']->is_taxa_paga == true)
                                <p class="m-0 text-secondary">
                                    *Taxa de serviço de R$ {{ number_format($taxa_servico, 2, ',', '.') }} já foi
                                    paga.
                                </p>
                                @endif
                                <div class="d-flex justify-content-between">
                                    <p class="m-0">
                                        Valor dos itens selecionados:
                                    </p>
                                    <p class="m-0" id="valorItensSelecionados">
                                        R$ 0,00
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="m-0">
                                        Valor pago:
                                    </p>
                                    <p class="m-0">
                                        R$ {{ number_format($data['mesa']->valor_pago_parcial, 2, ',', '.') }}
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="m-0 fw-bold">
                                        Valor em aberto:
                                    </p>
                                    <p class="m-0 fw-bold" id="valor_em_aberto">
                                        @php
                                        if($data['mesa']->is_taxa_paga == true){
                                        $valor_em_aberto = $total_geral -
                                        $data['mesa']->valor_pago_parcial;
                                        }else{
                                        $valor_em_aberto = ($total_geral + $taxa_servico) -
                                        $data['mesa']->valor_pago_parcial;
                                        }

                                        @endphp
                                        R$ {{ number_format($valor_em_aberto, 2, ',', '.') }}
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
                                        Total mesa:
                                    </p>
                                    <p class="m-0 fw-bold">
                                        R$ {{ number_format($total_geral + $taxa_servico, 2, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <p class="m-0 text-black fw-semibold d-flex align-items-center">
                            <span class="material-symbols-outlined mr-1">
                                warning
                            </span>
                            Algumas instruções:
                        </p>
                        <p class="my-0 mx-3 text-secondary">
                            - A taxa de serviço é cobrada por mesa. Uma vez que foi paga a taxa não poderá ser
                            cobrada novamente.
                        </p>
                        <p class="my-0 mx-3 text-secondary">
                            - O 'valor pago' não é somado a taxa de serviço.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="text-padrao mx-3" data-bs-dismiss="modal">Voltar</button>
                        <button type="submit" class="btn bg-padrao text-white fw-semibold ml-1 px-3">
                            Pagar
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <!-- FIM MODAL -->
    </form>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
//CALCULAR VALOR TOTAL ITENS SELECIONADOS
$(document).ready(function() {

    // Selecionar todos checkboxes
    $("#selectAll").click(function() {
        var selecionarTodos = $(this).prop('checked');
        $(this).closest('table').find("input[name='item_pedido_id[]']").prop('checked',
            selecionarTodos);
        calcularValorTotal(); // Chame a função sempre que marcar/desmarcar
    });

    // Calcular valor total ao marcar/desmarcar os checkboxes individuais
    $("input[name='item_pedido_id[]']").change(function() {
        calcularValorTotal();
    });

    // Função para calcular o valor total dos itens selecionados
    function calcularValorTotal() {
        var total = 0;

        // Iterar sobre os checkboxes selecionados
        $("input[name='item_pedido_id[]']:checked").each(function() {
            // Pega o checkbox do item selecionado
            var checkbox = $(this);
            // Pega a linha do item correspondente
            var linhaItem = checkbox.closest('tr');
            // Pega o subtotal do item (verifique se está formatado com R$, e converta para número)
            var subtotalItem = parseFloat(linhaItem.find('td:nth-child(5) span').text().replace('R$',
                '').replace('.', '').replace(',', '.'));

            // Adiciona o subtotal do item ao total
            total += subtotalItem;

            // Verifica se a próxima linha contém opcionais (categoria de opcionais)
            var proximaLinha = linhaItem.next('tr');
            if (proximaLinha.length && proximaLinha.find('td:nth-child(3) p').length) {
                // Iterar sobre os opcionais e somar seus valores
                proximaLinha.find('td:nth-child(5) p').each(function() {
                    // Pega o valor do opcional (verifique se está formatado com R$, e converta para número)
                    var precoOpcional = parseFloat($(this).text().replace('+ R$', '').replace(
                        '.', '').replace(',', '.'));
                    // Adiciona o valor do opcional ao total
                    total += precoOpcional;
                });
            }
        });

        // Atualizar o campo inputValorPagar com o total formatado
        $('#valorItensSelecionados').text('R$ ' + total.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
    }

    // Calcular valor total inicial (caso algum item esteja pré-selecionado)
    calcularValorTotal();
});

$(document).ready(function() {


    // MASCARA NO CAMPO DE VALOR
    $(document).on('input', 'input[name^="valorPagar"]', function() {
        // Remova os caracteres não numéricos
        var unmaskedValue = $(this).val().replace(/\D/g, '');

        // Adicione a máscara apenas ao input de valor relacionado à mudança
        $(this).val(mask(unmaskedValue));
    });

    function mask(value) {
        // Converte o valor para número
        var numberValue = parseFloat(value) / 100;

        // Formata o número com vírgula como separador decimal e duas casas decimais
        return numberValue.toLocaleString('pt-BR', {
            minimumFractionDigits: 2
        });
    }

    // Cálculo do valor em aberto ao marcar/desmarcar o checkbox da taxa de serviço
    $('#sem_taxa_servico').change(function() {
        var total_geral = parseFloat('{{ $total_geral }}');
        var taxa_servico = parseFloat('{{ $taxa_servico }}');
        var valor_pago_parcial = isNaN(parseFloat('{{ $data["mesa"]->valor_pago_parcial }}')) ? 0 :
            parseFloat('{{ $data["mesa"]->valor_pago_parcial }}');
        var valorEmAberto = (total_geral + taxa_servico) - valor_pago_parcial;

        if ($(this).is(':checked')) {
            // Se a taxa de serviço não for cobrada, subtrai o valor da taxa de serviço
            valorEmAberto = total_geral - valor_pago_parcial;
        }

        // Atualiza o valor em aberto na tela
        $('#valor_em_aberto').text('R$ ' + valorEmAberto.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
        $('#aPagarHelp').text('o valor a pagar não pode ser maior que R$ ' + valorEmAberto
            .toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
    });

});

//PESQUISAR E EXIBIR CATEGORIAS E PRODUTOS
document.querySelectorAll('[id^="pesquisarProduto"]').forEach(button => {
    button.addEventListener('click', function() {
        // Obtém o ID do pedido a partir do atributo data
        const pedidoId = this.dataset.pedidoId;

        const pesquisaCampo = document.querySelector('input[name="pesquisaProduto"]').value;

        // Requisição Ajax
        fetch(`/categoria_produto/JSON?pesquisa=${encodeURIComponent(pesquisaCampo)}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    exibirProdutos(data, pedidoId);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    });
});

function exibirProdutos(categoriasProdutos, pedidoId) {
    const produtosContainer = document.querySelector(`#adicionarItemModal${pedidoId} .exibirProdutos`);
    produtosContainer.innerHTML = ''; // Limpa os produtos anteriores

    // Verifica se há categorias retornadas
    if (categoriasProdutos.length === 0) {
        produtosContainer.innerHTML = '<p>Nenhum produto encontrado.</p>';
        return;
    }

    // Itera sobre as categorias e seus produtos
    categoriasProdutos.forEach(categoria => {
        // Renderiza os produtos da categoria
        categoria.produto.forEach(produto => {

            // Formata o preço em formato BRL (R$)
            let precoFormatado = parseFloat(produto.preco).toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });

            // Gera a URL base no Blade, sem placeholders
            const urlBase = `{{ route('pedido.adicionar_item') }}`;
            const urlProduto = `${urlBase}?pedido_id=${pedidoId}&produto_id=${produto.id}`;

            // Cria o card do produto com o layout desejado
            let produtoCard = `
                <div class="d-flex align-items-center justify-content-between border rounded p-3 mb-2">
                    <div>
                        <p class="m-0 text-secondary">#${produto.id}</p> <!-- ID do produto -->
                        <p class="m-0 fw-bold">${produto.nome} - ${precoFormatado}</p> <!-- Nome do produto -->
                        <p class="m-0 fw-semibold">${categoria.nome}</p> <!-- Nome da categoria -->
                    </div>
                    <div>
                        <a href="${urlProduto}" class="d-flex align-items-center border-padrao text-decoration-none text-padrao p-2 rounded">
                            <span class="material-symbols-outlined fw-bold mr-1">add_circle</span> <!-- Botão de adicionar -->
                            Adicionar
                        </a>
                    </div>
                </div>`;

            // Adiciona o card ao container
            produtosContainer.innerHTML += produtoCard;
        });
    });
}
</script>