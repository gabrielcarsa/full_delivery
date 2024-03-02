<x-app-layout>

    <!-- Card Consulta -->
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 fw-semibold fs-5">{{$categoria->nome}}</h2>
            <a class="btn btn-primary"
                href="{{ route('produto.novo', ['categoria_id' => $categoria->id]) }}">Cadastrar</a>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-4 g-4">
                @if(isset($produtos))
                @foreach ($produtos as $produto)
                <div class="col">
                    <div class="card" style="width: 18rem;">
                        <img src="{{ asset('storage/imagens_produtos/'.$produto->imagem) }}" style="max-width: 100%;"
                            class="card-img-top max-height-20">
                        <div class="card-body">
                            <h5 class="card-title">{{$produto->nome}}</h5>
                            <p class="card-text descricao-produto">{{$produto->descricao}}</p>
                            <p class="card-text">R$ {{number_format($produto->preco, 2, ',', '.')}}</p>
                            <div class="row justify-content-center">
                                <a href="#" class="btn btn-primary col-3 mx-1"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <a href="#" class="btn btn-success col-3 mx-1"><i class="fa-solid fa-percent"></i></a>
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal{{$produto->id}}"
                                    class="btn btn-danger col-3 mx-1"><i class="fa-solid fa-trash"></i></a>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$produto->id}}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir
                                                {{$produto->nome}}?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Essa ação é irreversível! Tem certeza?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Não</button>
                                            <form action="{{ route('produto.excluir', ['id' => $produto->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Sim, eu
                                                    tenho</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
                @endif

            </div>
        </div>
    </div>

</x-app-layout>