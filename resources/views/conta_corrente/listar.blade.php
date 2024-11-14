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
                <p class="text-secondary">
                    Loja: {{session('lojaConectado')['nome']}}
                </p>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn bg-padrao text-white m-0 py-1 px-5 fw-bold d-flex align-items-center justify-content-center"
                    href="{{ route('conta_corrente.novo') }}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Cadastrar
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        @if(isset($contas_corrente))
        <!-- TABLE -->
        <table class="table table-padrao border-top table align-middle my-3">
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
                        <a href="{{ route('conta_corrente.edit', ['id' => $conta->id] ) }}" class="text-primary text-decoration-none">
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
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                                    <form action="{{ route('conta_corrente.destroy', ['id' => $conta->id]) }}" method="POST">
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
                <!-- FIM CONTAS -->

            </tbody>
        </table>
        <!-- FIM TABLE -->

    </div>
    @endif

</x-app-layout>