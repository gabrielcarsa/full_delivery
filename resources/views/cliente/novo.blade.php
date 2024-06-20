<x-app-layout>

    <!-- CARD -->
    <div class="card mb-4 mt-4">

        <!-- CARD HEADER -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between dropdown">
            <h2 class="m-0 fw-semibold fs-5">Cliente</h2>

        </div>
        <!-- FIM CARD HEADER -->

        <!-- CARD BODY -->
        <div class="card-body">

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
            <form class="row g-3"
                action="{{!empty($cliente) ? '/cliente/alterar/' . $cliente->id : '/cliente/cadastrar/'}}" method="post"
                autocomplete="off" enctype="multipart/form-data">
                @csrf
                @if(!empty($cliente))
                @method('PUT')
                @endif

                <!-- ACCORDION -->
                <div class="accordion" id="accordionPanelsStayOpenExample">

                    <!-- ACCORDION INFORMAÇÕES GERAIS -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-geral" aria-expanded="true"
                                aria-controls="panelsStayOpen-geral">
                                Informações Gerais
                            </button>
                        </h2>
                        <div id="panelsStayOpen-geral" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <div class="row my-1">
                                    <div class="col-md-6">
                                        <label for="inputNome" class="form-label">Nome</label>
                                        <input type="text" name="nome"
                                            value="{{!empty($cliente) ? $cliente->nome : old('nome')}}"
                                            class="form-control @error('nome') is-invalid @enderror" id="inputNome"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCPF" class="form-label">CPF</label>
                                        <input type="text" name="cpf"
                                            value="{{!empty($cliente) ? $cliente->cpf : old('cpf')}}"
                                            class="form-control @error('cpf') is-invalid @enderror" id="inputCPF"
                                            required>
                                    </div>
                                </div>
                                <div class="row my-1">
                                    <div class="col-md-6">
                                        <label for="inputEmail" class="form-label">Email</label>
                                        <input type="email" name="email"
                                            value="{{!empty($cliente) ? $cliente->email : old('email')}}"
                                            class="form-control @error('email') is-invalid @enderror" id="inputEmail"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputTelefone" class="form-label">Telefone</label>
                                        <input type="text" name="telefone"
                                            value="{{!empty($cliente) ? $cliente->telefone : old('telefone')}}"
                                            class="form-control @error('telefone') is-invalid @enderror"
                                            id="inputTelefone" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ACCORDION ENDEREÇO -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-endereco" aria-expanded="false"
                                aria-controls="panelsStayOpen-endereco">
                                Endereço
                            </button>
                        </h2>
                        <div id="panelsStayOpen-endereco" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-5">
                                        <label for="inputCep" class="form-label">CEP</label>
                                        <input type="text" name="cep"
                                            value="{{!empty($cliente) ? $cliente->cep : old('cep')}}"
                                            class="form-control" id="inputCep">
                                    </div>
                                    <div class="col-3">
                                        <label for="" class="form-label">Buscar CEP</label>
                                        <button type="button" class="btn btn-outline-secondary d-block"
                                            onclick="buscarEndereco()">Buscar</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row my-1">
                                    <div class="col-md-5">
                                        <label for="inputRua" class="form-label">Rua</label>
                                        <input type="text" name="rua"
                                            value="{{!empty($cliente) ? $cliente->rua : old('rua')}}"
                                            class="form-control" id="inputRua">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="inputBairro" class="form-label">Bairro</label>
                                        <input type="text" name="bairro"
                                            value="{{!empty($cliente) ? $cliente->bairro : old('bairro')}}"
                                            class="form-control" id="inputBairro">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="inputNumero" class="form-label">Número</label>
                                        <input type="text" name="numero"
                                            value="{{!empty($cliente) ? $cliente->numero : old('numero')}}"
                                            class="form-control" id="inputNumero">
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-md-5">
                                        <label for="inputComplemento" class="form-label">Complemento</label>
                                        <input type="text" name="complemento"
                                            value="{{!empty($cliente) ? $cliente->complemento : old('complemento')}}"
                                            class="form-control" id="inputComplemento">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="inputCidade" class="form-label">Cidade</label>
                                        <input type="text" name="cidade"
                                            value="{{!empty($cliente) ? $cliente->cidade : old('cidade')}}"
                                            class="form-control" id="inputCidade">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="inputEstado" class="form-label">Estado</label>
                                        <input type="text" name="estado"
                                            value="{{!empty($cliente) ? $cliente->estado : old('estado')}}"
                                            class="form-control" id="inputEstado">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- FIM ACCORDION -->

                <!-- BTN SUBMIT -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>


            </form>
            <!-- FORM -->

        </div>
        <!-- FIM CARD BODY -->

    </div>
    <!-- FIM CARD -->


    <script>
    // Função para aplicar a máscara de CPF
    document.getElementById('inputCPF').addEventListener('input', function(e) {
        let input = e.target;
        let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
        let formattedValue = '';

        if (value.length > 0) {
            formattedValue = value.slice(0, 3);

            if (value.length > 3) {
                formattedValue += '.' + value.slice(3, 6);
            }

            if (value.length > 6) {
                formattedValue += '.' + value.slice(6, 9);
            }

            if (value.length > 9) {
                formattedValue += '-' + value.slice(9, 11);
            }
        }

        input.value = formattedValue;
    });

    // Função para aplicar a máscara de telefone
    function aplicarMascaraTelefone(inputId) {
        const input = document.getElementById(inputId);

        input.addEventListener('input', function(e) {
            let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
            let formattedValue = '';

            if (value.length > 0) {
                formattedValue = '(' + value.slice(0, 2);

                if (value.length > 2) {
                    formattedValue += ') ' + value.slice(2, 7);
                }

                if (value.length > 7) {
                    formattedValue += '-' + value.slice(7, 11);
                }
            }

            input.value = formattedValue;
        });
    }
    // Aplicar a máscara para os campos de telefone 1 e telefone 2
    aplicarMascaraTelefone('inputTelefone');

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
</x-app-layout>