<x-app-layout>

    @if(isset($opcionais))
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 fw-semibold fs-5">Opcionais de {{$produto->nome}}</h2>
            <a class="btn btn-primary"
                href="{{ route('opcional_produto.novo', ['produto_id' => $produto->id]) }}">Cadastrar</a>

        </div>
        <!-- Card Body -->
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($opcionais as $opcional)
                    <tr>
                        <th scope="row">{{$opcional->id}}</th>
                        <td>{{$opcional->nome}}</td>
                        <td>{{$opcional->descricao}}</td>
                        <td>R$ {{number_format($opcional->preco, 2, ',', '.')}}</td>
                        <td>
                            <a href="" class="acoes-listar text-decoration-none">
                                <span class="material-symbols-outlined">
                                    edit
                                </span>
                            </a>
                            <a href="" data-bs-toggle="modal"
                                class="acoes-listar text-decoration-none text-danger"
                                data-bs-target="#exampleModal{{$opcional->id}}">
                                <span class="material-symbols-outlined">
                                    delete
                                </span>
                            </a>
                        </td>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{$opcional->id}}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir
                                            {{$opcional->nome}}?</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Essa ação é irreversível! Tem certeza?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Não</button>
                                        <form action="{{ route('opcional_produto.excluir', ['id' => $opcional->id]) }}"
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</x-app-layout>