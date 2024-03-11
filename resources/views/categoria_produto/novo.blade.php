<x-app-layout>

    <!-- Dropdown Card -->
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 fw-semibold fs-5">{{empty($categoria) ? 'Cadastro de Categoria' : 'Alterar ' . $categoria->nome }}</h2>
        </div>
        <!-- Card Body -->
        <div class="card-body">
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
            <form class="row g-3" action="{{empty($categoria) ? '/categoria_produto/cadastrar/' . Auth::user()->id : '/categoria_produto/alterar/' . Auth::user()->id .'/' . $categoria->id }}" method="post"
                autocomplete="off">
                @csrf
                @if(!empty($categoria))
                @method('PUT')
                @endif
                <div class="col-md-6">
                    <label for="inputNome" class="form-label">Nome da categoria</label>
                    <input type="text" name="nome" value="{{!empty($categoria) ? $categoria->nome : old('nome')}}" class="form-control" id="inputNome">
                </div>
                <div class="col-md-6">
                    <label for="inputDescricao" class="form-label">Descrição</label>
                    <input type="text" name="descricao" value="{{!empty($categoria) ? $categoria->descricao : old('descricao')}}" class="form-control"
                        id="inputDescricao">
                </div>
                <div class="col-md-6">
                    <label for="inputOrdem" class="form-label">Ordem de exibição</label>
                    <input type="number" name="ordem" value="{{!empty($categoria) ? $categoria->ordem : old('ordem')}}" class="form-control" id="inputOrdem">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>