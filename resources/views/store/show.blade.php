<x-app-layout>

    <!-- CARD -->
    <div class="container-padrao">

        <!-- CARD GERAL -->
        <ul class="nav nav-pills fs-5">
            <li class="nav-item hover">
                <a class="nav-link rounded-0 rounded-top {{request('tab') == null || request('tab') == 'sobre' ? 'bg-white text-padrao fw-bold' : 'text-secondary'}}"
                    aria-current="page" href="?tab=sobre">
                    Sobre a loja
                </a>
            </li>
            <li class="nav-item hover">
                <a class="nav-link rounded-0 rounded-top {{request('tab') != null && request('tab') == 'horarios' ? 'bg-white text-padrao fw-bold' : 'text-secondary'}}"
                    href="?tab=horarios">
                    Horários
                </a>
            </li>
            <li class="nav-item hover">
                <a class="nav-link rounded-0 rounded-top {{request('tab') != null && request('tab') == 'equipe' ? 'bg-white text-padrao fw-bold' : 'text-secondary'}}"
                    href="?tab=equipe">
                    Equipe
                </a>
            </li>
            <li class="nav-item hover">
                <a class="nav-link rounded-0 rounded-top {{request('tab') != null && request('tab') == 'planos' ? 'bg-white text-padrao fw-bold' : 'text-secondary'}}"
                    href="?tab=planos">
                    Planos
                </a>
            </li>
            <li class="nav-item hover">
                <a class="nav-link rounded-0 rounded-top {{request('tab') != null && request('tab') == 'integracoes' ? 'bg-white text-padrao fw-bold' : 'text-secondary'}}"
                    href="?tab=integracoes">
                    Integrações
                </a>
            </li>
        </ul>

        <div class="bg-white shadow-md py-3 mb-3 rounded">

            <!-- VERIFICACAO SEÇOES TAB DA LOJA -->

            <!-- TAB SOBRE LOJA -->
            @if(request('tab') == null || request('tab') == 'sobre')

            <!-- CARDÁPIO DIGITAL -->
            <div class="d-flex align-items-center p-3">
                <div class="border rounded p-3">
                    <span class="material-symbols-outlined text-padrao" style="font-size: 60px">
                        qr_code_scanner
                    </span>
                </div>
                <p class="fs-5 mx-3 my-0">
                    Link para cardápio digital: <a href="{{route('cardapio', ['store_id' => $store->id])}}"
                        class="fw-bold">{{route('cardapio')}}?store_id={{$store->id}}</a>
                </p>

            </div>
            <!-- FIM LINK CARDÁPIO DIGITAL -->

            <!-- LINHA IMAGENS -->
            <div class="row px-3 pt-3">
                <div class="col-sm-6">

                    <!-- LOGO LOJA -->
                    <div class="border p-3 rounded h-100">
                        <p class="fw-bold fs-5">
                            Logo -
                            <a class="fs-6 fw-normal" data-bs-toggle="modal" data-bs-target="#modalEditarLogo">
                                Alterar
                            </a>
                        </p>

                        <img src='{{asset("storage/$store->name/$store->logo")}}' width="150"
                            class="rounded-circle border">

                        <!-- MODAL EDITAR LOGO-->
                        <div class="modal fade" id="modalEditarLogo" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar logo loja</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('store.update_logo', ['store_id' => $store->id])}}" method="post"
                                        autocomplete="off" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="input-group">
                                                <label class="input-group-text" for="inputImagem">Logo</label>
                                                <input type="file"
                                                    class="form-control @error('logo') is-invalid @enderror" name="logo"
                                                    id="inputImagem">
                                            </div>
                                            <p class="text-secondary ml-2">300 x 300 (px)</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <!-- FIM MODAL EDITAR LOGO -->
                    </div>
                    <!-- FIM LOGO LOJA -->

                </div>
                <div class="col-sm-6">

                    <!-- BANNER LOJA -->
                    <div class="border p-3 rounded">
                        <p class="fw-bold fs-5 h-100">
                            Banner -
                            <a class="fs-6 fw-normal" data-bs-toggle="modal" data-bs-target="#modalEditarBanner">
                                Alterar
                            </a>
                        </p>
                        <img src='{{asset("storage/$store->name/banner")}}' class="rounded border" style="width: 150px">

                        <!-- MODAL -->
                        <div class="modal fade" id="modalEditarBanner" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <p class="modal-title fs-5" id="exampleModalLabel">
                                            Editar banner
                                        </p>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('store.update_banner', ['store_id' => $store->id])}}"
                                        method="post" autocomplete="off" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="input-group">
                                                <label class="input-group-text" for="inputBanner">
                                                    Alterar banner da loja
                                                </label>
                                                <input type="file"
                                                    class="form-control @error('banner') is-invalid @enderror"
                                                    name="banner" id="inputBanner">
                                            </div>
                                            <p class="text-secondary ml-2">1280px x 720px | 16/9</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <!-- FIM MODAL -->
                    </div>
                    <!-- FIM BANNER LOJA -->
                </div>
            </div>
            <!-- FIM LINHA IMAGENS -->

            <!-- FORM -->
            <form class="mt-3" action="{{route('store.update', ['store_id' => $store->id, 'tab' => request('tab')])}}"
                method="post" autocomplete="off">
                @method('PUT')
                @csrf

                <!-- INPUTS INFORMAÇÕES GERAIS LOJA -->
                <div class="row my-3 px-3 g-3">

                    <div class="col-md-6">
                        <label for="inputNome" class="form-label fw-bold m-0">Nome da loja</label>
                        <input type="text" name="nome" value="{{!empty($store) ? $store->name : old('nome')}}"
                            class="form-control @error('nome') is-invalid @enderror" id="inputNome" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail" class="form-label fw-bold m-0">Email</label>
                        <input type="text" name="email" value="{{!empty($store) ? $store->email : old('email')}}"
                            class="form-control @error('email') is-invalid @enderror" id="inputEmail">
                    </div>

                    <div class="col-12">
                        <label for="inputDescricao" class="form-label fw-bold m-0">Descrição</label>
                        <textarea rows="2" name="descricao"
                            class="form-control @error('descricao') is-invalid @enderror" id="inputDescricao"
                            required>{{!empty($store) ? $store->description : old('descricao')}}</textarea>
                        <p class="m-0 text-secondary fw-light">
                            Máximo 200 caracteres
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label for="inputTelefone1" class="form-label fw-bold m-0">
                            Telefone 1
                        </label>
                        <input type="text" name="telefone1"
                            value="{{!empty($store) ? $store->phone1 : old('telefone1')}}"
                            class="form-control @error('telefone1') is-invalid @enderror" id="inputTelefone1">
                    </div>
                    <div class="col-md-6">
                        <label for="inputTelefone2" class="form-label fw-bold m-0">
                            Telefone 2
                        </label>
                        <input type="text" name="telefone2"
                            value="{{!empty($store) ? $store->phone2 : old('telefone2')}}"
                            class="form-control @error('telefone2') is-invalid @enderror" id="inputTelefone2">
                    </div>

                </div>
                <!-- FIM INPUTS INFORMAÇÕES GERAIS LOJA -->

                <!-- ENDEREÇO -->
                <h3 class="fw-bold my-3 border-top border-bottom p-3 fs-5 text-padrao">
                    Endereço
                </h3>
                <p class="px-3 fw-light">
                    Preencha o campo CEP primeiramente e clique em buscar que será preenchido automáticamente
                    algumas informações.
                </p>

                <div class="row px-3 g-3">
                    <div class="col-md-6 my-2">
                        <x-label for="cep" value="CEP" />
                        <x-input placeholder="Ex.: 79000-000" id="cep" type="text" name="cep"
                            :value="!empty($store) ? $store->zip_code : old('cep')" autocomplete="off" />

                    </div>
                    <div class="col-md-6 my-2 d-flex align-items-end">
                        <button type="button" class="btn border-padrao text-padrao" onclick="buscarEndereco()">
                            Buscar
                        </button>
                    </div>

                    <div class="col-md-6 my-2">
                        <x-label for="rua" value="Rua" />
                        <x-input placeholder="" readonly id="rua" type="text" name="rua"
                            :value="!empty($store) ? $store->street : old('rua')" autocomplete="off" class="bg-light" />
                    </div>
                    <div class="col-md-6 my-2">
                        <x-label for="bairro" value="Bairro" />
                        <x-input placeholder="" readonly id="bairro" type="text" name="bairro"
                            :value="!empty($store) ? $store->neighborhood : old('bairro')" autocomplete="off"
                            class="bg-light" />
                    </div>

                    <div class="col-md-6 my-2">
                        <x-label for="cidade" value="Cidade" />
                        <x-input placeholder="" readonly id="cidade" type="text" name="cidade"
                            :value="!empty($store) ? $store->city : old('cidade')" autocomplete="off"
                            class="bg-light" />
                    </div>
                    <div class="col-md-6 my-2">
                        <x-label for="estado" value="Estado" />
                        <x-input placeholder="" readonly id="estado" type="text" name="estado"
                            :value="!empty($store) ? $store->state : old('estado')" autocomplete="off"
                            class="bg-light" />
                    </div>

                    <div class="col-md-6 my-2">
                        <x-label for="numero" value="Número" />
                        <x-input placeholder="" id="numero" type="text" name="numero"
                            :value="!empty($store) ? $store->number : old('numero')" autocomplete="off" />
                    </div>
                    <div class="col-md-6 my-2">
                        <x-label for="complemento" value="Complemento" />
                        <x-input placeholder="" id="complemento" type="text" name="complemento"
                            :value="!empty($store) ? $store->complement : old('complemento')" autocomplete="off" />
                    </div>

                </div>
                <!-- FIM ENDEREÇO -->

                <!-- TAXA DE SERVIÇO -->
                <h3 class="fw-bold my-3 border-top border-bottom p-3 fs-5 text-padrao">
                    Taxa de serviço
                </h3>
                <p class="px-3 fw-light">
                    Essa porcentagem será usada para calcular ao fechar um pedido.
                </p>
                <div class="px-3">
                    <label for="inputTaxaServico" class="form-label fw-bold m-0">
                        Valor taxa de serviço (%)
                    </label>
                    <input type="text" name="taxa_servico"
                        value="{{!empty($store) ? $store->service_fee : old('taxa_servico')}}" class="form-control"
                        id="inputTaxaServico" required>
                </div>
                <!-- FIM TAXA DE SERVIÇO -->

                <div class="bg-white p-3 d-flex justify-content-between sticky-bottom">
                    <div class="text-secondary d-flex align-items-center fw-bold">
                        <span class="material-symbols-outlined mr-1">
                            info
                        </span>
                        <p class="m-0">
                            Salve as alterações antes de sair.
                        </p>
                    </div>
                    <button type="submit" class="btn bg-padrao text-white px-5 fw-semibold">
                        Salvar
                    </button>
                </div>

            </form>
            <!-- FORM -->

            <!-- TAB HORARIOS -->
            @elseif(request('tab') != null && request('tab') == 'horarios')

            <div class="px-3">
                <div class="d-flex justify-content-end my-3">
                    <a href="" class="btn bg-padrao text-white fw-bold" data-bs-toggle="modal"
                        data-bs-target="#modalAdicionarHorario">
                        Cadastrar horário
                    </a>
                </div>

                <!-- MODAL -->
                <div class="modal fade" id="modalAdicionarHorario" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p class="modal-title fs-5" id="exampleModalLabel">
                                    Adicionar horário
                                </p>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">

                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label for="inputCep" class="form-label fw-bold m-0">CEP</label>
                                            <input type="text" name="cep"
                                                value="{{!empty($store) ? $store->zip_code : old('cep')}}" class="form-control"
                                                id="inputCep" required>
                                        </div>
                                        <div class="col-3">
                                            <label for="inputHoraAbertura" class="form-label fw-bold m-0">Começa
                                                em</label>
                                            <input type="time" name="hora_fechamento" class="form-control"
                                                id="inputHoraAbertura" required>
                                        </div>
                                        <div class="col-3">
                                            <label for="inputHoraFechamento" class="form-label fw-bold m-0">Começa
                                                em</label>
                                            <input type="time" name="hora_abertura" class="form-control"
                                                id="inputHoraFechamento" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- FIM MODAL -->

                <div id='calendar'></div>
            </div>

            <!-- TAB EQUIPE -->
            @elseif(request('tab') != null && request('tab') == 'equipe')

            <div class="px-3">

                <!-- HEADER EQUIPE -->
                <div class="d-flex justify-content-between py-3">
                    <div class="input-group w-50">
                        <input type="text" class="form-control" placeholder="Nome" aria-label="Nome"
                            aria-describedby="btn-procurar">
                        <button class="btn btn-outline-dark" type="button" id="btn-procurar">Buscar</button>
                    </div>
                    <div class="">
                        <a href="" class="btn bg-padrao text-white fw-bold">
                            Adicionar usuário
                        </a>
                    </div>
                </div>
                <!-- FIM HEADER EQUIPE -->

                <!-- TABLE EQUIPE -->
                @if($dados['equipe'] != null)
                <table class="table border-top">
                    <thead class="fs-5">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Nível de acesso</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados['equipe'] as $colaborador)
                        <tr>
                            <td>
                                #0{{$colaborador->id}}
                            </td>
                            <td>
                                <p class="m-0 fw-semibold">
                                    {{$colaborador->user->name}}
                                </p>
                                <p class="m-0 text-secondary">
                                    {{$colaborador->user->email}}
                                </p>
                            </td>
                            <td>
                                {{$colaborador->cargo}}
                            </td>
                            <td>
                                {{$colaborador->nivel_acesso}}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="border rounded p-2 d-flex aling-items-center" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-symbols-outlined">
                                            more_vert
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                <!-- FIM TABLE EQUIPE -->

                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>

            <!-- TAB PLANOS -->
            @elseif(request('tab') != null && request('tab') == 'planos')

            <!-- LINHA -->
            <div class="row g-3 m-3">

                <!-- COLUNA -->
                <div class="col-lg-3">

                    <!-- CARD PLANO GRATUITO-->
                    <div class="card h-100">
                        <div class="border-bottom text-center">
                            <p class="m-0 fw-bold fs-5">
                                Gratuito
                            </p>
                        </div>
                        <div class="d-flex justify-content-center align-items-end mt-4">
                            <p class="text-dark fw-bold fs-1 m-0 mx-1">
                                R$ 0,00
                                <span class="text-secondary fs-6 m-0 fw-medium">/mês</span>
                            </p>
                        </div>
                        <p class="text-secondary fw-normal px-3 text-center" style="font-size: 14px">
                            *Use o plano gratuito por tempo ilimitado sem precisar cadastrar formas de pagamento.
                        </p>
                        <a href="" class="btn bg-padrao text-white fw-semibold mx-3 my-3">
                            Escolher
                        </a>
                        <hr class="mx-3">
                        <ul class="mx-3">
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Suporte via email.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Receba até 50 pedidos por mês.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Cardápio digital completo, somente para delivery.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Integração completa com iFood.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Gestor de pedidos e gestor de mesas.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Tela de preparo (KDS).
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Impressão automáticas de pedidos.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Mapa para controle de mesas.
                                </p>
                            </li>
                        </ul>
                    </div>
                    <!-- FIM CARD PLANO GRATUITO -->

                </div>
                <!-- FIM COLUNA -->

                <!-- COLUNA -->
                <div class="col-lg-3">

                    <!-- CARD PLANO STANDART -->
                    <div class="card h-100">
                        <div class="border-bottom text-center">
                            <p class="m-0 fw-bold fs-5">
                                Standard
                            </p>
                        </div>
                        <p class="mt-3 mb-0 mx-3 text-secondary text-decoration-line-through fw-semibold fs-5">
                            R$ 99,90
                        </p>
                        <div class="mx-3">
                            <p class="text-dark fw-bold fs-1 m-0 mx-1">
                                <span class="text-secondary fs-6 m-0 fw-medium">12x</span>
                                R$ 64,90
                                <span class="text-secondary fs-6 m-0 p-0 fw-medium">/mês</span>
                            </p>
                        </div>
                        <p class="text-secondary fw-normal mx-3" style="font-size: 14px">
                            *Economize 35% no plano anual.
                        </p>
                        <a href="" class="btn bg-padrao text-white fw-semibold mx-3 my-3">
                            Escolher
                        </a>
                        <hr class="mx-3">
                        <ul class="mx-3">
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    stars
                                </span>
                                <p class="m-0 fw-bold">
                                    Todos benefícios do plano Gratuito e mais:
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Suporte via WhatsApp e email.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Pedidos ilimitados.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Cardápio digital completo: delivery, retirada e no local.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Integração completa com iFood.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Gestor de pedidos e gestor de mesas.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Emissão de notas fiscais.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Tela de preparo (KDS).
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Financeiro completo.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Sistema de frente de caixa (PDV).
                                </p>
                            </li>
                        </ul>
                    </div>
                    <!-- FIM CARD PLANO STANDART -->

                </div>
                <!-- FIM COLUNA -->

                <!-- COLUNA -->
                <div class="col-lg-3">

                    <!-- CARD PLANO BUSINESS -->
                    <div class="card h-100">
                        <div class="border-bottom text-center">
                            <p class="m-0 fs-5 fw-bold">
                                Business
                            </p>
                        </div>
                        <p class="mt-3 mb-0 mx-3 text-secondary text-decoration-line-through fw-semibold fs-5">
                            R$ 199,90
                        </p>
                        <div class="mx-3">
                            <p class="text-dark fw-bold fs-1 m-0 mx-1">
                                <span class="text-secondary fs-6 m-0 fw-medium">12x</span>
                                R$ 149,90
                                <span class="text-secondary fs-6 m-0 p-0 fw-medium">/mês</span>
                            </p>
                        </div>
                        <p class="text-secondary fw-normal mx-3" style="font-size: 14px">
                            *Economize 25% no plano anual.
                        </p>
                        <a href="" class="btn bg-padrao text-white fw-semibold mx-3 my-3">
                            Escolher
                        </a>
                        <hr class="mx-3">
                        <ul class="mx-3">
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    stars
                                </span>
                                <p class="m-0 fw-bold">
                                    Todos benefícios do plano Standard e mais:
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Suporte prioritário via WhatsApp e email.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Aplicativo para garçons (IOS e Android).
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Gestor de estoque.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Relatórios, gráficos e estatísticas de dados financeiros, vendas e pedidos.
                                </p>
                            </li>
                        </ul>
                    </div>
                    <!-- FIM CARD PLANO BUSINESS -->

                </div>
                <!-- FIM COLUNA -->

                <!-- COLUNA -->
                <div class="col-lg-3">

                    <!-- CARD PLANO BUSINESS -->
                    <div class="card bg-dark text-white h-100">
                        <div class="border-bottom text-center">
                            <p class="m-0 fs-5 fw-bold">
                                Ultra
                            </p>
                        </div>
                        <p class="mt-3 mb-0 mx-3 text-white-50 text-decoration-line-through fw-semibold fs-5">
                            R$ 489,90
                        </p>
                        <div class="mx-3">
                            <p class="text-white fw-bold fs-1 m-0 mx-1">
                                <span class="text-white-50 fs-6 m-0 fw-medium">12x</span>
                                R$ 399,90
                                <span class="text-white-50 fs-6 m-0 p-0 fw-medium">/mês</span>
                            </p>
                        </div>
                        <p class="text-white-50 fw-normal mx-3" style="font-size: 14px">
                            *Economize 18% no plano anual.
                        </p>
                        <a href="" class="btn btn-light text-padrao fw-semibold mx-3 my-3">
                            Escolher
                        </a>
                        <hr class="mx-3">
                        <ul class="mx-3">
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    stars
                                </span>
                                <p class="m-0 fw-bold">
                                    Todos benefícios do plano Business e mais:
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Suporte exclusivo via WhatsApp, email e chamadas de vídeo.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal text-warning">
                                    Aplicativo personalizado para sua loja com sua marca.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Aplicativo para garçons (IOS e Android) com recursos exclusivos de gestão para
                                    administradores.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Gestor de estoque com avisos no painel e mensagem WhatsApp sobre reposição de
                                    insumos.
                                </p>
                            </li>
                        </ul>
                    </div>
                    <!-- FIM CARD PLANO BUSINESS -->

                </div>
                <!-- FIM COLUNA -->

            </div>
            <!-- FIM LINHA -->

            <!-- TAB SOBRE INTEGRACOES -->
            @elseif(request('tab') != null && request('tab') == 'integracoes')

            @if($store->ifood_merchant_id != null)

            <!-- LINHA -->
            <div class="row p-3">

                <!-- COLUNA -->
                <div class="col-sm-6 my-auto">

                    <div class="my-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/90/IFood_logo.svg/2560px-IFood_logo.svg.png"
                            alt="logo iFood" width="150px" class="mx-auto">
                    </div>

                    <div class="d-flex align-items-center justify-content-center my-3">
                        <span class="material-symbols-outlined fill-icon mr-2 text-success">
                            check_circle
                        </span>
                        <p class="m-0 fw-bold fs-5">
                            Integração iFood realizada.
                        </p>
                    </div>


                </div>
                <!-- FIM COLUNA -->

                <!-- COLUNA -->
                <div class="col-sm-6 my-auto">

                    <div class="card p-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Merchant ID</th>
                                    <th scope="col">Criação token</th>
                                    <th scope="col">Expiração token</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {{$store->ifood_merchant_id}}
                                    </td>
                                    <td>
                                        @if($dados['token'] != null)
                                        {{\Carbon\Carbon::parse($dados['token']->created_at)->format('d/m/Y')}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($dados['token'] != null)
                                        {{\Carbon\Carbon::parse($dados['token']->created_at)->addDays(7)->format('d/m/Y')}}
                                        @endif
                                    </td>
                                    <td>
                                        On
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- FIM COLUNA -->

            </div>
            <!-- FIM LINHA -->

            @else

            <!-- LINHA -->
            <div class="row p-3">

                <!-- COLUNA -->
                <div class="col-sm-6 my-auto">

                    <div class="card p-3 w-75 mx-auto">
                        <p class="fs-3 fw-bold m-0">
                            Vamos começar a integração com iFood?
                        </p>
                        <p class="text-secondary">
                            É bem simples, não leva 5 minutos e vai facilitar muitoooo sua vida.
                        </p>
                        <a href="{{route('store.create_integration_ifood')}}"
                            class="btn bg-padrao text-white fw-semibold w-100">
                            Iniciar
                        </a>
                    </div>

                </div>
                <!-- FIM COLUNA -->

                <!-- COLUNA -->
                <div class="col-sm-6">

                    <div class="">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/90/IFood_logo.svg/2560px-IFood_logo.svg.png"
                            alt="logo iFood" width="150px" class="mx-auto">
                    </div>

                    <ul class="mx-3">
                        <li class="d-flex align-items-center my-3">
                            <p class="m-0 fw-semibold">
                                Vantagens:
                            </p>
                        </li>
                        <li class="d-flex align-items-center my-3">
                            <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                check
                            </span>
                            <p class="m-0 fw-normal">
                                Receba pedidos e gerencie vindos do iFood.
                            </p>
                        </li>
                        <li class="d-flex align-items-center my-3">
                            <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                check
                            </span>
                            <p class="m-0 fw-normal">
                                Solicite entregador para seus pedidos.
                            </p>
                        </li>
                        <li class="d-flex align-items-center my-3">
                            <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                check
                            </span>
                            <p class="m-0 fw-normal">
                                Importe o seu cardápio e horários direito do iFood.
                            </p>
                        </li>
                        <li class="d-flex align-items-center my-3">
                            <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                check
                            </span>
                            <p class="m-0 fw-normal">
                                Ao usar o Gestor de Pedidos do Foomy, automáticamente, você mantêm a sua Loja do iFood
                                aberta para receber pedidos.
                            </p>
                        </li>
                    </ul>

                </div>
                <!-- FIM COLUNA -->

            </div>
            <!-- FIM LINHA -->

            @endif

            @endif
            <!-- FIM VERIFICACAO SEÇOES TAB DA LOJA -->

        </div>
        <!-- FIM CARD GERAL -->

    </div>
    <!-- FIM CARD -->

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales-all.global.min.js" defer></script>

    <script>
    //Calendário Horarios funcionamento
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'pt-br',
            initialView: 'dayGridWeek', // Exibe os dias da semana
            headerToolbar: false, // Oculta o cabeçalho padrão
            footerToolbar: false, // Remove o rodapé
            dayHeaderFormat: {
                weekday: 'long'
            }, // Exibe apenas os nomes dos dias
            contentHeight: 'auto', // Ajusta o tamanho
            events: [], // Use essa propriedade para adicionar eventos, se necessário
            editable: false, // Desabilita a edição
            selectable: false // Desabilita seleção de datas
        });
        calendar.render();
    });

    // Função para buscar endereço pelo CEP
    async function buscarEndereco() {
        const cep = document.getElementById('inputCep').value.replace(/\D/g, '');
        if (cep.length !== 8) {
            alert('CEP inválido!');
            return;
        }
        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();
            if (!data.erro) {
                document.getElementById('inputRua').value = data.logradouro;
                document.getElementById('inputBairro').value = data.bairro;
                document.getElementById('inputCidade').value = data.localidade;
                document.getElementById('inputEstado').value = data.uf;
                document.getElementById('inputComplemento').value = data.complemento;
            } else {
                alert('CEP não encontrado!');
            }
        } catch (error) {
            alert('Erro ao buscar o CEP!');
        }
    }

    // Função para aplicar a máscara de telefone
    function aplicarMascaraTelefone(inputId) {
        const input = document.getElementById(inputId);

        input.addEventListener('input', function(e) {
            let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
            let formattedValue = '';

            if (value.length > 0) {
                formattedValue = '(' + value.slice(0, 2);

                if (value.length > 2) {
                    formattedValue += ') ' + value.slice(2, 7);
                }

                if (value.length > 7) {
                    formattedValue += '-' + value.slice(7, 11);
                }
            }

            input.value = formattedValue;
        });
    }
    // Aplicar a máscara para os campos de telefone 1 e telefone 2
    aplicarMascaraTelefone('inputTelefone1');
    aplicarMascaraTelefone('inputTelefone2');
    </script>
</x-app-layout>