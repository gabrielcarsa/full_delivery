<x-app-layout>

    <!-- Card Consulta -->
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between dropdown">
            <h2 class="m-0 fw-semibold fs-5">Restaurante</h2>
        </div>
        <!-- Card Body -->

        <div class="card-body">
            @if($restaurantes->isNotEmpty())
            @foreach($restaurantes as $restaurante)
            <div class="row align-items-center">
                <div class="col-2">
                    <img src="{{asset("storage/logo/$restaurante->imagem")}}" width="250"
                        alt="Logo {{$restaurante->nome}}">
                </div>
                <div class="col-8">
                    <h2 class="fs-2 fw-bold">{{$restaurante->nome}}</h2>
                    <p class="text-secondary">{{$restaurante->descricao}}</p>
                    <p><i class="fa-solid fa-location-dot mr-2"></i>{{$restaurante->rua}}, {{$restaurante->numero}} -
                        {{$restaurante->bairro}}, {{$restaurante->cidade}} {{$restaurante->estado}}
                        {{$restaurante->cep}}</p>
                    <a href="{{route('restaurante.configurar', ['id' => $restaurante->id])}}" class="btn btn-primary"><i
                            class="fa-solid fa-gears mr-2"></i>Configurações</a>

                </div>
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
            </div>
            @endforeach
            @else
            <div class="container-fluid mt-5 mb-5 d-flex flex-column align-items-center">
                <img src="{{asset("storage/images/logo.png")}}" width="150px" alt="Foomy"></a>
                <h3 class="fw-semibold fs-4 mt-4">Bem vindo! Vamos começar essa jornada com o Foomy?</h3>
                <p>Comece configurando as informações do seu restaurante!</p>
                <a href="{{route('restaurante.configurar')}}" class="btn btn-primary px-5">Iniciar</a>
            </div>

            @endif
        </div>
    </div>
</x-app-layout>