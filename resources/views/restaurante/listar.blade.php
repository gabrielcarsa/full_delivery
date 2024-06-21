<x-app-layout>

    <!-- CONTEUDO -->
    <div class="card mb-4 mt-4">

        <!-- CARD HEADER -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between dropdown">
            <h2 class="m-0 fw-semibold fs-5">Restaurante</h2>
            <a href="{{route('restaurante.configurar')}}" class="btn btn-primary px-5">Adicionar</a>
        </div>
        <!-- FIM CARD HEADER -->

        <!-- CARD BODY -->
        <div class="card-body">

            @if($restaurantes->isNotEmpty())

            <!-- RESTAURANTES -->
            @foreach($restaurantes as $restaurante)
            <div
                class="row align-items-center m-2 p-1 {{ session('restauranteConectado') && session('restauranteConectado')['id'] == $restaurante->id ? 'border-3 border-success' : 'border-3' }}">
                <div class="col-2">

                    <!-- BTN EDITAR IMG -->
                    <a class="position-absolute bg-dark p-1 text-white rounded" data-bs-toggle="modal"
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
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar logo restaurante</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{'/restaurante/alterar-logo/' . $restaurante->id}}" method="post"
                                    autocomplete="off" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="input-group">
                                            <label class="input-group-text" for="inputImagem">Logo</label>
                                            <input type="file"
                                                class="form-control @error('imagem') is-invalid @enderror" name="logo"
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
                    <!-- FIM MODAL -->

                    <!-- LOGO RESTAURANTE -->
                    <img src='{{asset("storage/$restaurante->nome/$restaurante->logo")}}' width="250"
                        alt="Logo {{$restaurante->nome}}" class="shadow-sm rounded">

                </div>

                <!-- INFO RESTAURANTE -->
                <div class="col-8">
                    <h2 class="fs-2 fw-bold">{{$restaurante->nome}}</h2>
                    <p class="text-secondary">{{$restaurante->descricao}}</p>
                    <p>{{$restaurante->rua}}, {{$restaurante->numero}} -
                        {{$restaurante->bairro}}, {{$restaurante->cidade}} {{$restaurante->estado}}.
                        {{$restaurante->cep}}
                    </p>
                    <a href="{{route('restaurante.configurar', ['id' => $restaurante->id])}}"
                        class="btn btn-primary mb-1">Configurações</a>

                    @if(session('restauranteConectado') != null && session('restauranteConectado')['id'] ==
                    $restaurante->id)
                    <button type="button" class="btn btn-info">Conectado</button>
                    @else
                    <form action="{{'/escolher-restaurante/'.$restaurante->id}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-success">Conectar</button>
                    </form>
                    @endif

                </div>
                <!-- FIM INFO RESTAURANTE -->

                <!-- HORARIOS RESTAURANTE -->
                <div class="col-2 text-left">
                    @if($horarios_funcionamento->isNotEmpty())

                    @foreach($horarios_funcionamento as $horario)
                    @if($horario->restaurante_id == $restaurante->id && $horario->dia_semana == 0)
                    <p class="m-0">Dom: {{$horario->hora_abertura}} - {{$horario->hora_fechamento}}</p>
                    @elseif($horario->restaurante_id == $restaurante->id && $horario->dia_semana == 1)
                    <p class="m-0">Seg: {{$horario->hora_abertura}} - {{$horario->hora_fechamento}}</p>
                    @elseif($horario->restaurante_id == $restaurante->id && $horario->dia_semana == 2)
                    <p class="m-0">Ter: {{$horario->hora_abertura}} - {{$horario->hora_fechamento}}</p>
                    @elseif($horario->restaurante_id == $restaurante->id && $horario->dia_semana == 3)
                    <p class="m-0">Qua: {{$horario->hora_abertura}} - {{$horario->hora_fechamento}}</p>
                    @elseif($horario->restaurante_id == $restaurante->id && $horario->dia_semana == 4)
                    <p class="m-0">Qui: {{$horario->hora_abertura}} - {{$horario->hora_fechamento}}</p>
                    @elseif($horario->restaurante_id == $restaurante->id && $horario->dia_semana == 5)
                    <p class="m-0">Sex: {{$horario->hora_abertura}} - {{$horario->hora_fechamento}}</p>
                    @elseif($horario->restaurante_id == $restaurante->id && $horario->dia_semana == 6)
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
                <p>Comece configurando as informações do seu restaurante!</p>
                <a href="{{route('restaurante.configurar')}}" class="btn btn-primary px-5">Iniciar</a>
            </div>
            <!-- FIM SE NÃO HOUVER RESTAURANTES -->

            @endif

        </div>
        <!-- FIM CARD BODY -->

    </div>
</x-app-layout>