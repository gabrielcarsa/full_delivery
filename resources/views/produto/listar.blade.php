<x-app-layout>

    <!-- Card Consulta -->
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 fw-semibold fs-5">{{$categoria->nome}}</h2>
            <a class="btn btn-primary"
                href="{{ route('produto_novo', ['categoria_id' => $categoria->id]) }}">Cadastrar</a>
        </div>
        <!-- Card Body -->
        <div class="card-body justify-content-center d-flex">
            @if(isset($produtos))
            @foreach ($produtos as $produto)
            <div class="card" style="width: 18rem;">
                <img src="{{ asset('storage/imagens_produtos/'.$produto->imagem) }}" style="max-width: 100%;"
                    class="card-img-top max-height-20">
                <div class="card-body">
                    <h5 class="card-title">{{$produto->nome}}</h5>
                    <p class="card-text descricao-produto">{{$produto->descricao}}</p>
                    <p class="card-text">R$ {{number_format($produto->preco, 2, ',', '.')}}</p>
                    <div class="row justify-content-center">
                        <a href="#" class="btn btn-primary col-md-3"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="#" class="btn btn-success col-md-3"><i class="fa-solid fa-percent"></i></a>
                        <a href="#" class="btn btn-danger col-md-3"><i class="fa-solid fa-trash"></i></a>

                    </div>
                </div>
            </div>
            @endforeach

            @endif

        </div>
    </div>

</x-app-layout>