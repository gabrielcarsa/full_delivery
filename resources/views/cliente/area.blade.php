<x-layout-cardapio>

    <!-- VARIAVEL INFORMAÇÕES DO CLIENTE -->
    @php
    $cliente = Auth::guard('cliente')->user();
    @endphp

    <!-- SE NÃO ESTIVER LOGADO -->
    @if($cliente == null)
    <div class="vh-100 d-flex align-items-center justify-content-center p-3">
        <div>
            <!-- IMAGEM LOGIN -->
            <div class="my-3">
                <img src="{{ asset('storage/images/login.svg') }}" style="width: 450px;">
            </div>
            <!-- FIM IMAGEM LOGIN -->
            <p>
                É necessário fazer login ou se cadastrar para acessar a área de clientes.
            </p>
            <a href="{{ route('cliente.login', ['loja_id' => $data['loja_id'], 'consumo_local_viagem_delivery' => 3]) }}"
                class="btn bg-padrao text-white fw-semibold px-3 d-block">
                Entrar
            </a>
            <a href="#" onclick="history.go(-1); return false;" class="text-black text-center d-block my-3">
                Voltar
            </a>
        </div>
    </div>

    @else
    <!-- CONTAINER -->
    <div class="container">

        <!-- HEADER CLIENTE INFO -->
        <div class="row bg-light p-3">
            <div class="col d-flex align-items-center justify-content-center">
                <div class="div">
                    <h2 class="fs-2 text-bolder text-uppercase m-0">{{ $cliente->nome }}</h2>
                    <p class="m-0">{{ $cliente->email }}</p>
                </div>
            </div>
            <div class="col d-flex align-items-center justify-content-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 80px; height: 80px; background-color: #FD0146">
                    <p class="text-uppercase fs-1 fw-bolder m-0 p-0 text-light">{{ substr($cliente->nome, 0, 1) }}</p>
                </div>
            </div>
        </div>
        <!-- FIM HEADER CLIENTE INFO -->

        <!-- LOJA CONTATO -->
        <div class="border rounded p-3 row m-3">
            <p class="fw-semibold m-0">
                Contato com a loja
            </p>
            <!-- IMAGEM LOJA -->
            <div class="col-2 d-flex align-items-center justify-content-center">
                <img src="{{ asset('storage/' . $data['loja']->nome . '/' . $data['loja']->logo) }}"
                    class="rounded-circle" style="max-width: 70px;">
            </div>
            <!-- FIM IMAGEM LOJA -->

            <div class="col">
                <p class="m-0 fw-bold fs-5">{{ $data['loja']->nome }}</p>
                <p class="m-0 text-secondary">
                    {{ \App\Helpers\MascaraTelefone::formatPhoneNumber($data['loja']->telefone1) }}</p>
                <p class="m-0 text-secondary">
                    {{ \App\Helpers\MascaraTelefone::formatPhoneNumber($data['loja']->telefone2) }}</p>

            </div>

        </div>
        <!-- FIM LOJA CONTATO -->


        <!-- LISTA -->
        <ul class="list-group list-group-flush my-3">

            <!-- ITEM -->
            <li class="list-group-item">
                <a href=" {{ route('cliente_endereco.listar', ['cliente_id' => $cliente->id]) }} "
                    class="text-decoration-none">
                    <div class="row">
                        <div class="col-2 d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined text-dark m-0 pr-3" style="font-size: 30px;">
                                location_on
                            </span>
                        </div>
                        <div class="col">
                            <p class="d-block m-0 fs-5 text-dark fw-semibold">
                                Endereços
                            </p>
                            <p class="d-block m-0 text-secondary fs-6">
                                Seus endereços para entrega
                            </p>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-end">
                            <span class="material-symbols-outlined text-dark m-0">
                                chevron_right
                            </span>
                        </div>

                    </div>
                </a>
            </li>
            <!-- FIM ITEM -->

            <!-- ITEM -->
            <li class="list-group-item">
                <a href="" class="text-decoration-none">
                    <div class="row">
                        <div class="col-2 d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined text-dark m-0 pr-3" style="font-size: 30px;">
                                credit_card
                            </span>
                        </div>
                        <div class="col">
                            <p class="d-block m-0 fs-5 text-dark fw-semibold">
                                Pagamentos
                            </p>
                            <p class="d-block m-0 text-secondary fs-6">
                                Seus cartões cadastrados
                            </p>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-end">
                            <span class="material-symbols-outlined text-dark m-0">
                                chevron_right
                            </span>
                        </div>

                    </div>
                </a>
            </li>
            <!-- FIM ITEM -->

            <!-- ITEM -->
            <li class="list-group-item">
                <a href="" class="text-decoration-none">
                    <div class="row">
                        <div class="col-2 d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined text-dark m-0 pr-3" style="font-size: 30px;">
                                help
                            </span>
                        </div>
                        <div class="col">
                            <p class="d-block m-0 fs-5 text-dark fw-semibold">
                                Ajuda
                            </p>
                            <p class="d-block m-0 text-secondary fs-6">
                                Ajuda e suporte
                            </p>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-end">
                            <span class="material-symbols-outlined text-dark m-0">
                                chevron_right
                            </span>
                        </div>

                    </div>
                </a>
            </li>
            <!-- FIM ITEM -->

            <!-- ITEM -->
            <li class="list-group-item">
                <a href="" class="text-decoration-none">
                    <div class="row">
                        <div class="col-2 d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined text-dark m-0 pr-3" style="font-size: 30px;">
                                account_circle
                            </span>
                        </div>
                        <div class="col">
                            <p class="d-block m-0 fs-5 text-dark fw-semibold">
                                Dados da conta
                            </p>
                            <p class="d-block m-0 text-secondary fs-6">
                                Visualize ou atualize seus dados
                            </p>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-end">
                            <span class="material-symbols-outlined text-dark m-0">
                                chevron_right
                            </span>
                        </div>

                    </div>
                </a>
            </li>
            <!-- FIM ITEM -->

            <!-- ITEM -->
            <li class="list-group-item">
                <a href=" {{ route('cliente.logout') }} " class="text-decoration-none">
                    <div class="row">
                        <div class="col-2 d-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined text-danger m-0 pr-3" style="font-size: 30px;">
                                logout
                            </span>
                        </div>
                        <div class="col">
                            <p class="d-block m-0 fs-5 text-danger fw-semibold">
                                Sair
                            </p>
                            <p class="d-block m-0 text-secondary fs-6">
                                Sair da conta
                            </p>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-end">
                            <span class="material-symbols-outlined text-danger m-0">
                                chevron_right
                            </span>
                        </div>

                    </div>
                </a>
            </li>
            <!-- FIM ITEM -->

        </ul>
        <!-- FIM LISTA -->

    </div>
    <!-- FIM CONTAINER -->
    @endif
    <!-- FIM SE NÃO ESTIVER LOGADO -->

    <!-- MENU APPBAR -->
    <x-appbar-cardapio :data="$data" />
    <!-- FIM MENU APPBAR -->
</x-layout-cardapio>