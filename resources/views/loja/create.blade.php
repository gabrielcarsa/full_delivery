<x-app-layout>
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

    <!-- LINHA -->
    <div class="row p-3">

        <!-- COLUNA -->
        <div class="col-6">
            <!-- WIZARD -->
            <div class="d-flex justify-content-between d-flex align-items-center" style="margin: 30px 5%">

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
                        Contato
                    </p>
                </div>
                <div class="w-100 bg-clear mx-3 rounded" style="height: 2px"></div>

                <div class="d-flex align-items-center">
                    <div class="rounded-circle px-2 mr-2 {{request('step') == 2 ? 'bg-padrao' : 'bg-clear'}}">
                        <p class="m-0 fw-bold fs-5 text-white">
                            3
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
                            4
                        </p>
                    </div>
                    <p class="m-0 {{request('step') == 2 ? 'text-dark' : 'text-secondary'}}">
                        Taxas
                    </p>
                </div>

            </div>
            <!-- FIM WIZARD -->


            <!-- FORM -->
            <form class="my-3" action="{{ route('loja.store', ['step' => request('step')]) }}" method="post">
                @csrf

                <div class="row">

                    <div class="col-sm-6 my-2">
                        <x-label for="nome" value="Nome da loja" />
                        <x-input placeholder="Ex.: Restaurante do Foomy" id="nome" type="text" name="nome"
                            :value="old('nome')" autofocus autocomplete="off" />
                    </div>
                    <div class="col-sm-6 my-2">
                        <div class="border rounded p-3 bg-white">
                            <p class="m-0 fw-semibold">Documento da empresa?</p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('documento') is-invalid @enderror" type="radio"
                                    name="documento" id="radioCNPJ" value="cnpj"
                                    {{old('documento') == "cnpj" ? 'checked' : ''}}>
                                <label class="form-check-label" for="radioCNPJ">CNPJ</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('documento') is-invalid @enderror" type="radio"
                                    name="documento" id="radioCPF" value="cpf"
                                    {{old('documento') == "cpf" ? 'checked' : ''}}>
                                <label class="form-check-label" for="radioCPF">CPF</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" id="cnpj-field" style="display: none;">
                        <x-label for="cnpj" value="CNPJ" />
                        <x-input placeholder="Ex.: 00.00.0000.000-1" id="cnpj" type="text" name="cnpj"
                            :value="old('cnpj')" autocomplete="off" />
                    </div>

                    <div class="col-12" id="cpf-field" style="display: none;">
                        <x-label for="cpf" value="CPF" />
                        <x-input placeholder="Ex.: 000.000.000-00" id="cpf" type="text" name="cpf" :value="old('cpf')"
                            autocomplete="off" />
                    </div>

                    <div class="col-12 my-2">
                        <label for="inputDescricao" class="form-label fw-semibold m-0">Descrição</label>
                        <textarea rows="2" name="descricao" placeholder="Ex.: Fique a vontade... Mas nem tanto."
                            class="form-control @error('descricao') is-invalid @enderror" id="inputDescricao">
                            {{!empty($loja) ? $loja->descricao : old('descricao')}}
                        </textarea>
                        <p class="m-0 text-secondary fw-light">
                            Máximo 200 caracteres
                        </p>
                    </div>

                    <div class="col-md-6 my-2">
                        <label for="inputSelect" class="form-label fw-semibold m-0">
                            Qual é o tipo do seu estabelecimento?
                        </label>
                        <select class="form-select @error('tipo') is-invalid @enderror" name="tipo"
                            aria-label="Selecione uma opção" id="inputSelect">
                            <option selected>- Selecione uma opção -</option>
                            <option value="hamburgueria">Hamburgueria</option>
                            <option value="pastelaria">Pastelaria</option>
                            <option value="pizzaria">Pizzaria</option>
                            <option value="lanchonete">Lanchonete</option>
                            <option value="dogueira">Dogueira (hot dogs)</option>
                            <option value="creperia">Creperia</option>
                            <option value="tapiocaria">Tapiocaria</option>
                            <option value="acaiteira">Açaíteria</option>
                            <option value="sorveteria">Sorveteria</option>
                            <option value="churrascaria">Churrascaria</option>
                            <option value="comida_japonesa">Comida Japonesa (Sushi Bar)</option>
                            <option value="comida_chinesa">Comida Chinesa</option>
                            <option value="comida_indiana">Comida Indiana</option>
                            <option value="comida_mexicana">Comida Mexicana</option>
                            <option value="comida_arabe">Comida Árabe</option>
                            <option value="restaurante_italiano">Restaurante Italiano</option>
                            <option value="comida_nordestina">Comida Nordestina</option>
                            <option value="comida_mineira">Comida Mineira</option>
                            <option value="restaurante_vegano">Restaurante Vegano/Vegetariano</option>
                            <option value="frutos_do_mar">Frutos do Mar</option>
                            <option value="steakhouse">Steakhouse</option>
                            <option value="confeitaria">Confeitaria</option>
                            <option value="doceria">Doceria</option>
                            <option value="padaria">Padaria</option>
                            <option value="cafeteria">Cafeteria</option>
                            <option value="bar">Bar</option>
                            <option value="suqueria">Suqueria (Sucos Naturais)</option>
                            <option value="comida_fit">Comida Fit/Low Carb</option>
                            <option value="cantina_escolar">Cantina Escolar</option>
                            <option value="self_service">Self-Service (Comida a Quilo)</option>
                            <option value="marmitaria_buffeteria">Marmitaria ou Buffeteria</option>
                        </select>
                    </div>
                    <div class="col-md-6 my-2">
                        <label for="inputSelect" class="form-label fw-semibold m-0">
                            Qual a estimativa do seu faturamento mensal?
                        </label>
                        <select class="form-select @error('faturamento_mensal') is-invalid @enderror"
                            name="faturamento_mensal" aria-label="Selecione uma opção" id="inputSelect">
                            <option selected>- Selecione uma opção -</option>
                            <option value="CATEGORIA 1">Até 5 mil reais</option>
                            <option value="CATEGORIA 2">De 5 mil até 25 mil reais</option>
                            <option value="CATEGORIA 3">De 25 mil até 80 mil reais</option>
                            <option value="CATEGORIA 4">De 80 mil até 100 mil reais</option>
                            <option value="CATEGORIA 5">Mais de 100 mil reais</option>
                        </select>
                    </div>
                </div>

                <x-button class="my-3">
                    Avançar
                </x-button>

            </form>
            <!-- FIM FORM -->

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

        // Chamar a função ao carregar a página para restaurar o estado inicial
        toggleFields();

        // Adicionar evento de clique aos rádios
        radioCNPJ.addEventListener('change', toggleFields);
        radioCPF.addEventListener('change', toggleFields);
    });
    </script>

</x-app-layout>