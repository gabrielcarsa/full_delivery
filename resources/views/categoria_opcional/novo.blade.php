<x-app-layout>

    <!-- CONTAINER -->
    <div class="container">

        <!-- HEADER-->
        <h2 class="my-3 fw-bolder fs-1">
            {{ empty($opcional) ? 'Cadastro Categoria Opcional de '.$produto->nome : 'Alterar '.$opcional->nome }}</h2>
        <!-- FIM HEADER-->


        <!-- MENSAGENS SUCESSO OU ERRO-->
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
        <!-- FIM MENSAGENS SUCESSO OU ERRO-->

        <!-- FORM -->
        <form class="col-6"
            action="{{!empty($categoria_opcional) ? '/categoria_opcional/alterar/' . Auth::user()->id . '/' . $opcional->id : '/categoria_opcional/cadastrar/' . $produto->id . '/' . Auth::user()->id}}"
            method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @if(!empty($categoria_opcional))
            @method('PUT')
            @endif

            <!-- CAMPOS -->
            <div class="m-2">
                <label for="inputNome" class="form-label">Nome</label>
                <input type="text" name="nome" value="{{!empty($categoria_opcional) ? $opcional->nome : old('nome')}}"
                    class="form-control" placeholder="Ex.: Selecione um item" id="inputNome" maxlength="50" required>
            </div>
            <div class="m-2">
                <label for="inputLimite" class="form-label">Limite para escolha</label>
                <input type="number" name="limite"
                    value="{{!empty($categoria_opcional) ? $opcional->limite : old('limite')}}" class="form-control"
                    id="inputLimite" placeholder="Ex.: 1" required>
            </div>
            <div class="m-2">
                <p class="m-0">Obrigatório preenchimento desse grupo de opcionais?</p>
                <div class="form-check">
                    <input class="form-check-input" name="preenchimentoObrigatorio" type="checkbox" value="1" id="CheckSim">
                    <label class="form-check-label" for="CheckSim">
                        Sim
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="preenchimentoObrigatorio" type="checkbox" value="0" id="CheckNao" checked>
                    <label class="form-check-label" for="CheckNao">
                        Não
                    </label>
                </div>
            </div>



            <div class="col-12 d-flex mt-3">
                <button type="submit" class="btn btn-primary w-100">
                    Cadastrar
                </button>
            </div>
        </form>
        <!-- FIM FORM -->

    </div>
    <!-- FIM CONTAINER -->

</x-app-layout>