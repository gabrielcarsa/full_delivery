<x-app-layout>

    <!-- LINHA -->
    <div class="row p-3">

        <!-- COLUNA -->
        <div class="col-6">
            <!-- WIZARD -->
            <div class="d-flex justify-content-between d-flex align-items-center" style="margin: 30px 10%">

                <div class="d-flex align-items-center">
                    <div
                        class="rounded-circle px-2 mr-2 {{request('step') == null || request('step') == 1 ? 'bg-padrao' : 'bg-clear'}}">
                        <p class="m-0 fw-bold fs-5 text-white">
                            1
                        </p>
                    </div>
                    <p class="m-0 {{request('step') == null || request('step') == 1 ? 'text-dark' : 'text-secondary'}}">
                        Informações básicas
                    </p>
                </div>
                <div class="w-100 bg-clear mx-3 rounded" style="height: 2px"></div>
                <div class="d-flex align-items-center">
                    <div class="rounded-circle px-2 mr-2 {{request('step') == 2 ? 'bg-padrao' : 'bg-clear'}}">
                        <p class="m-0 fw-bold fs-5 text-white">
                            2
                        </p>
                    </div>
                    <p class="m-0 {{request('step') == 2 ? 'text-dark' : 'text-secondary'}}">
                        Localização
                    </p>
                </div>
                <div class="w-100 bg-clear mx-3 rounded" style="height: 2px"></div>

                <div class="d-flex align-items-center">
                    <div class="rounded-circle px-2 mr-2 {{request('step') == 3 ? 'bg-padrao' : 'bg-clear'}}">
                        <p class="m-0 fw-bold fs-5 text-white">
                            3
                        </p>
                    </div>
                    <p class="m-0 {{request('step') == 2 ? 'text-dark' : 'text-secondary'}}">
                        Informações básicas
                    </p>
                </div>

            </div>
            <!-- FIM WIZARD -->

            <form class="my-3" action="" method="post">

                <div class="row">

                    <div class="col-sm-6 my-2">
                        <x-label for="nome" value="Nome da loja" />
                        <x-input placeholder="Ex.: Restaurante do Foomy" id="nome" type="text" name="nome"
                            :value="old('nome')" required autofocus />
                    </div>
                    <div class="col-sm-6 my-2">
                        <div class="border rounded p-3 bg-white">
                            <p class="m-0 fw-semibold">Documento da empresa?</p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cnpj_cpf" id="radioCNPJ"
                                    value="cnpj">
                                <label class="form-check-label" for="radioCNPJ">CNPJ</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cnpj_cpf" id="radioCPF" value="cpf">
                                <label class="form-check-label" for="radioCPF">CPF</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" id="cnpj-field" style="display: none;">
                        <x-label for="cnpj" value="CNPJ" />
                        <x-input placeholder="Ex.: 00.00.0000.000-1" id="cnpj" type="text" name="cnpj"
                            :value="old('cnpj')" />
                    </div>

                    <div class="col-12" id="cpf-field" style="display: none;">
                        <x-label for="cpf" value="CPF" />
                        <x-input placeholder="Ex.: 000.000.000-00" id="cpf" type="text" name="cpf"
                            :value="old('cpf')" />
                    </div>

                    <div class="col-12 my-3">
                        <label for="inputDescricao" class="form-label fw-semibold m-0">Descrição</label>
                        <textarea rows="2" name="descricao" placeholder="Ex.: Fique a vontade... Mas nem tanto."
                            class="form-control @error('descricao') is-invalid @enderror" id="inputDescricao"
                            required>{{!empty($loja) ? $loja->descricao : old('descricao')}}</textarea>
                        <p class="m-0 text-secondary fw-light">
                            Máximo 200 caracteres
                        </p>
                    </div>

                    <div class="col-12 my-3">
                        <label for="inputSelect" class="form-label fw-semibold m-0">
                            Qual é o tipo do seu estabelecimento?
                        </label>
                        <select class="form-select" aria-label="Selecione uma opção" id="inputSelect">
                            <option selected>- Selecione uma opção -</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>

                </div>

                <x-button class="my-3">
                    Avançar
                </x-button>

            </form>
        </div>
        <!-- FIM COLUNA -->

        <!-- COLUNA -->
        <div class="col-6 d-flex align-items-center">
            <img src="{{asset("storage/images/login-seguro.svg")}}" width="500px" alt="">

        </div>
        <!-- FIM COLUNA -->

    </div>
    <!-- FIM LINHA -->

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const radioCNPJ = document.getElementById('radioCNPJ');
        const radioCPF = document.getElementById('radioCPF');
        const cnpjField = document.getElementById('cnpj-field');
        const cpfField = document.getElementById('cpf-field');

        // Função para alternar visibilidade
        function toggleFields() {
            if (radioCNPJ.checked) {
                cnpjField.style.display = 'block';
                cpfField.style.display = 'none';
            } else if (radioCPF.checked) {
                cpfField.style.display = 'block';
                cnpjField.style.display = 'none';
            }
        }

        // Adicionar evento de clique aos rádios
        radioCNPJ.addEventListener('change', toggleFields);
        radioCPF.addEventListener('change', toggleFields);
    });
    </script>

</x-app-layout>