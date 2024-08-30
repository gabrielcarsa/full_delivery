<x-app-layout>

    <div class="container">

        <!-- MENSAGENS -->
        <div class="toast-container position-fixed top-0 end-0">
            @if(session('success'))
            <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true">
                <div class="d-flex align-items-center p-3">
                    <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                        check_circle
                    </span>
                    <div class="toast-body">
                        <p class="fs-5 m-0">
                            {{ session('success') }}
                        </p>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            @endif
            @if (session('error'))
            <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true">
                <div class="d-flex align-items-center p-3">
                    <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                        error
                    </span>
                    <div class="toast-body">
                        <p class="fs-5 m-0">
                            {{ session('error') }}
                        </p>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            @endif
            @if ($errors->any())
            <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true">
                <div class="d-flex align-items-center p-3">
                    <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                        error
                    </span>
                    <div class="toast-body">
                        @foreach ($errors->all() as $error)
                        <p class="fs-5 m-0">
                            {{ $error }}
                        </p>
                        @endforeach
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            @endif
        </div>
        <!-- FIM MENSAGENS -->

        <!-- HEADER -->
        <div class="row">
            <div class="col">
                <h2 class="my-3 fw-bolder fs-1">
                    Mesas <span class="text-secondary fs-3">
                        ({{$data['mesas']->count()}})
                    </span>
                </h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn bg-padrao text-white fw-semibold d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    <span class="material-symbols-outlined">
                        add
                    </span>
                    Cadastrar
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- MODAL CADASTRO MESA -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5" id="exampleModalLabel">
                            Cadastro de mesa
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <!-- FORM -->
                        <form action="{{!empty($mesa) ? '/mesa/alterar/' . $mesa->id : '/mesa/cadastrar/'}}"
                            method="post" autocomplete="off" enctype="multipart/form-data">
                            @csrf

                            <div class="form-floating">
                                <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome"
                                    id="floatingInput" value="{{!empty($mesa) ? $mesa->nome : old('nome')}}"
                                    placeholder="TESTE10" required {{!empty($mesa) ? 'readonly disabled' : ''}}>
                                <label for="floatingInput" class="text-secondary fw-semibold">
                                    Nome ou número da mesa
                                </label>
                            </div>

                            <!-- BTN SUBMIT -->
                            <div class="mt-3 d-flex justify-content-end">
                                <a href="{{url()->previous()}}" class="btn text-padrao mx-1">Voltar</a>
                                <button type="submit" class="btn bg-padrao text-white fw-bolder">
                                    {{!empty($mesa) ? 'Editar' : 'Cadastrar'}}
                                </button>

                            </div>

                        </form>
                        <!-- FIM FORM -->

                    </div>
                </div>
            </div>
        </div>
        <!-- FIM MODAL CADASTRO MESA -->

        <!-- MESAS -->
        @if($data['mesas'] != null)
        <!-- TABLE -->
        <table class="table table-padrao border-top table align-middle">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Mesa</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>

                <!-- MESAS -->
                @foreach($data['mesas'] as $mesa)
                <tr>
                    <td class="text-secondary">#{{$mesa->id}}</td>
                    <td class="fw-semibold">{{$mesa->nome}}</td>
                    <td>
                        <a href="" data-bs-toggle="modal" class="acoes-listar text-danger"
                            data-bs-target="#exampleModal{{$mesa->id}}">
                            <span class="material-symbols-outlined">
                                delete
                            </span>
                        </a>
                    </td>

                    <!-- MODAL EXCLUIR -->
                    <div class="modal fade" id="exampleModal{{$mesa->id}}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title fs-5" id="exampleModalLabel">
                                        Excluir {{$mesa->nome}}?
                                    </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Essa ação é irreversível! Tem certeza?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                                    <form action="{{ route('mesa.excluir', ['id' => $mesa->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            Sim, eu tenho
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- MODAL EXCLUIR -->

                </tr>
                @endforeach
                <!-- FIM MESAS -->

            </tbody>
        </table>
        <!-- FIM TABLE -->

        @endif
        <!-- FIM MESAS -->

    </div>

</x-app-layout>