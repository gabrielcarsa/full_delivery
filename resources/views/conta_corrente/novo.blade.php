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
        <h2 class="mt-3 mb-0 fw-bolder fs-1">
            Conta Corrente {{!empty($conta_corrente) ? ' - ' . $conta_corrente->nome : ''}}
        </h2>
        <!-- FIM HEADER -->

        <!-- CARD FORM -->
        <div class="bg-white border p-3 rounded my-3">

            <!-- FORM -->
            <form action="{{ !empty($conta_corrente) ? route('conta_corrente.update', ['id' => $conta_corrente->id]) : route('conta_corrente.store') }}" method="post" autocomplete="off">
                @csrf
                @if(!empty($conta_corrente))
                @method('PUT')
                @endif

                <!-- LINHA -->
                <div class="row my-1">
                    <div class="col-6">
                        <label for="inputNome" class="form-label">Nome</label>
                        <input type="text" name="nome"
                            value="{{!empty($conta_corrente) ? $conta_corrente->nome : old('nome')}}"
                            class="form-control @error('nome') is-invalid @enderror" id="inputNome" required>
                    </div>
                    <div class="col-6">
                        <label for="inputBanco" class="form-label">Banco</label>
                        <input type="text" name="banco"
                            value="{{!empty($conta_corrente) ? $conta_corrente->banco : old('banco')}}"
                            class="form-control @error('banco') is-invalid @enderror" id="inputBanco" required>
                    </div>
                </div>
                <!-- FIM LINHA -->

                <!-- LINHA -->
                <div class="row my-2">
                    <div class="col-6">
                        <label for="inputAgencia" class="form-label">Agência</label>
                        <input type="text" name="agencia"
                            value="{{!empty($conta_corrente) ? $conta_corrente->agencia : old('agencia')}}"
                            class="form-control @error('agencia') is-invalid @enderror" id="inputAgencia">
                    </div>
                    <div class="col-6">
                        <label for="inputNumeroConta" class="form-label">Número da conta</label>
                        <input type="text" name="numero_conta"
                            value="{{!empty($conta_corrente) ? $conta_corrente->numero_conta : old('numero_conta')}}"
                            class="form-control @error('numero_conta') is-invalid @enderror" id="inputNumeroConta">
                    </div>
                </div>
                <!-- FIM LINHA -->

                <!-- BTN SUBMIT -->
                <div class="my-3 d-flex justify-content-end">
                    <button type="submit" class="btn bg-padrao text-white px-5 fw-semibold">
                        Salvar
                    </button>
                </div>

            </form>
            <!-- FORM -->

        </div>
        <!-- FIM CARD FORM -->

    </div>

</x-app-layout>