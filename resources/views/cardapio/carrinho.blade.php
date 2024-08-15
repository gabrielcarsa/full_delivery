<x-layout-cardapio>

    @if(empty($carrinho))

    <!-- CARRINHO VAZIO -->
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="m-5">
            <span class="material-symbols-outlined" style="font-size: 60px;">
                shopping_cart_off
            </span>
            <h3>Ops!</h3>
            <p>Parece que seu carrinho está vazio!</p>
            <a href="#" onclick="history.go(-1); return false;" class="btn btn-primary">Ir para cardápio</a>
        </div>
    </div>

    <!-- MENU APPBAR -->
    <x-appbar-cardapio :data="$data" />
    <!-- FIM MENU APPBAR -->

    <!-- FIM CARRINHO VAZIO -->

    @else

    <!-- CARRINHO -->

    <!-- FORM -->
    <form action="{{route('pedido.cadastrarWeb')}}" method="post">
        @csrf

        <!-- NAVBAR PRODUTO -->
        <div class="d-flex bg-white fixed-top p-2">
            <a href="#" onclick="history.go(-1); return false;"
                class="text-dark text-decoration-none d-flex align-items-center m-0">
                <span class="material-symbols-outlined">
                    arrow_back
                </span>
            </a>
        </div>
        <!-- FIM NAVBAR PRODUTO -->

        <div class="p-3 mt-3">

            <!-- ROW ENDEREÇO -->
            <h4 class="m-0 fs-5 fw-bold pt-3">Entrega em</h4>
            <div class="d-flex">
                <!-- ICONE LOCALIZACAO -->
                <div>
                    <span
                        class="material-symbols-outlined {{$errors->has('enderecoVazio') ? 'text-danger' : 'text-secondary'}}">
                        location_on
                    </span>
                </div>
                <!-- FIM ICONE LOCALIZACAO -->

                <!-- DROPDOWN ENDERECOS -->
                <div class="dropdown mb-3">
                    <a class="{{$errors->has('enderecoVazio') ? 'text-danger' : 'text-secondary'}} text-decoration-none dropdown-toggle"
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <!--SE HOUVER ENDEREÇO SELECIONADO-->
                        @if($data['endereco_selecionado'] == null)

                        Selecione endereço entrega

                        <!--SE NÃO HOUVER ENDEREÇO SELECIONADO-->
                        @else

                        <!--EXIBIR APENAS SELECIONADO-->
                        @foreach($data['cliente_enderecos'] as $endereco)
                        @if($endereco->id == $data['endereco_selecionado'])

                        {{$endereco->rua}}, {{$endereco->numero}}

                        @endif
                        @endforeach
                        <!--FIM EXIBIR APENAS SELECIONADO-->

                        @endif
                        <!--FIM SE HOUVER ENDEREÇO SELECIONADO-->
                    </a>

                    <ul class="dropdown-menu" style="font-size: 13px">
                        @foreach($data['cliente_enderecos'] as $endereco)
                        @if($endereco != $data['endereco_selecionado'])
                        <li>
                            <a class="dropdown-item"
                                href="{{ route('cardapio', ['loja_id' => $data['loja_id'], 'consumo_local_viagem' => 3, 'endereco_selecionado' => $endereco->id]) }}">
                                <span class="fw-bold">
                                    {{$endereco->nome}}
                                </span> - {{$endereco->rua}}
                                {{$endereco->numero}}
                            </a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
                <!-- FIM DROPDOWN ENDERECOS -->

            </div>
            <!-- FIM ENDEREÇO -->
            @if ($errors->has('enderecoVazio'))
            <p class="m-0 fs-6 text-danger">
                {{ $errors->first('enderecoVazio') }}
            </p>
            @endif

            <div class="row">
                <!-- ITENS -->
                <div class="col-md-6 my-3">
                    <div class="d-flex">
                        <div class="d-flex align-items-center">
                            <h3 class="fw-bolder fs-3">Itens</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-end w-100">
                            <a href="{{ route('cardapio.esvaziarCarrinho') }}" class="text-danger text-decoration-none">
                                Limpar carrinho
                            </a>
                        </div>
                    </div>

                    <!-- LISTA -->
                    <ul class="list-group list-group-flush">

                        <!-- Variáveis PHP -->
                        @php
                        $subtotal = 0;
                        @endphp

                        <!-- ITEM -->
                        @foreach ($carrinho as $item)

                        <!-- Incrementando sobre valor total -->
                        @php
                        $subtotal += $item['produto']->preco * $item['quantidade'];
                        @endphp

                        <!-- ITEM -->
                        <li class="list-group-item">

                            <!-- PRODUTO -->
                            <div class="d-flex">
                                <div class="">
                                    <p class="m-0 fw-semibold">
                                        {{ $item['produto']->nome }}
                                    </p>
                                    <p class="m-0 text-secondary text-truncate" style="max-width: 200px;">
                                        {{ $item['produto']->descricao }}
                                    </p>
                                    <p class="m-0 fw-semibold">
                                        R$ {{number_format($item['produto']->preco, 2, ',', '.')}}
                                    </p>
                                </div>
                                <div class="d-flex justify-content-end w-100">
                                    <p class="m-0 fw-semibold">{{$item['quantidade']}}x</p>
                                </div>
                            </div>
                            <!-- FIM PRODUTO -->

                            <!-- OPCIONAIS -->
                            @if($item['opcionais'] != null)
                            <div class="p-0 m-0 bg-light p-2 rounded">
                                @foreach($item['opcionais'] as $opcional)
                                <div class="d-flex m-0">
                                    <div class="d-flex align-items-center">
                                        <span class="material-symbols-outlined fs-5" style="color: #FD0146 !important">
                                            add
                                        </span>
                                    </div>
                                    <p class="m-0 d-flex align-items-center text-secondary">
                                        {{$opcional->nome}}
                                    </p>
                                    <p class="text-secondary d-flex align-items-center justify-content-end w-100 m-0">
                                        @php
                                        $subtotal += $opcional->preco;
                                        @endphp

                                        R$ {{number_format($opcional->preco, 2, ',', '.')}}
                                    </p>
                                </div>

                                @endforeach
                            </div>
                            @endif
                            <!-- FIM OPCIONAIS -->

                            <!-- OBSERVAÇÃO -->
                            @if($item['observacao'] != null)
                            <p class="">
                                Obs.: {{$item['observacao']}}
                            </p>
                            @endif
                            <!-- FIM OBSERVAÇÃO -->

                        </li>

                        @endforeach
                        <!-- FIM ITEM -->


                    </ul>
                    <!-- FIM LISTA -->

                </div>
                <!-- FIM ITENS -->

                <!-- RESUMO -->
                <div class="col-md-6 my-3">
                    <div class="d-flex">
                        <div class="d-flex align-items-center">
                            <h3 class="fw-bolder fs-3">Resumo</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-end w-100 ml-2">
                            <div>
                                <input type="text" class="form-control" placeholder="Cupom">
                            </div>
                        </div>
                    </div>

                    <!-- TOTAIS -->
                    <div class="p-3">
                        <div class="d-flex">
                            <div class="d-flex align-items-center">
                                <p class="fs-6 text-dark m-0">
                                    Subtotal
                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-end w-100">
                                <p class="m-0 fs-6">
                                    R$ {{number_format($subtotal, 2, ',', '.')}}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="d-flex align-items-center">
                                <p class="fs-6 text-dark m-0">
                                    Entrega
                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-end w-100">
                                <p class="m-0 fs-6">
                                    R$ {{number_format($data['taxa_entrega'], 2, ',', '.')}}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="d-flex align-items-center">
                                <p class="fs-6 text-dark m-0">
                                    Descontos
                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-end w-100">
                                <p class="m-0 fs-6">
                                    R$ 0,00
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="d-flex align-items-center">
                                <p class="fs-6 fw-bold m-0">
                                    Total
                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-end w-100">
                                <p class="m-0 fs-6 fw-bold">
                                    R$ {{number_format($data['taxa_entrega'] + $subtotal, 2, ',', '.')}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- FIM TOTAIS -->

                    <!-- FORMA DE PAGAMENTO -->
                    <div>
                        <h3 class="fw-bolder fs-3">Formas de pagamento</h3>
                        <div class="p-3 border rounded">
                            <p class="mx-0 mt-0 mb-2 d-flex align-items-center text-secondary">
                                <span class="material-symbols-outlined mr-1" style="font-variation-settings: 'FILL' 1;">
                                    warning
                                </span>
                                <span>
                                    Pagar na entrega
                                </span>
                            </p>
                            <p class="fw-bold fs-6" id="forma_pagamento_selecionada">
                                Nenhuma forma selecionada
                            </p>

                            <!-- BOTÃO MODAL -->
                            <a id="btn_forma_pagamento" class="text-white rounded py-2 px-3 text-decoration-none" style="background-color: #FD0146 !important;" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Selecionar
                            </a>
                            <!-- FIM BOTÃO MODAL -->

                            <!-- MODAL -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <p class="modal-title fs-5 fw-semibold" id="exampleModalLabel">Pagar na
                                                entrega</p>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-secondary">Selecione a forma de pagamento para pagar na entrega:</p>
                                            @foreach($data['formas_pagamento_loja'] as $forma_pagamento)
                                            <div class="form-check py-2">
                                                <input class="form-check-input" type="radio" name="forma_pagamento"
                                                    id="{{$forma_pagamento->id}}" value="{{$forma_pagamento->nome}}">
                                                <label class="form-check-label d-flex align-items-center" for="{{$forma_pagamento->id}}">
                                                    <img src="{{ asset('storage/icones-forma-pagamento/' . $forma_pagamento->imagem . '.svg') }}"
                                                        alt="" width="30px">
                                                    <span class="ml-1 fw-semibold">
                                                        {{$forma_pagamento->nome}}
                                                    </span>
                                                </label>
                                            </div>
                                            @endforeach

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="" data-bs-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FIM MODAL -->

                        </div>
                    </div>
                    <!-- FIM FORMA DE PAGAMENTO -->

                </div>
                <!-- FIM RESUMO -->

            </div>

        </div>
        <!-- FIM CARRINHO -->

        <!-- INPUTS COM VALORES A SER USADOS-->
        <input type="hidden" name="carrinho" value="{{ json_encode($carrinho) }}">
        <input type="hidden" name="endereco_selecionado_id" value="{{ $data['endereco_selecionado']}}">
        <input type="hidden" name="taxa_entrega" value="{{ $data['taxa_entrega'] }}">
        <input type="hidden" name="loja_id" value="{{ $data['loja_id'] }}">
        <input type="hidden" name="consumo_local_viagem" value="{{ $data['consumo_local_viagem'] }}">
        <input type="hidden" name="total" value="{{ $data['taxa_entrega'] + $subtotal }}">
        <input type="hidden" name="distancia" value="{{ $data['distancia']}}">

        <!-- BOTAO ACAO FIXO -->
        <div class="fixed-bottom p-3 bg-white border-top d-flex justify-content-end align-items-center">
            <div class="mr-1">
                <p class="m-0" style="font-size:14px">Total do pedido</p>
                <p class="m-0 fw-bold" style="font-size:14px">
                    R$ {{number_format($data['taxa_entrega'] + $subtotal, 2, ',', '.')}}
                </p>
            </div>
            <div class="ml-1">
                <button type="submit" class="text-white fw-semibold rounded text-decoration-none"
                    style="background-color: #FD0146 !important; padding: 8px 25px">
                    Finalizar pedido
                </button>
            </div>
        </div>
        <!-- FIM BOTAO ACAO FIXO -->
    </form>
    <!-- FIM FORM -->

    @endif

    <script>
        // Seleciona todos os inputs de radio
        const radios = document.querySelectorAll('input[name="forma_pagamento"]');
        
        // Adiciona um event listener para cada radio
        radios.forEach((radio) => {
            radio.addEventListener('change', function() {
                // Captura o valor do elemento selecionado
                const selectedValue = document.querySelector('input[name="forma_pagamento"]:checked').value;

                // Exibe o valor no elemento com id "resultado"
                document.getElementById('forma_pagamento_selecionada').innerText = selectedValue;

                //Mudar valor de 'selecionar' para 'alterar'
                document.getElementById('btn_forma_pagamento').innerText = 'Alterar';
                
            });
        });
    </script>

</x-layout-cardapio>