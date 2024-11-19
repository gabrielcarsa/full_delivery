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

        <!-- CONTAS -->
        @foreach ($contas_corrente as $conta)

        <div class="card p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="m-0 text-secondary">
                        #{{$conta->id}}
                    </p>
                    <p class="fw-bold m-0 fs-4">
                        {{$conta->nome}}
                    </p>
                </div>
                <div>
                    <p class="m-0 text-secondary">
                        Saldo atual
                    </p>
                    <p class="m-0 fw-semibold fs-5">
                        R$ {{number_format($conta->saldo->last()->saldo, 2, ',', '.')}}
                    </p>
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col">
                    <p class="text-secondary m-0">
                        Banco
                    </p>
                    <p class="m-0">
                        {{$conta->banco}}
                    </p>
                </div>
                <div class="col">
                    <p class="text-secondary m-0">
                        Agência
                    </p>
                    <p class="m-0">
                        {{$conta->agencia ?? '000'}}
                    </p>
                </div>
                <div class="col">
                    <p class="text-secondary m-0">
                        Número Conta
                    </p>
                    <p class="m-0">
                        {{$conta->numero_conta ?? '000'}}
                    </p>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-sm-4">
                    <a href="{{ route('saldo.index', ['conta_corrente_id' => $conta->id]) }}"
                        class="btn bg-padrao d-flex align-items-center justify-content-center text-white fw-semibold">
                        <span class="material-symbols-outlined mr-1">
                            monitoring
                        </span>
                        Acompanhar saldo
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="{{ route('conta_corrente.edit', ['id' => $conta->id] ) }}"
                        class="btn btn-outline-primary d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined mr-1">
                            edit
                        </span>
                        Editar
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="" data-bs-toggle="modal"
                        class="btn btn-outline-danger d-flex align-items-center justify-content-center"
                        data-bs-target="#exampleModal{{$conta->id}}">
                        <span class="material-symbols-outlined">
                            delete
                        </span>
                        Excluir
                    </a>
                </div>
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
                                <form action="{{ route('conta_corrente.destroy', ['id' => $conta->id]) }}"
                                    method="POST">
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
            </div>
        </div>
        @endforeach
        <!-- FIM CONTAS -->

        @endif

    </div>

</x-app-layout>