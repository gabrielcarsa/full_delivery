<x-app-layout>

    <!-- Card Consulta -->
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 fw-semibold fs-5">Categoria de produtos</h2>
            <a class="btn btn-primary" href="{{ route('categoria_produto_novo') }}">Cadastrar</a>

        </div>
        <!-- Card Body -->
        <div class="card-body">
            <form class="row g-3" action="/categoria_produto/listar" method="get" autocomplete="off">
                @csrf
                <div class="col-md-6">
                    <label for="inputNome" class="form-label">Nome da categoria</label>
                    <input type="text" name="nome" value="{{request('nome')}}" class="form-control" id="inputNome">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Consultar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Card Consulta -->
    @if(isset($categorias))
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between dropdown">
            <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Exportar
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">PDF</a></li>
            </ul>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Ordem de exibição</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                    <tr>
                        <th scope="row">{{$categoria->id}}</th>
                        <td><a class="btn btn-outline-primary"  href="{{ route('produtos', ['categoria_id' => $categoria->id]) }}">{{$categoria->nome}}</a></td>
                        <td>{{$categoria->descricao}}</td>
                        <td>{{$categoria->ordem}}</td>
                        <td>
                            <a href="editar/{{$categoria->id}}" class="acoes-listar btn-acao-listagem-secundary"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                            <a href="editar/{{$categoria->id}}" class="acoes-listar btn-acao-listagem-secundary text-danger"><i
                                    class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</x-app-layout>