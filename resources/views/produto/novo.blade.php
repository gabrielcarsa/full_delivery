<x-app-layout>

    <!-- Dropdown Card -->
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 fw-semibold fs-5">Cadastro de Produto</h2>
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

            <form class="row g-3" action="/produto/cadastrar/{{$categoria->id}}/{{Auth::user()->id}}" method="post"
                autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputImagem">Imagem</label>
                    <input type="file" class="form-control" name="imagem" id="inputImagem">
                </div>

                <div class="col-md-6">
                    <label for="inputNome" class="form-label">Nome</label>
                    <input type="text" name="nome" value="{{old('nome')}}" class="form-control" id="inputNome"
                        maxlength="100">
                </div>
                <div class="col-md-6">
                    <label for="inputDescricao" class="form-label">Descrição</label>
                    <input type="text" name="descricao" value="{{old('descricao')}}" class="form-control"
                        id="inputDescricao" maxlength="500">
                </div>
                <div class="col-md-4">
                    <label for="inputPreco" class="form-label">Preço</label>
                    <input type="text" name="preco" value="{{old('preco')}}" class="form-control" id="inputPreco">
                </div>
                <div class="col-md-2">
                    <label for="inputTipoDisponibilidade" id="disponibilidade"
                        class="form-label">Disponibilidade</label>
                    <select id="inputTipoDisponibilidade" name="disponibilidade" class="form-select form-control">
                        <option value="1" select>Dísponivel</option>
                        <option value="0">Não dísponivel</option>
                    </select>
                </div>

                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Adicionais cadastrados
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>