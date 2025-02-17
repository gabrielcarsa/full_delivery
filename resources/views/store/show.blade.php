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

            <!-- LINHA IMAGENS -->
            <div class="row px-3 pt-3">
                <div class="col-sm-4">
                    <div class="border p-3 rounded h-100">
                        <p class="fw-bold fs-5">
                            QrCode para cardápio digital
                        </p>
                        <img src="{{ $dados['dataUri'] }}" alt="QR Code" width="150px">
                    </div>
                </div>
                <div class="col-sm-4">

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
                                    <form action="{{route('store.update_logo', ['store_id' => $store->id])}}"
                                        method="post" autocomplete="off" enctype="multipart/form-data">
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
                <div class="col-sm-4">

                    <!-- BANNER LOJA -->
                    <div class="border p-3 rounded h-100">
                        <p class="fw-bold fs-5">
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
            <form class="mt-3" action="{{route('store.update', ['store' => $store->id, 'tab' => request('tab')])}}"
                method="post" autocomplete="off">
                @method('PUT')
                @csrf

                <!-- INPUTS INFORMAÇÕES GERAIS LOJA -->
                <div class="row my-3 px-3 g-3">

                    <div class="col-md-6">
                        <x-label for="nome" value="Nome da loja" />
                        <x-input id="nome" type="text" name="nome" required
                            :value="!empty($store) ? $store->name : old('nome')" autocomplete="off" />
                    </div>
                    <div class="col-md-6">
                        <x-label for="email" value="Email" />
                        <x-input type="text" name="email" value="{{!empty($store) ? $store->email : old('email')}}"
                            id="email" />
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
                        <x-label for="telefone1" value="Telefone 1" />
                        <x-input type="text" name="telefone1"
                            value="{{!empty($store) ? $store->phone1 : old('telefone1')}}" id="telefone1" />
                    </div>
                    <div class="col-md-6">
                        <x-label for="telefone2" value="Telefone 2" />
                        <x-input type="text" name="telefone2"
                            value="{{!empty($store) ? $store->phone2 : old('telefone2')}}" id="telefone2" />
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
                    <x-label for="taxa_servico" value="Valor taxa de serviço (%)" />
                    <x-input type="text" name="taxa_servico"
                        value="{{!empty($store) ? $store->service_fee : old('taxa_servico')}}" id="taxa_servico"
                        required />
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
                <p class="text-secondary">
                    Para excluir um horário basta clicar sobre ele.
                </p>
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
                            <form action="{{route('store_opening_hours.store', ['store_id' => $store->id])}}"
                                method="post" autocomplete="off">
                                @csrf
                                <div class="modal-body">

                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label for="day_of_week" class="form-label fw-bold m-0">
                                                Dia da semana
                                            </label>
                                            <select class="form-select" aria-label="" id="day_of_week"
                                                name="day_of_week">
                                                <option selected>-- Selecione uma opção --</option>
                                                <option value="MONDAY">Segunda-feira</option>
                                                <option value="TUESDAY">Terça-feira</option>
                                                <option value="WEDNESDAY">Quarta-feira</option>
                                                <option value="THURSDAY">Quinta-feira</option>
                                                <option value="FRIDAY">Sexta-feira</option>
                                                <option value="SATURDAY">Sábado</option>
                                                <option value="SUNDAY">Domingo</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <x-label for="opening_time" value="Começa em" />
                                            <x-input type="time" name="opening_time" id="opening_time" required />
                                        </div>
                                        <div class="col-3">
                                            <x-label for="closing_time" value="Termina em" />
                                            <x-input type="time" name="closing_time" id="closing_time" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <x-button class="">
                                        Cadastrar
                                    </x-button>
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

                        <form action="{{ route('store.show', ['store' => $store]) }}" method="get">
                            @csrf
                            <div class="d-flex">
                                <input type="hidden" name="tab" value="equipe">
                                <x-input type="text" name="name_email_store_user" placeholder="Nome ou email"
                                    aria-describedby="btn-procurar" autocomplete="off"
                                    value="{{request('name_email_store_user')}}" />
                                <button class="btn border" type="submit" id="btn-procurar">Buscar</button>
                            </div>

                        </form>
                    </div>
                    <div class="">
                        <a href="" class="btn bg-padrao text-white fw-bold" data-bs-toggle="modal"
                            data-bs-target="#modalCreateStoreUser">
                            Convidar usuário
                        </a>
                    </div>
                    <!-- MODAL -->
                    <div class="modal modal-lg fade" id="modalCreateStoreUser" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p class="modal-title fs-5" id="exampleModalLabel">
                                        Convidar usuário
                                    </p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{route('store_users.invite_user', ['store_id' => $store->id])}}"
                                    method="post" autocomplete="off">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="card p-3 text-secondary">
                                            <div class="d-flex align-items-center">
                                                <span class="material-symbols-outlined mr-2 fw-light">
                                                    info
                                                </span>
                                                <p class="m-0 fw-light">
                                                    O convidado receberá um email com botão para aceitar o convite.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="row g-3 mt-2">
                                            <div class="col-12">
                                                <x-label for="username" value="Nome" />
                                                <x-input type="text" name="username" id="username"
                                                    placeholder="Ex.: Gabriel" required />
                                            </div>
                                            <div class="col-12">
                                                <x-label for="email" value="Email" />
                                                <x-input type="email" name="email" id="email"
                                                    placeholder="Ex.: exemplo@ex.com" required />
                                            </div>
                                            <div class="col-12">
                                                <x-label for="position" value="Cargo" />
                                                <x-input type="text" name="position" id="position"
                                                    placeholder="Ex.: Cozinheiro" required />
                                            </div>
                                            <div class="col-12">
                                                <p class="m-0 fw-semibold">
                                                    Nível de acesso
                                                </p>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="access_level"
                                                        id="ADMIN" value="ADMIN">
                                                    <label class="form-check-label fw-semibold" for="ADMIN">
                                                        Administrador -
                                                        <span class="text-secondary fw-regular">
                                                            Acesso total, incluindo alterações e exclusões
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="access_level"
                                                        id="MANAGER" value="MANAGER">
                                                    <label class="form-check-label fw-semibold" for="MANAGER">
                                                        Gerente -
                                                        <span class="text-secondary fw-regular">
                                                            Acesso total, com restrições à seções do Financeiro e da
                                                            Loja
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="access_level"
                                                        id="FINANCE" value="FINANCE">
                                                    <label class="form-check-label fw-semibold" for="FINANCE">
                                                        Financeiro -
                                                        <span class="text-secondary fw-regular">
                                                            Acesso total a seção Financeiro, com restrições à exclusões
                                                            do Financeiro e alterações da seção da Loja
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="access_level"
                                                        id="USER" value="USER" checked>
                                                    <label class="form-check-label fw-semibold" for="USER">
                                                        Colaborador -
                                                        <span class="text-secondary fw-regular">
                                                            Acesso restrito as seções de Pedidos
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <x-button class="">
                                            Enviar convite
                                        </x-button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <!-- FIM MODAL -->
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
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados['equipe'] as $colaborador)
                        <tr>
                            <td class="{{$colaborador->is_active == false ? 'bg-danger-subtle' : ''}}">
                                #0{{$colaborador->id}}
                            </td>
                            <td class="{{$colaborador->is_active == false ? 'bg-danger-subtle' : ''}}">
                                <p class="m-0 fw-semibold">
                                    {{$colaborador->user->name}}
                                </p>
                                <p class="m-0 text-secondary">
                                    {{$colaborador->user->email}}
                                </p>
                            </td>
                            <td class="{{$colaborador->is_active == false ? 'bg-danger-subtle' : ''}}">
                                {{$colaborador->position}}
                            </td>
                            <td class="{{$colaborador->is_active == false ? 'bg-danger-subtle' : ''}}">
                                {{$colaborador->access_level}}
                            </td>
                            @if($colaborador->is_active)
                            <td class="{{$colaborador->is_active == false ? 'bg-danger-subtle' : ''}}">
                                <span class="material-symbols-outlined fill-icon text-success">
                                    check_circle
                                </span>
                            </td>
                            @else
                            <td class="{{$colaborador->is_active == false ? 'bg-danger-subtle' : ''}}">
                                <span class="material-symbols-outlined fill-icon text-danger">
                                    cancel
                                </span>
                            </td>
                            @endif
                            <td class="{{$colaborador->is_active == false ? 'bg-danger-subtle' : ''}}">
                                <div class="dropdown">
                                    <button class="border rounded p-2 d-flex aling-items-center" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-symbols-outlined">
                                            more_vert
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('store_users.edit', ['store_user' => $colaborador]) }}">
                                                Editar
                                            </a>
                                        </li>
                                        <li>

                                            <a href="" data-bs-toggle="modal"
                                                class="dropdown-item {{$colaborador->is_active == false ? 'text-success' : 'text-danger'}}"
                                                data-bs-target="#deleteStoreUserModal{{$colaborador->id}}">
                                                {{$colaborador->is_active == false ? 'Ativar' : 'Desativar'}} usuário
                                            </a>

                                        </li>
                                    </ul>

                                    <!-- MODAL DESATIVAR USUÁRIO -->
                                    <div class="modal fade" id="deleteStoreUserModal{{$colaborador->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5">
                                                        {{$colaborador->is_active == false ? 'Ativar' : 'Desativar'}}
                                                        {{$colaborador->user->name}}
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        @if($colaborador->is_active)
                                                        Ao desativar usuário ele não terá mais acesso a sua
                                                        loja.
                                                        @else
                                                        Ao ativar usuário ele voltará a ter acesso a sua loja
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn border"
                                                        data-bs-dismiss="modal">Fechar</button>
                                                    <form
                                                        action="{{route('store_users.active_disable', ['id' => $colaborador])}}"
                                                        method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="btn {{$colaborador->is_active == false ? 'btn-success' : 'btn-danger'}}">
                                                            {{$colaborador->is_active == false ? 'Ativar' : 'Desativar'}}
                                                            usuário
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END MODAL DESATIVAR USUÁRIO -->

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                <!-- FIM TABLE EQUIPE -->

                @if ($dados['equipe']->hasPages())
                <div>
                    {{ $dados['equipe']->links() }}
                </div>
                @endif

            </div>

            <!-- TAB PLANOS -->
            @elseif(request('tab') != null && request('tab') == 'planos')

            <!-- LINHA -->
            <div class=" row g-3 m-3">

                <!-- COLUNA -->
                <div class="col-lg-3">

                    <!-- CARD PLANO GRATUITO-->
                    <div class="card h-100">
                        <div class="border-bottom text-center">
                            <p class="m-0 fw-bold fs-5">
                                Gratuito
                            </p>
                        </div>
                        <p class="mt-3 mb-0 mx-3 text-secondary fw-semibold fs-5">
                            Use por tempo ilimitado!
                        </p>
                        <div class="mx-3">
                            <p class="text-dark fw-bold fs-1 m-0 mx-1">
                                R$ 0,00
                            </p>
                        </div>
                        <p class="text-secondary fw-normal mx-3" style="font-size: 14px">
                            Sem precisar cadastrar cartões.
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
                                    Cardápio digital completo: delivery, retirada e no
                                    local.
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
                                    Relatórios, gráficos e estatísticas de dados
                                    financeiros, vendas e pedidos.
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
                                    Suporte exclusivo via WhatsApp, email e chamadas de
                                    vídeo.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal text-warning">
                                    Aplicativo personalizado para sua loja com sua
                                    marca.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Aplicativo para garçons (IOS e Android) com recursos
                                    exclusivos de gestão para
                                    administradores.
                                </p>
                            </li>
                            <li class="d-flex align-items-center my-3">
                                <span class="material-symbols-outlined fs-5 text-padrao mr-2">
                                    check
                                </span>
                                <p class="m-0 fw-normal">
                                    Gestor de estoque com avisos no painel e mensagem
                                    WhatsApp sobre reposição de
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
                                Ao usar o Gestor de Pedidos do Foomy, automáticamente, você mantêm a
                                sua Loja do iFood
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

        // Pegando os eventos do PHP convertidos para JSON
        var events = <?php echo $dados['events']; ?>;

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'pt-br',
            initialView: 'timeGridWeek', // Exibe os horários ao longo da semana
            dayHeaderFormat: {
                weekday: 'long'
            },
            headerToolbar: false, // Oculta o cabeçalho padrão
            footerToolbar: false, // Remove o rodapé
            contentHeight: 'auto', // Ajusta o tamanho
            slotMinTime: "06:00:00", // Define o horário mínimo mostrado no calendário
            slotMaxTime: "23:00:00", // Define o horário máximo mostrado no calendário
            allDaySlot: false, // Remove a linha de eventos o dia todo
            events: events, // Insere os eventos da loja
            editable: false, // Impede edição dos eventos
            selectable: false, // Impede seleção de horários
            eventClick: function(info) {
                if (confirm("Tem certeza que deseja excluir este horário de funcionamento?")) {
                    fetch('/store_opening_hours/' + info.event.id, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                            } // Token CSRF do Laravel
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                info.event.remove(); // Remove visualmente do calendário
                                alert("Horário excluído com sucesso!");
                            } else {
                                alert("Erro ao excluir o horário.");
                            }
                        })
                        .catch(error => {
                            console.error("Erro:", error);
                            alert("Erro na comunicação com o servidor.");
                        });
                }
            }

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

        if (input) {
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

    }
    // Aplicar a máscara para os campos de telefone 1 e telefone 2
    aplicarMascaraTelefone('telefone1');
    aplicarMascaraTelefone('telefone2');
    </script>
</x-app-layout>