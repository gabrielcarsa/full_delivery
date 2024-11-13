<x-app-layout>

    <div class="container">

        <!-- MENSAGENS -->
        <div class="toast-container position-fixed top-0 end-0">
            @if(session('success'))
            <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true">
                <div class="d-flex align-items-center p-3">
                    <span class="material-symbols-outlined fs-1 text-success" style="font-variation-settings:'FILL' 1;">
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
                <h2 class="mt-3 mb-0 fw-bolder fs-1">
                    Conta Corrente
                </h2>
                <p class="m-0 text-secondary">
                    Loja selecionada - {{$contas_corrente[0]->loja->nome}}
                </p>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn bg-padrao text-white m-0 py-1 px-5 fw-bold d-flex align-items-center justify-content-center"
                    href="{{ route('cliente.novo') }}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Cadastrar
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        @if(isset($contas_corrente))

        <!-- TABLES CONTAS CORRENTE -->

        <div class="w-100 bg-white border rounded p-3 mx-1 mt-3">

            <!-- TABLE -->
            <table class="table table-padrao border-top table align-middle">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Banco</th>
                        <th scope="col">Ag.</th>
                        <th scope="col">Núm. Conta</th>
                        <th scope="col">Cadastrado por</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- CONTAS -->
                    @foreach ($contas_corrente as $conta)
                    <tr>
                        <td scope="row">{{$conta->id}}</td>
                        <td class="text-uppercase">{{$conta->nome}}</td>
                        <td class="text-uppercase">{{$conta->banco}}</td>
                        <td class="text-uppercase">{{$conta->agencia}}</td>
                        <td class="text-uppercase">{{$conta->numero_conta}}</td>
                        <td class="text-truncate" style="max-width: 30px">
                            {{$conta->usuarioCadastrador->name}}
                        </td>
                        <td>
                            <a href="" data-bs-toggle="modal" class="text-primary text-decoration-none"
                                data-bs-target="#editarModal{{$conta->id}}">
                                <span class="material-symbols-outlined">
                                    edit
                                </span>
                            </a>
                            <a href="" data-bs-toggle="modal" class="text-danger text-decoration-none"
                                data-bs-target="#exampleModal{{$conta->id}}">
                                <span class="material-symbols-outlined">
                                    delete
                                </span>
                            </a>
                        </td>

                        <!-- MODAL EXCLUIR -->
                        <div class="modal fade" id="exampleModal{{$conta->id}}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <p class="modal-title fs-5" id="exampleModalLabel">
                                            Excluir {{$conta->nome}}?
                                        </p>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Essa ação é irreversível! Tem certeza?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Não</button>
                                        <form action="" method="POST">
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

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="editarModal{{$conta->id}}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <p class="modal-title fs-5" id="exampleModalLabel">
                                            Renomear {{$conta->nome}}?
                                        </p>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">

                                            <label for="inputNome" class="form-label">
                                                Novo nome
                                            </label>
                                            <input type="text" name="nome"
                                                class="form-control @error('nome') is-invalid @enderror" id="inputNome"
                                                placeholder="Ex.: Salário, Aluguel, Venda de ABCDE..."
                                                autocomplete="off">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn bg-padrao text-white">
                                                Salvar
                                            </button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- MODAL EDITAR -->
                    </tr>
                    @endforeach
                    <!-- FIM CONTAS -->

                </tbody>
            </table>
            <!-- FIM TABLE -->
        </div>
    </div>

    @endif
    <!-- FIM CONTAS CORRENTE -->

    </div>

</x-app-layout>