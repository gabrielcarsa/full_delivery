<x-app-layout>

    <!-- Dropdown Card -->
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 fw-semibold fs-5">Cadastro de Categoria</h2>
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

    @if(isset($categorias))
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
                <td>{{$categoria->nome}}</td>
                <td>{{$categoria->descricao}}</td>
                <td>{{$categoria->ordem}}</td>
                <td><a href="editar/{{$categoria->id}}" class="btn-acao-listagem-secundary">Alterar</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</x-app-layout>