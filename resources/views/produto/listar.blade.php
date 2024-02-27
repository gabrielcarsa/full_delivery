<x-app-layout>

    <!-- Card Consulta -->
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 fw-semibold fs-5">{{$categoria->nome}}</h2>
            <a class="btn btn-primary" href="{{ route('categoria_produto_novo') }}">Cadastrar</a>

        </div>
        <!-- Card Body -->
        <div class="card-body">
            @if(isset($produtos))
            @foreach ($produtos as $produto)
            <div class="card" style="width: 18rem;">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{$produto->nome}}</h5>
                    <p class="card-text">{{$produto->descricao}}</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            @endforeach

            @endif

        </div>
    </div>

</x-app-layout>