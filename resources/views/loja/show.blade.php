<x-app-layout>

    <!-- CARD -->
    <div class="container">

        <!-- HEADER -->
        <h2 class="my-3 fw-bolder fs-1">
            Loja
        </h2>
        <!-- FIM HEADER -->

        <!-- MENSAGENS -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- FIM MENSAGENS -->



        <!-- CARD GERAL -->
        <ul class="nav nav-pills fs-5">
            <li class="nav-item">
                <a class="nav-link rounded-0 rounded-top {{request('tab') == null || request('tab') == 'sobre' ? 'bg-white text-padrao fw-bold' : 'text-secondary'}}"
                    aria-current="page" href="?tab=sobre">
                    Sobre a loja
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-0 rounded-top {{request('tab') != null && request('tab') == 'horarios' ? 'bg-white text-padrao fw-bold' : 'text-secondary'}}"
                    href="?tab=horarios">
                    Horários
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-0 rounded-top {{request('tab') != null && request('tab') == 'equipe' ? 'bg-white text-padrao fw-bold' : 'text-secondary'}}"
                    href="?tab=equipe">
                    Equipe
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-0 rounded-top {{request('tab') != null && request('tab') == 'planos' ? 'bg-white text-padrao fw-bold' : 'text-secondary'}}"
                    href="?tab=planos">
                    Planos
                </a>
            </li>
            <li class="nav-item">
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
                <div class="col-sm-6">

                    <!-- LOGO LOJA -->
                    <div class="border p-3 rounded h-100">
                        <p class="fw-bold fs-5">
                            Logo -
                            <a class="fs-6 fw-normal" data-bs-toggle="modal" data-bs-target="#modalEditarLogo">
                                Alterar
                            </a>
                        </p>

                        <img src='{{asset("storage/$loja->nome/$loja->logo")}}' width="150" alt="Logo {{$loja->nome}}"
                            class="shadow-sm rounded-circle">

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
                                    <form action="{{'/loja/alterar-logo/' . $loja->id}}" method="post"
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
                        <img src='{{asset("storage/$loja->nome/banner")}}' class="rounded border p-0"
                            style="width: 300px">

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
                                    <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="input-group">
                                                <label class="input-group-text" for="inputBanner">Alterar
                                                    banner</label>
                                                <input type="file"
                                                    class="form-control @error('banner') is-invalid @enderror"
                                                    name="banner" id="inputBanner">
                                            </div>
                                            <p class="text-secondary ml-2">800 x 400 (px)</p>
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
            <form class="mt-3" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf

                <!-- INPUTS INFORMAÇÕES GERAIS LOJA -->
                <div class="row my-3 px-3 g-3">

                    <div class="col-md-6">
                        <label for="inputNome" class="form-label fw-bold m-0">Nome da loja</label>
                        <input type="text" name="nome" value="{{!empty($loja) ? $loja->nome : old('nome')}}"
                            class="form-control @error('nome') is-invalid @enderror" id="inputNome" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail" class="form-label fw-bold m-0">Email</label>
                        <input type="text" name="email" value="{{!empty($loja) ? $loja->email : old('email')}}"
                            class="form-control @error('email') is-invalid @enderror" id="inputEmail" required>
                    </div>

                    <div class="col-12">
                        <label for="inputDescricao" class="form-label fw-bold m-0">Descrição</label>
                        <textarea rows="2" name="descricao"
                            class="form-control @error('descricao') is-invalid @enderror" id="inputDescricao"
                            required>{{!empty($loja) ? $loja->descricao : old('descricao')}}</textarea>
                        <p class="m-0 text-secondary fw-light">
                            Máximo 200 caracteres
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label for="inputTelefone1" class="form-label fw-bold m-0">
                            Telefone 1
                        </label>
                        <input type="text" name="telefone1"
                            value="{{!empty($loja) ? $loja->telefone1 : old('telefone1')}}"
                            class="form-control @error('telefone1') is-invalid @enderror" id="inputTelefone1">
                    </div>
                    <div class="col-md-6">
                        <label for="inputTelefone2" class="form-label fw-bold m-0">
                            Telefone 2
                        </label>
                        <input type="text" name="telefone2"
                            value="{{!empty($loja) ? $loja->telefone2 : old('telefone2')}}"
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
                    <div class="col-5">
                        <label for="inputCep" class="form-label fw-bold m-0">CEP</label>
                        <input type="text" name="cep" value="{{!empty($loja) ? $loja->cep : old('cep')}}"
                            class="form-control" id="inputCep" required>
                    </div>
                    <div class="col-7 d-flex align-item-end">
                        <button type="button" class="btn border-padrao text-padrao" onclick="buscarEndereco()">
                            Buscar
                        </button>
                    </div>

                    <div class="col-md-5">
                        <label for="inputRua" class="form-label fw-bold m-0">Rua</label>
                        <input type="text" name="rua" value="{{!empty($loja) ? $loja->rua : old('rua')}}"
                            class="form-control" id="inputRua" required>
                    </div>
                    <div class="col-md-5">
                        <label for="inputBairro" class="form-label fw-bold m-0">Bairro</label>
                        <input type="text" name="bairro" value="{{!empty($loja) ? $loja->bairro : old('bairro')}}"
                            class="form-control" id="inputBairro" required>
                    </div>
                    <div class="col-md-2">
                        <label for="inputNumero" class="form-label fw-bold m-0">Número</label>
                        <input type="text" name="numero" value="{{!empty($loja) ? $loja->numero : old('numero')}}"
                            class="form-control" id="inputNumero" required>
                    </div>
                    <div class="col-md-5">
                        <label for="inputComplemento" class="form-label fw-bold m-0">Complemento</label>
                        <input type="text" name="complemento"
                            value="{{!empty($loja) ? $loja->complemento : old('complemento')}}" class="form-control"
                            id="inputComplemento">
                    </div>
                    <div class="col-md-5">
                        <label for="inputCidade" class="form-label fw-bold m-0">Cidade</label>
                        <input type="text" name="cidade" value="{{!empty($loja) ? $loja->cidade : old('cidade')}}"
                            class="form-control" id="inputCidade" required>
                    </div>
                    <div class="col-md-2">
                        <label for="inputEstado" class="form-label fw-bold m-0">Estado</label>
                        <input type="text" name="estado" value="{{!empty($loja) ? $loja->estado : old('estado')}}"
                            class="form-control" id="inputEstado" required>
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
                        value="{{!empty($loja) ? $loja->taxa_servico : old('taxa_servico')}}" class="form-control"
                        id="inputTaxaServico" required>
                </div>
                <!-- FIM TAXA DE SERVIÇO -->

                <div class="bg-white p-3 d-flex justify-content-end sticky-bottom">
                    <button type="submit" class="btn bg-padrao text-white px-5 fw-semibold">
                        Salvar
                    </button>
                </div>

            </form>
            <!-- FORM -->

            <!-- TAB SOBRE HORARIOS -->
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
                                                value="{{!empty($loja) ? $loja->cep : old('cep')}}" class="form-control"
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

            <!-- TAB SOBRE EQUIPE -->
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

            <!-- TAB SOBRE PLANOS -->
            @elseif(request('tab') != null && request('tab') == 'planos')

            <!-- TAB SOBRE INTEGRACOES -->
            @elseif(request('tab') != null && request('tab') == 'integracoes')

            @endif
            <!-- FIM VERIFICACAO SEÇOES TAB DA LOJA -->

        </div>
        <!-- FIM CARD GERAL -->

    </div>
    <!-- FIM CARD -->

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales-all.global.min.js"></script>

    <script>
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
    </script>
</x-app-layout>