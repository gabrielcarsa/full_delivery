<x-layout-cardapio>

    <!-- NENHUM RESTAURANTE SELECIONADO -->

    @if(empty($data['loja_id']))

    <div class="vh-100 d-flex align-items-center justify-content-center wallpaper-cardapio">

        <!-- APRESENTAÇÃO -->
        <div>
            <h2 class="text-white fs-1 fw-bolder text-center">Olá, bem vindo!</h2>
            <p class="text-light text-center">Vamos começar escolhendo uma loja?</p>

            <div class="row">

                <!-- LOJAS -->
                @foreach($data['lojas'] as $loja)

                <!-- CARDS -->
                <div class="col bg-white m-3 p-3 rounded" style="width: 300px;">
                    <div class="d-flex justify-content-center">
                        <img src='{{asset("storage/$loja->nome/$loja->logo")}}' alt="" width="100" class="rounded">
                    </div>

                    <h3 class="fs-4 fw-bolder my-2 text-center">{{$loja->nome}}</h3>

                    <p class="d-flex align-items-center text-secondary">
                        <span class="material-symbols-outlined mr-2">
                            location_on
                        </span>
                        <span>
                            {{$loja->rua}}, {{$loja->numero}} {{$loja->bairro}} - {{$loja->cidade}} {{$loja->estado}}
                        </span>
                    </p>

                    <div class="d-flex justify-content-center">
                        <a href="{{ route('cardapio', ['loja_id' => $loja->id,]) }}"
                            class="btn btn-primary px-5">Escolher</a>
                    </div>

                </div>

                @endforeach
            </div>

        </div>

    </div>

    <!-- RESTAURANTE SELECIONADO ## CARDAPIO ## -->

    @elseif(!$data['categoria_produto']->isEmpty())

    <!-- DROPDOWN TROCAR CONSUMO -->
    @if(!empty($data['consumo_local_viagem_delivery']))
    <div class="d-flex justify-content-center m-0">
        <div class="dropdown m-0">
            <button class="dropdown-toggle fw-semibold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                @if($data['consumo_local_viagem_delivery'] == 1)
                Comer no local
                @elseif($data['consumo_local_viagem_delivery'] == 2)
                Para viagem
                @elseif($data['consumo_local_viagem_delivery'] == 3)
                Para entrega
                @else
                Erro
                @endif
            </button>
            <ul class="dropdown-menu">
                @if($data['consumo_local_viagem_delivery'] != 1)
                <li>
                    <a class="dropdown-item"
                        href="{{ route('cardapio', ['loja_id' => $data['loja_id'], 'consumo_local_viagem_delivery' => 1]) }}">
                        Comer no local
                    </a>
                </li>
                @endif

                @if($data['consumo_local_viagem_delivery'] != 2)
                <li>
                    <a class="dropdown-item"
                        href="{{ route('cardapio', ['loja_id' => $data['loja_id'], 'consumo_local_viagem_delivery' => 2]) }}">
                        Para viagem
                    </a>
                </li>
                @endif

                @if($data['consumo_local_viagem_delivery'] != 3)

                @if (Route::has('login'))
                @auth('cliente')
                <li>
                    <a class="dropdown-item"
                        href="{{ route('cardapio', ['loja_id' => $data['loja_id'], 'consumo_local_viagem_delivery' => 3]) }}">
                        Para entrega
                    </a>
                </li>
                @else
                <li>
                    <a class="dropdown-item"
                        href="{{ route('cliente.login', ['loja_id' => $data['loja_id'], 'consumo_local_viagem_delivery' => 3]) }}">
                        Para entrega
                    </a>
                </li>
                @endauth
                @endif

                @endif

            </ul>
        </div>
    </div>
    @endif
    <!-- FIM DROPDOWN TROCAR CONSUMO -->

    <div class="container-cardapio bg-body-tertiary">

        <!-- BANNER LOJA -->
        <div class="d-flex align-items-center justify-content-center relative">

            <!-- BANNER IMAGEM LOJA -->
            <img src="{{ asset('storage/' . $data['categoria_produto'][0]->loja->nome . '/banner') }}"
                class="w-100 rounded shadow-sm">
            <!-- FIM BANNER IMAGEM LOJA -->

            <!-- ENDEREÇO ENTREGA SE HOUVER -->
            @if (Route::has('login') && $data['consumo_local_viagem_delivery'] == 3)
            @auth('cliente')

            <div class="p-2 absolute top-0 bg-white rounded m-2" style="font-size: 13px">
                <div class="dropdown">
                    <a class="text-padrao fw-semibold text-decoration-none dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
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

                        @if($data['cliente_enderecos']->isEmpty())
                        <li>
                            <a class="dropdown-item"
                                href="{{ route('cliente_endereco.novo',  ['loja_id' => request('loja_id'), 'consumo_local_viagem_delivery' => request('consumo_local_viagem_delivery'), 'endereco_selecionado' =>  request('endereco_selecionado'), 'endereco_selecionado' =>  request('endereco_selecionado')]) }}">
                                Você não tem endereços cadastrados,
                                <strong>clique aqui para cadastrar.</strong>
                            </a>
                        </li>
                        @else

                        @foreach($data['cliente_enderecos'] as $endereco)
                        @if($endereco != $data['endereco_selecionado'])
                        <li>
                            <a class="dropdown-item"
                                href="{{ route('cardapio', ['loja_id' => $data['loja_id'], 'consumo_local_viagem_delivery' => 3, 'endereco_selecionado' => $endereco->id]) }}">
                                <span class="fw-bold">{{$endereco->nome}}</span> - {{$endereco->rua}},
                                {{$endereco->numero}}
                            </a>
                        </li>
                        @endif
                        @endforeach

                        @endif
                    </ul>
                </div>
            </div>

            @endauth
            @endif
            <!-- FIM ENDEREÇO ENTREGA SE HOUVER -->
        </div>
        <!-- FIM BANNER LOJA -->

        <div class="d-flex justify-content-between bg-white">

            <!-- IMAGEM LOJA -->
            <div class="p-2">
                <img src="{{ asset('storage/' . $data['categoria_produto'][0]->loja->nome . '/' . $data['categoria_produto'][0]->loja->logo) }}"
                    class="rounded-circle" style="max-width: 90px;">
            </div>
            <!-- FIM IMAGEM LOJA -->

            <!-- LOJA TITULO -->
            <div class="d-flex align-items-center">
                <div class="mx-3">
                    <div class="d-flex justify-content-end">
                        <h2 class="fs-2 fw-bolder m-0">{{$data['categoria_produto'][0]->loja->nome}}</h2>
                    </div>

                    <!-- INFORMAÇÕES LOJA -->
                    <div class="d-flex justify-content-end" style="font-size: 13px">
                        <!-- VERIFICAR SE ESTÁ ABERTO -->
                        @if($data['categoria_produto'][0]->loja->is_open)
                        <p class="d-flex align-items-center text-success fw-semibold m-0 p-0">
                            <span class="material-symbols-outlined mr-1 fs-6"
                                style="font-variation-settings: 'FILL' 1;">
                                circle
                            </span>
                            <span>
                                Aberto
                            </span>
                        </p>

                        @else
                        <p class="d-flex align-items-center text-danger fw-semibold m-0 p-0">
                            <span class="material-symbols-outlined mr-1 fs-6">
                                circle
                            </span>
                            <span>
                                Fechado
                            </span>
                        </p>
                        @endif
                    </div>
                    <!-- FIM VERIFICAR SE ESTÁ ABERTO -->
                </div>

                <!-- ARROW INFOS -->
                <a href="" class="d-flex justify-content-center text-decoration-none text-black mr-2"
                    data-bs-toggle="modal" data-bs-target="#modalHorarios">
                    <span class="material-symbols-outlined">
                        chevron_right
                    </span>
                </a>
                <!-- FIM ARROW INFOS -->

            </div>
            <!-- FIM LOJA TITULO -->

        </div>

        <!-- INFORMAÇÕES LOJA -->
        <div class="p-3 bg-white" style="font-size: 13px">

            <p class="d-flex align-items-center m-0 p-0 text-secondary">
                <span class="material-symbols-outlined mr-1">
                    attach_money
                </span>
                <span>
                    Pedido minímo: R$ 20,00
                </span>
            </p>
            <p class="d-flex align-items-center m-0 p-0 text-secondary">
                <span class="material-symbols-outlined mr-1">
                    location_on
                </span>
                <span>
                    {{$data['categoria_produto'][0]->loja->rua}},
                    {{$data['categoria_produto'][0]->loja->numero}}
                    {{$data['categoria_produto'][0]->loja->bairro}} -
                    {{$data['categoria_produto'][0]->loja->cidade}}
                    {{$data['categoria_produto'][0]->loja->estado}}
                </span>
            </p>
        </div>
        <!-- FIM INFORMAÇÕES LOJA -->

        <!-- MODAL HORARIO FUNCIONAMENTO LOJA -->
        <div class="modal fade" id="modalHorarios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Horários Funcionamento</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL HORARIO FUNCIONAMENTO LOJA -->

        @if(empty($data['consumo_local_viagem_delivery']))

        <!-- SELECIONAR OPÇÃO -->

        <div class="container d-flex justify-content-center">
            <div class="px-3 py-4 m-3 border rounded shadow-sm bg-white" style="min-width: 300px">
                <p class="m-0 text-center fs-5 fw-semibold">
                    Olá, vamos começar?
                </p>
                <p class="text-secondary text-center">Selecione uma opção</p>
                <div class="">
                    <a href="{{ route('cardapio', ['loja_id' => $data['loja_id'], 'consumo_local_viagem_delivery' => 1]) }}"
                        class="btn bg-padrao text-white my-2 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined mr-1">
                            storefront
                        </span>
                        <span>
                            Comer no local
                        </span>
                    </a>
                    <a href="{{ route('cardapio', ['loja_id' => $data['loja_id'], 'consumo_local_viagem_delivery' => 2]) }}"
                        class="btn bg-padrao text-white my-2 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined mr-1">
                            room_service
                        </span>
                        <span>
                            Para viagem
                        </span>
                    </a>
                    @if (Route::has('login'))
                    @auth('cliente')
                    <a href=" {{route('cardapio', ['loja_id' => $data['loja_id'], 'consumo_local_viagem_delivery' => 3]) }}"
                        class="btn bg-padrao text-white my-2 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined mr-1">
                            sports_motorsports
                        </span>
                        <span>
                            Para entrega
                        </span>
                    </a>
                    @else
                    <a href=" {{ route('cliente.login', ['loja_id' => $data['loja_id'], 'consumo_local_viagem_delivery' => 3]) }}"
                        class="btn bg-padrao text-white my-2 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined mr-1">
                            sports_motorsports
                        </span>
                        <span>
                            Para entrega
                        </span>
                    </a>
                    @endauth
                    @endif
                </div>

            </div>
        </div>
        <!-- FIM SELECIONAR OPÇÃO -->

        @else

        <!-- CARDAPIO -->
        <div class="bg-body-tertiary">

            <div class="">

                <!-- CATEGORIAS -->
                <div class="bg-body-tertiary d-flex overflow-x-scroll sticky-top w100 py-2" id="categorias-nav">
                    @foreach($data['categoria_produto'] as $categoria)
                    <div class="mx-1 my-3">
                        <a href="#{{$categoria->nome}}" id="nav-{{$categoria->nome}}"
                            class="text-decoration-none text-black rounded px-3 py-2 shadow-md text-truncate">
                            {{$categoria->nome}}
                        </a>
                    </div>
                    @endforeach
                </div>
                <!-- FIM CATEGORIAS -->

                <!-- CARDAPIO LISTA -->
                <div class="cardapio-lista bg-body-body">

                    <!-- CATEGORIA DOS PRODUTOS -->
                    @foreach($data['categoria_produto'] as $categoria)

                    @if($categoria->produto != null)

                    <h3 id="{{$categoria->nome}}" class="m-3 fw-bold d-inline-block"
                        style="border-bottom: 5px solid #FD0146">
                        {{$categoria->nome}}
                    </h3>

                    <!-- LISTA -->
                    <ul class="list-group list-group-flush">

                        <!-- PRODUTOS -->
                        @foreach($categoria->produto as $produto)

                        <li class="list-group-item shadow-sm">

                            <!-- PRODUTO -->
                            <a href="{{ route('cardapio.produto', ['loja_id' => $data['loja_id'], 'produto_id' => $produto->id, 'consumo_local_viagem_delivery' => $data['consumo_local_viagem_delivery'], 'endereco_selecionado' => $data['endereco_selecionado']]) }}"
                                class="text-decoration-none text-reset">

                                <!-- CARD PRODUTO -->
                                <div class="row bg-white ps-3">

                                    <!-- CARD PRODUTO DESCRIÇÃO -->
                                    <div class="col-6 p-1">
                                        <div class="">
                                            <h5 class="fs-5 fw-semibold">{{$produto->nome}}</h5>
                                            <p class="text-secondary text-wrapper m-0" style="font-size: 13px;">
                                                {{$produto->descricao}}
                                            </p>
                                            <p class="my-1" style="font-size: 13px">
                                                Serve {{$produto->quantidade_pessoa}}
                                                {{$produto->quantidade_pessoa > 1 ? 'pessoas' : 'pessoa'}}
                                            </p>
                                            <p class="fw-800 fs-6">
                                                <strong>
                                                    R$ {{number_format($produto->preco, 2, ',', '.')}}
                                                </strong>
                                            </p>
                                        </div>
                                    </div>
                                    <!-- FIM CARD PRODUTO DESCRIÇÃO -->

                                    <!-- IMG PRODUTO -->
                                    <div class="col-6 d-flex align-items-center justify-content-center">
                                        <img src="{{ $produto->imagem == null ? (empty($produto->imagemIfood) ? asset('storage/images/sem-imagem.png') : $produto->imagemIfood) : asset('storage/' . $data['categoria_produto'][0]->loja->nome . '/imagens_produtos/' . $produto->imagem) }}"
                                            class="rounded img-produto shadow-sm" alt="{{$produto->nome}}" style="min-width:110px; max-width: 200px">
                                    </div>
                                    <!-- FIM IMG PRODUTO -->

                                </div>
                                <!-- FIM CARD PRODUTO -->

                            </a>
                            <!-- FIM PRODUTO -->

                        </li>

                        @endforeach
                        <!-- FIM PRODUTOS -->
                    </ul>

                    @endif

                    @endforeach

                </div>
                <!-- CARDAPIO LISTA -->

            </div>

        </div>
        <!-- FIM CARDAPIO -->
    </div>

    @if(!empty($carrinho))
    <a class="rounded p-2 mx-3 fixed-bottom bg-padrao text-decoration-none d-flex align-items-center"
        style="margin-bottom: 70px !important;"
        href="{{ route('cardapio.carrinho', ['loja_id' => request('loja_id'), 'consumo_local_viagem_delivery' => request('consumo_local_viagem_delivery'), 'endereco_selecionado' =>  request('endereco_selecionado'), 'endereco_selecionado' =>  request('endereco_selecionado')]) }}">
        <span class="badge bg-white text-dark mr-2">
            {{count($carrinho)}}
        </span>
        <span class="text-white fw-semibold">
            Carrinho
        </span>
    </a>
    @endif

    <!-- MENU APPBAR -->
    <x-appbar-cardapio :data="$data" />
    <!-- FIM MENU APPBAR -->

    @endif

    <!-- ERRO LOJA OU CARDAPIO -->
    @else

    <div class="wallpaper-erro vh-100 d-flex justify-content-center align-items-center">
        <div>
            <h2>Loja não encontrada!</h2>
            <p>Selecione novamente</p>
            <a href="/" class="btn btn-primary">Escolher loja</a>
        </div>
    </div>
    <!-- FIM ERRO LOJA OU CARDAPIO -->


    @endif

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.cardapio-lista h3');
        const navItems = document.querySelectorAll('#categorias-nav .text-decoration-none');

        function removeActiveClasses() {
            navItems.forEach(item => item.classList.remove('bg-padrao'));
            navItems.forEach(item => item.classList.remove('text-white'));
            navItems.forEach(item => item.classList.remove('fw-semibold'));
            navItems.forEach(item => item.classList.add('border'));
        }

        function addActiveClass(id) {
            const navItem = document.querySelector(`#nav-${id}`);
            if (navItem) {
                navItem.classList.add('bg-padrao');
                navItem.classList.add('text-white');
                navItem.classList.add('fw-semibold');
                navItem.classList.remove('border');
            }
        }

        function handleScroll() {
            let currentSection = '';

            sections.forEach(section => {
                const sectionTop = section.offsetTop - 50; // Ajuste conforme necessário
                if (window.pageYOffset >= sectionTop) {
                    currentSection = section.getAttribute('id');
                }
            });

            removeActiveClasses();
            addActiveClass(currentSection);
        }

        window.addEventListener('scroll', handleScroll);

        // Call handleScroll initially to set the active link on page load
        handleScroll();
    });
    </script>


</x-layout-cardapio>