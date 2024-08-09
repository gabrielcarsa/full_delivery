<x-layout-cardapio>

    <!-- NAVBAR PRODUTO -->
    <div class="d-flex bg-white fixed-top p-2">
        <a href="#" onclick="history.go(-1); return false;"
            class="text-dark text-decoration-none d-flex align-items-center m-0">
            <span class="material-symbols-outlined">
                arrow_back
            </span>
        </a>
        <div class="d-flex align-items-center justify-content-center" style="flex: 1;">
            <h2 class="fs-6 fw-bold">Cadastrar endereço</h2>
        </div>
    </div>
    <!-- FIM NAVBAR PRODUTO -->

    <!-- CONTAINER -->
    <div class="container" style="margin-top: 70px">

        <!-- MENSAGENS -->
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
        <!-- FIM MENSAGENS -->

        <!-- FORM -->
        <form action="{{ route('cliente_endereco.cadastrar', ['cliente_id' => Auth::guard('cliente')->user()->id]) }}"
            method="post">
            @csrf

            <div class="row">
                <div class="form-floating m-0">
                    <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome"
                        value="{{old('nome')}}" id="floatingInput" placeholder="" required>
                    <label for="floatingInput" class="ml-2">Nome do endereço</label>
                </div>
                <p class="m-0 text-secondary">Ex.: Casa, trabalho...</p>
            </div>

            <hr>

            <div class="row">
                <div class="col">
                    <div class="form-floating m-0">
                        <input type="text" name="cep" value="{{old('cep')}}"
                            class="form-control @error('cep') is-invalid @enderror" id="inputCep" placeholder=""
                            required>
                        <label for="inputCep" class="">CEP</label>
                    </div>
                </div>
                <div class="col d-flex align-items-center">
                    <button type="button" class="btn btn-outline-secondary d-block" onclick="buscarEndereco()">
                        Buscar CEP
                    </button>
                </div>
            </div>

            <hr>

            <div class="row my-2">
                <div class="col-md-5 my-1">
                    <div class="form-floating m-0">
                        <input type="text" name="rua" value="{{old('rua')}}"
                            class="form-control @error('rua') is-invalid @enderror" id="inputRua" placeholder=""
                            required>
                        <label for="inputRua" class="">Rua</label>
                    </div>
                </div>
                <div class="col-md-5 my-1">
                    <div class="form-floating m-0">
                        <input type="text" name="bairro" value="{{old('bairro')}}"
                            class="form-control @error('bairro') is-invalid @enderror" id="inputBairro" placeholder=""
                            required>
                        <label for="inputBairro" class="">Bairro</label>
                    </div>
                </div>
                <div class="col-md-2 my-1">
                    <div class="form-floating m-0">
                        <input type="text" name="numero" value="{{old('numero')}}"
                            class="form-control @error('numero') is-invalid @enderror" id="inputNumero" placeholder=""
                            required>
                        <label for="inputNumero" class="">Número</label>
                    </div>
                </div>
            </div>

            <div class="row my-2">
                <div class="col-md-5 my-1">
                    <div class="form-floating m-0">
                        <input type="text" name="complemento" value="{{old('complemento')}}"
                            class="form-control @error('complemento') is-invalid @enderror" id="inputComplemento"
                            placeholder="">
                        <label for="inputComplemento" class="">Complemento</label>
                    </div>
                </div>
                <div class="col-md-5 my-1">
                    <div class="form-floating m-0">
                        <input type="text" name="cidade" value="{{old('cidade')}}"
                            class="form-control @error('cidade') is-invalid @enderror" id="inputCidade" placeholder=""
                            required>
                        <label for="inputCidade" class="">Cidade</label>
                    </div>
                </div>
                <div class="col-md-2 my-1">
                    <div class="form-floating m-0">
                        <input type="text" name="estado" value="{{old('estado')}}"
                            class="form-control @error('estado') is-invalid @enderror" id="inputEstado" placeholder=""
                            required>
                        <label for="inputEstado" class="">Estado</label>
                    </div>
                </div>
            </div>

            <div class="col-12 my-3">
                <button class="btn btn-primary w-100" type="submit">
                    Cadastrar
                </button>
            </div>

        </form>
        <!-- FIM FORM -->

    </div>
    <!-- FIM CONTAINER -->

    <script>
    // Função para buscar endereço pelo CEP
    async function buscarEndereco() {
        const cep = document.getElementById('inputCep').value.replace(/\D/g, '');
        if (cep.length !== 8) {
            alert('CEP inválido!');
            return;
        }
        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();
            if (!data.erro) {
                document.getElementById('inputRua').value = data.logradouro;
                document.getElementById('inputBairro').value = data.bairro;
                document.getElementById('inputCidade').value = data.localidade;
                document.getElementById('inputEstado').value = data.uf;
                document.getElementById('inputComplemento').value = data.complemento;
            } else {
                alert('CEP não encontrado!');
            }
        } catch (error) {
            alert('Erro ao buscar o CEP!');
        }
    }
    </script>
</x-layout-cardapio>