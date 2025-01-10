<x-app-layout>

    <div class="container">
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

        <!-- HEADER -->
        <div class="row">
            <div class="col">
                <h2 class="my-3 fw-bolder fs-1">Selecione uma Loja</h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn bg-padrao text-white m-0 py-1 px-5 fw-bold d-flex align-items-center justify-content-center"
                    href="{{route('loja.editar')}}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Cadastrar Loja
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->


        <!-- LOJAS -->
        @if($lojas)

        @foreach($lojas as $loja)
        <div
            class="row align-items-center border-3 bg-white p-3 rounded m-3"  style="{{ session('lojaConectado') && session('lojaConectado')['id'] == $loja->id ? 'border-color: #FD0146 !important' : '' }}">
            <div class="col-2">

                <!-- BTN EDITAR IMG -->
                <a class="position-absolute p-1 text-white rounded d-flex align-items-center text-decoration-none" style="background-color: #FD0146 !important" data-bs-toggle="modal"
                    data-bs-target="#modalEditarImagem">
                    <span class="material-symbols-outlined">
                        edit
                    </span>
                </a>
                <!-- FIM BTN EDITAR IMG -->

                <!-- MODAL -->
                <div class="modal fade" id="modalEditarImagem" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar logo loja</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{'/loja/alterar-logo/' . $loja->id}}" method="post" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="input-group">
                                        <label class="input-group-text" for="inputImagem">Logo</label>
                                        <input type="file" class="form-control @error('imagem') is-invalid @enderror"
                                            name="logo" id="inputImagem">
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
                <!-- FIM MODAL -->

                <!-- LOGO RESTAURANTE -->
                <img src='{{asset("storage/$loja->nome/$loja->logo")}}' width="250" alt="Logo {{$loja->nome}}"
                    class="shadow-sm rounded">

            </div>

            <!-- INFO RESTAURANTE -->
            <div class="col-7">
                <h2 class="fs-2 fw-bold">{{$loja->nome}}</h2>
                <p class="text-secondary">{{$loja->descricao}}</p>
                <p>{{$loja->rua}}, {{$loja->numero}} -
                    {{$loja->bairro}}, {{$loja->cidade}} {{$loja->estado}}.
                    {{$loja->cep}}
                </p>
                
                <div class="d-flex">
                    <a href="{{route('loja.editar', ['id' => $loja->id])}}" class="text-decoration-none p-2 rounded border-padrao text-padrao shadow-sm">
                        Configurações
                    </a>

                    @if(session('lojaConectado') != null && session('lojaConectado')['id'] == $loja->id)
                    @else
                    <form action="{{'/escolher-loja/'.$loja->id}}" method="post">
                        @csrf
                        <button type="submit" class="mx-2 p-2 text-white fw-semibold rounded w-100 bg-padrao">
                            Escolher loja
                        </button>
                    </form>
                    @endif
                </div>


            </div>
            <!-- FIM INFO RESTAURANTE -->

            <!-- HORARIOS RESTAURANTE -->
            <div class="col-3 text-left">
                @if($horarios_funcionamento->isNotEmpty())

                @foreach($horarios_funcionamento as $horario)
                @if($horario->loja_id == $loja->id && $horario->dia_semana == 0)
                <p class="m-0">Dom: {{$horario->hora_abertura}} - {{$horario->hora_fechamento}}</p>
                @elseif($horario->loja_id == $loja->id && $horario->dia_semana == 1)
                <p class="m-0">Seg: {{$horario->hora_abertura}} - {{$horario->hora_fechamento}}</p>
                @elseif($horario->loja_id == $loja->id && $horario->dia_semana == 2)
                <p class="m-0">Ter: {{$horario->hora_abertura}} - {{$horario->hora_fechamento}}</p>
                @elseif($horario->loja_id == $loja->id && $horario->dia_semana == 3)
                <p class="m-0">Qua: {{$horario->hora_abertura}} - {{$horario->hora_fechamento}}</p>
                @elseif($horario->loja_id == $loja->id && $horario->dia_semana == 4)
                <p class="m-0">Qui: {{$horario->hora_abertura}} - {{$horario->hora_fechamento}}</p>
                @elseif($horario->loja_id == $loja->id && $horario->dia_semana == 5)
                <p class="m-0">Sex: {{$horario->hora_abertura}} - {{$horario->hora_fechamento}}</p>
                @elseif($horario->loja_id == $loja->id && $horario->dia_semana == 6)
                <p class="m-0">Sab: {{$horario->hora_abertura}} - {{$horario->hora_fechamento}}</p>
                @endif
                @endforeach
                @endif
            </div>
            <!-- FIM HORARIOS RESTAURANTE -->

        </div>
        @endforeach
        <!-- FIM RESTAURANTES -->

        <!-- SE NÃO HOUVER RESTAURANTES -->
        @else
        <div class="container-fluid mt-5 mb-5 d-flex flex-column align-items-center">
            <img src="{{asset("storage/images/logo.png")}}" width="150px" alt="Foomy"></a>
            <h3 class="fw-semibold fs-4 mt-4">Bem vindo! Vamos começar essa jornada com o Foomy?</h3>
            <p>Comece configurando as informações do seu loja!</p>
            <a href="{{route('loja.editar')}}" class="btn btn-primary px-5">Iniciar</a>
        </div>
        <!-- FIM SE NÃO HOUVER RESTAURANTES -->

        @endif


    </div>
</x-app-layout>