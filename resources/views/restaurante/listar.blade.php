<x-app-layout>

    <!-- Card Consulta -->
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between dropdown">
            <h2 class="m-0 fw-semibold fs-5">Restaurante</h2>
            @if($restaurantes->isNotEmpty())
            <a href="{{route('restaurante.configurar')}}" class="btn btn-primary"><i class="fa-solid fa-gears"></i>Configurações</a>
            @endif
        </div>
        <!-- Card Body -->
 
        <div class="card-body">
            @if($restaurantes->isNotEmpty())
            @foreach($restaurantes as $restaurante)
            <div class="row">
                <div class="col-6">
                    <img src="" alt="">
                </div>
                <div class="col-6">
                    <h2>{{$restaurante->nome}}</h2>
                    <p>{{$restaurante->descricao}}</p>
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