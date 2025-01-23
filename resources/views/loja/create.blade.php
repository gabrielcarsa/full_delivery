<x-app-layout>

    <div class="container-padrao">

        <div class="bg-white p-3 shadow-md rounded">

            <!-- LINHA -->
            <div class="row">

                <!-- COLUNA -->
                <div class="col-6">

                    <!-- WIZARD -->
                    <div class="d-flex justify-content-between d-flex align-items-center" style="margin: 30px 5%">

                        <div class="d-flex align-items-center">
                            <div class="rounded-circle px-2 mr-2 {{!request('step') ? 'bg-padrao' : 'bg-clear'}}">
                                <p class="m-0 fw-bold fs-5 text-white">
                                    1
                                </p>
                            </div>
                            <p class="m-0 {{!request('step') ? 'text-dark' : 'text-secondary'}}">
                                Informações básicas
                            </p>
                        </div>
                        <div class="w-100 bg-clear mx-3 rounded" style="height: 2px"></div>
                        <div class="d-flex align-items-center">
                            <div
                                class="rounded-circle px-2 mr-2 {{request('step') && request('step') == 2 ? 'bg-padrao' : 'bg-clear'}}">
                                <p class="m-0 fw-bold fs-5 text-white">
                                    2
                                </p>
                            </div>
                            <p class="m-0 {{request('step') && request('step') == 2 ? 'text-dark' : 'text-secondary'}}">
                                Contato
                            </p>
                        </div>
                        <div class="w-100 bg-clear mx-3 rounded" style="height: 2px"></div>

                        <div class="d-flex align-items-center">
                            <div
                                class="rounded-circle px-2 mr-2 {{request('step') && request('step') == 3 ? 'bg-padrao' : 'bg-clear'}}">
                                <p class="m-0 fw-bold fs-5 text-white">
                                    3
                                </p>
                            </div>
                            <p class="m-0 {{request('step') && request('step') == 3 ? 'text-dark' : 'text-secondary'}}">
                                Localização
                            </p>
                        </div>
                        <div class="w-100 bg-clear mx-3 rounded" style="height: 2px"></div>

                        <div class="d-flex align-items-center">
                            <div
                                class="rounded-circle px-2 mr-2 {{request('step') && request('step') == 4 ? 'bg-padrao' : 'bg-clear'}}">
                                <p class="m-0 fw-bold fs-5 text-white">
                                    4
                                </p>
                            </div>
                            <p class="m-0 {{request('step') && request('step') == 4 ? 'text-dark' : 'text-secondary'}}">
                                Taxas
                            </p>
                        </div>

                    </div>
                    <!-- FIM WIZARD -->

                    <!-- STEP 1 -->
                    @if(!request('step'))

                    <p class="fs-4 fw-bold m-0">
                        Olá, vamos criar sua loja aqui no Foomy?
                    </p>
                    <p class="text-secondary m-0 fs-5">
                        O processo é bem simples e rápido, vamos começar com algumas informações básicas da sua loja:
                    </p>

                    <!-- FORM -->
                    <form class="my-3" action="{{ route('loja.store') }}" method="post">
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
                                        <input class="form-check-input @error('documento') is-invalid @enderror"
                                            type="radio" name="documento" id="radioCNPJ" value="cnpj"
                                            {{old('documento') == "cnpj" ? 'checked' : ''}}>
                                        <label class="form-check-label" for="radioCNPJ">CNPJ</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('documento') is-invalid @enderror"
                                            type="radio" name="documento" id="radioCPF" value="cpf"
                                            {{old('documento') == "cpf" ? 'checked' : ''}}>
                                        <label class="form-check-label" for="radioCPF">CPF</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12" id="cnpj-field" style="display: none;">
                                <x-label for="cnpj" value="CNPJ" />
                                <x-input placeholder="Ex.: 00.000.000/0001-00" id="cnpj" type="text" name="cnpj"
                                    :value="old('cnpj')" autocomplete="off" />
                            </div>

                            <div class="col-12" id="cpf-field" style="display: none;">
                                <x-label for="cpf" value="CPF" />
                                <x-input placeholder="Ex.: 000.000.000-00" id="cpf" type="text" name="cpf"
                                    :value="old('cpf')" autocomplete="off" />
                            </div>

                            <div class="col-12 my-2">
                                <label for="inputDescricao" class="form-label fw-semibold m-0">Descrição</label>
                                <textarea rows="2" name="descricao" placeholder="Ex.: Fique a vontade... Mas nem tanto."
                                    class="form-control @error('descricao') is-invalid @enderror"
                                    id="inputDescricao">{{old('descricao')}}</textarea>
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
                                    <option {{old('tipo') ? '' : 'selected'}}>- Selecione uma opção -</option>
                                    <option {{old('tipo') == "hamburgueria" ? 'selected' : ''}} value="hamburgueria">
                                        Hamburgueria</option>
                                    <option {{old('tipo') == "pastelaria" ? 'selected' : ''}} value="pastelaria">
                                        Pastelaria
                                    </option>
                                    <option {{old('tipo') == "pizzaria" ? 'selected' : ''}} value="pizzaria">Pizzaria
                                    </option>
                                    <option {{old('tipo') == "lanchonete" ? 'selected' : ''}} value="lanchonete">
                                        Lanchonete
                                    </option>
                                    <option {{old('tipo') == "dogueira" ? 'selected' : ''}} value="dogueira">Dogueira
                                        (hot
                                        dogs)
                                    </option>
                                    <option {{old('tipo') == "creperia" ? 'selected' : ''}} value="creperia">Creperia
                                    </option>
                                    <option {{old('tipo') == "tapiocaria" ? 'selected' : ''}} value="tapiocaria">
                                        Tapiocaria
                                    </option>
                                    <option {{old('tipo') == "acaiteira" ? 'selected' : ''}} value="acaiteira">Açaíteria
                                    </option>
                                    <option {{old('tipo') == "sorveteria" ? 'selected' : ''}} value="sorveteria">
                                        Sorveteria
                                    </option>
                                    <option {{old('tipo') == "churrascaria" ? 'selected' : ''}} value="churrascaria">
                                        Churrascaria</option>
                                    <option {{old('tipo') == "comida_japonesa" ? 'selected' : ''}}
                                        value="comida_japonesa">
                                        Comida Japonesa (Sushi Bar)</option>
                                    <option {{old('tipo') == "comida_chinesa" ? 'selected' : ''}}
                                        value="comida_chinesa">
                                        Comida
                                        Chinesa</option>
                                    <option {{old('tipo') == "comida_indiana" ? 'selected' : ''}}
                                        value="comida_indiana">
                                        Comida
                                        Indiana</option>
                                    <option {{old('tipo') == "comida_mexicana" ? 'selected' : ''}}
                                        value="comida_mexicana">
                                        Comida Mexicana</option>
                                    <option {{old('tipo') == "comida_arabe" ? 'selected' : ''}} value="comida_arabe">
                                        Comida
                                        Árabe</option>
                                    <option {{old('tipo') == "restaurante_italiano" ? 'selected' : ''}}
                                        value="restaurante_italiano">Restaurante Italiano</option>
                                    <option {{old('tipo') == "comida_nordestina" ? 'selected' : ''}}
                                        value="comida_nordestina">
                                        Comida Nordestina</option>
                                    <option {{old('tipo') == "comida_mineira" ? 'selected' : ''}}
                                        value="comida_mineira">
                                        Comida
                                        Mineira</option>
                                    <option {{old('tipo') == "restaurante_vegano" ? 'selected' : ''}}
                                        value="restaurante_vegano">Restaurante Vegano/Vegetariano</option>
                                    <option {{old('tipo') == "frutos_do_mar" ? 'selected' : ''}} value="frutos_do_mar">
                                        Frutos do
                                        Mar</option>
                                    <option {{old('tipo') == "steakhouse" ? 'selected' : ''}} value="steakhouse">
                                        Steakhouse
                                    </option>
                                    <option {{old('tipo') == "confeitaria" ? 'selected' : ''}} value="confeitaria">
                                        Confeitaria
                                    </option>
                                    <option {{old('tipo') == "doceria" ? 'selected' : ''}} value="doceria">Doceria
                                    </option>
                                    <option {{old('tipo') == "padaria" ? 'selected' : ''}} value="padaria">Padaria
                                    </option>
                                    <option {{old('tipo') == "cafeteria" ? 'selected' : ''}} value="cafeteria">Cafeteria
                                    </option>
                                    <option {{old('tipo') == "bar" ? 'selected' : ''}} value="bar">Bar</option>
                                    <option {{old('tipo') == "suqueria" ? 'selected' : ''}} value="suqueria">Suqueria
                                        (Sucos
                                        Naturais)</option>
                                    <option {{old('tipo') == "comida_fit" ? 'selected' : ''}} value="comida_fit">Comida
                                        Fit/Low
                                        Carb</option>
                                    <option {{old('tipo') == "cantina_escolar" ? 'selected' : ''}}
                                        value="cantina_escolar">
                                        Cantina Escolar</option>
                                    <option {{old('tipo') == "self_service" ? 'selected' : ''}} value="self_service">
                                        Self-Service (Comida a Quilo)</option>
                                    <option {{old('tipo') == "marmitaria_buffeteria" ? 'selected' : ''}}
                                        value="marmitaria_buffeteria">Marmitaria ou Buffeteria</option>
                                </select>
                            </div>
                            <div class="col-md-6 my-2">
                                <label for="inputSelect" class="form-label fw-semibold m-0">
                                    Qual a estimativa do seu faturamento mensal?
                                </label>
                                <select class="form-select @error('faturamento_mensal') is-invalid @enderror"
                                    name="faturamento_mensal" aria-label="Selecione uma opção" id="inputSelect">
                                    <option {{old('faturamento_mensal') ? '' : 'selected'}}>- Selecione uma opção -
                                    </option>
                                    <option {{old('faturamento_mensal') == "CATEGORIA 1" ? 'selected' : ''}}
                                        value="CATEGORIA 1">Até 5 mil
                                        reais</option>
                                    <option {{old('faturamento_mensal') == "CATEGORIA 2" ? 'selected' : ''}}
                                        value="CATEGORIA 2">De 5 mil até
                                        25 mil reais</option>
                                    <option {{old('faturamento_mensal') == "CATEGORIA 3" ? 'selected' : ''}}
                                        value="CATEGORIA 3">De 25 mil até
                                        80 mil reais</option>
                                    <option {{old('faturamento_mensal') == "CATEGORIA 4" ? 'selected' : ''}}
                                        value="CATEGORIA 4">De 80 mil até
                                        100 mil reais</option>
                                    <option {{old('faturamento_mensal') == "CATEGORIA 5" ? 'selected' : ''}}
                                        value="CATEGORIA 5">Mais de 100
                                        mil reais</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 my-3">
                        </div>
                        <div class="col-md-6 my-3">
                            <x-button class="">
                                Avançar
                            </x-button>
                        </div>

                    </form>
                    <!-- FIM FORM -->

                    <!-- STEP 2 -->
                    @elseif(request('step') && request('step') == 2 && $loja != null)

                    <p class="fs-4 fw-bold m-0">
                        Muito bom <span class="text-padrao">{{$loja->nome}}</span>,
                    </p>
                    <p class="text-secondary m-0 fs-5">
                        Agora vamos ajudar seus clientes a entrarem em contato com sua loja, preencha os campos abaixo:
                    </p>

                    <!-- FORM -->
                    <form class="my-3"
                        action="{{ route('loja.store', ['step' => request('step'), 'loja_id' => $loja->id]) }}"
                        method="post">
                        @csrf

                        <div class="row">

                            <div class="col-md-6 my-2">
                                <x-label for="telefone1" value="Telefone 1" />
                                <x-input placeholder="Ex.: (DD) 99999-9999" id="telefone1" type="text" name="telefone1"
                                    :value="old('telefone1')" autofocus autocomplete="off" />
                            </div>
                            <div class="col-md-6 my-2">
                                <x-label for="telefone2" value="Telefone 2" />
                                <x-input placeholder="Ex.: (DD) 99999-9999" id="telefone2" type="text" name="telefone2"
                                    :value="old('telefone2')" autocomplete="off" />
                            </div>

                            <div class="col-md-12 my-2">
                                <x-label for="email" value="Email da loja" />
                                <x-input placeholder="Ex.: teste@dominio.com" id="email" type="email" name="email"
                                    :value="old('email')" autocomplete="off" />
                            </div>

                            <div class="col-md-6 my-3">
                            </div>
                            <div class="col-md-6 my-3">
                                <x-button class="">
                                    Avançar
                                </x-button>
                            </div>

                        </div>


                    </form>
                    <!-- FIM FORM -->

                    <!-- STEP 3 -->
                    @elseif(request('step') && request('step') == 3 && $loja != null)

                    <p class="fs-4 fw-bold m-0">
                        Precisamos saber onde você está
                    </p>
                    <p class="text-secondary m-0 fs-5">
                        Preencha o campo de CEP abaixo e irá completar automáticamente os outros campos, fora número e
                        complemento
                    </p>

                    <!-- FORM -->
                    <form class="my-3"
                        action="{{ route('loja.store', ['step' => request('step'), 'loja_id' => $loja->id]) }}"
                        method="post">
                        @csrf

                        <div class="row">

                            <div class="col-md-6 my-2">
                                <x-label for="cep" value="CEP" />
                                <x-input placeholder="Ex.: 79000-000" id="cep" type="text" name="cep"
                                    :value="old('cep')" autofocus autocomplete="off" />
                            </div>
                            <div class="col-md-6 my-2 d-flex align-items-end">
                                <button type="button" class="btn border-padrao text-padrao" onclick="buscarEndereco()">
                                    Buscar
                                </button>
                            </div>

                            <div class="col-md-6 my-2">
                                <x-label for="rua" value="Rua" />
                                <x-input placeholder="" readonly id="rua" type="text" name="rua" :value="old('rua')"
                                    autocomplete="off" class="bg-light" />
                            </div>
                            <div class="col-md-6 my-2">
                                <x-label for="bairro" value="Bairro" />
                                <x-input placeholder="" readonly id="bairro" type="text" name="bairro"
                                    :value="old('bairro')" autocomplete="off" class="bg-light" />
                            </div>

                            <div class="col-md-6 my-2">
                                <x-label for="cidade" value="Cidade" />
                                <x-input placeholder="" readonly id="cidade" type="text" name="cidade"
                                    :value="old('cidade')" autocomplete="off" class="bg-light" />
                            </div>
                            <div class="col-md-6 my-2">
                                <x-label for="estado" value="Estado" />
                                <x-input placeholder="" readonly id="estado" type="text" name="estado"
                                    :value="old('estado')" autocomplete="off" class="bg-light" />
                            </div>

                            <div class="col-md-6 my-2">
                                <x-label for="numero" value="Número" />
                                <x-input placeholder="" id="numero" type="text" name="numero" :value="old('numero')"
                                    autocomplete="off" />
                            </div>
                            <div class="col-md-6 my-2">
                                <x-label for="complemento" value="Complemento" />
                                <x-input placeholder="" id="complemento" type="text" name="complemento"
                                    :value="old('complemento')" autocomplete="off" />
                            </div>

                            <div class="col-md-6 my-3">
                            </div>
                            <div class="col-md-6 my-3">
                                <x-button class="">
                                    Avançar
                                </x-button>
                            </div>

                        </div>

                    </form>
                    <!-- FIM FORM -->

                    <!-- STEP 4 -->
                    @elseif(request('step') && request('step') == 4 && $loja != null)

                    <p class="fs-4 fw-bold m-0">
                        Ufa, quase lá!
                    </p>
                    <p class="text-secondary m-0 fs-5">
                        Vamos definir as taxas de serviço e entrega que você deseja cobrar:
                    </p>

                    <!-- FORM -->
                    <form class="my-3"
                        action="{{ route('loja.store', ['step' => request('step'), 'loja_id' => $loja->id]) }}"
                        method="post">
                        @csrf

                        <div class="row g-3">

                            <div class="col-md-6">
                                <x-label for="taxa_servico" value="Taxa de serviço (%)" />
                                <x-input placeholder="Ex.: 10" id="taxa_servico" type="text" name="taxa_servico"
                                    :value="old('taxa_servico')" autofocus autocomplete="off" />
                            </div>
                            <div class="col-md-6 text-secondary">
                                <div class="bg-white d-flex align-items-center border rounded p-3">
                                    <span class="material-symbols-outlined mr-2">
                                        info
                                    </span>
                                    <p class="fw-regular m-0">
                                        Todos os dados poderão ser alterados posteriomente
                                    </p>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="bg-white p-3 rounded border h-100">
                                    <div class="form-check m-0 p-0">
                                        <input class="form-check-input m-0 @error('taxa_entrega') is-invalid @enderror"
                                            type="radio" name="taxa_entrega" id="taxa_entrega" value="GRATUITA"
                                            style="width: 24px; height: 24px;"
                                            {{old('taxa_entrega') == "GRATUITA" ? 'checked' : ''}}><br>
                                        <label class="form-check-label mt-3 fw-semibold" for="taxa_entrega">
                                            Taxa de entrega gratuita
                                        </label>
                                        <p class="text-secondary fw-light">
                                            A taxa de entrega será gratuita para todas localidades.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="bg-white p-3 rounded border h-100">
                                    <div class="form-check m-0 p-0">
                                        <input class="form-check-input m-0 @error('taxa_entrega') is-invalid @enderror"
                                            type="radio" name="taxa_entrega" id="taxa_entrega" value="KM"
                                            style="width: 24px; height: 24px;"
                                            {{old('taxa_entrega') == "KM" ? 'checked' : ''}}><br>
                                        <label class="form-check-label mt-3 fw-semibold" for="taxa_entrega">
                                            Taxa de entrega por KM
                                        </label>
                                        <p class="text-secondary fw-light">
                                            O valor da entrega será calculado por <br>
                                            <span class="fw-semibold fst-italic">distância</span> x <span
                                                class="fw-semibold fst-italic">preço km</span>.
                                        </p>
                                        <div class="my-3">
                                            <x-label for="taxa_por_km_entrega" value="Valor KM (R$)" />
                                            <x-input placeholder="Ex.: 2,00" id="taxa_por_km_entrega" type="text"
                                                name="taxa_por_km_entrega" :value="old('taxa_por_km_entrega')"
                                                autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="bg-white p-3 rounded border h-100">
                                    <div class="form-check m-0 p-0">
                                        <input class="form-check-input m-0 @error('taxa_entrega') is-invalid @enderror"
                                            type="radio" name="taxa_entrega" id="taxa_entrega" value="FIXA"
                                            style="width: 24px; height: 24px;"
                                            {{old('taxa_entrega') == "FIXA" ? 'checked' : ''}}><br>
                                        <label class="form-check-label mt-3 fw-semibold" for="taxa_entrega">
                                            Taxa fixa
                                        </label>
                                        <p class="text-secondary fw-light">
                                            Taxa de entrega fixa para todas localidades, independente da distância.
                                        </p>
                                        <div class="my-3">
                                            <x-label for="taxa_entrega_fixa" value="Valor de entrega fixa (R$)" />
                                            <x-input placeholder="Ex.: 6,00" id="taxa_entrega_fixa" type="text"
                                                name="taxa_entrega_fixa" :value="old('taxa_entrega_fixa')"
                                                autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 my-3">
                            </div>
                            <div class="col-md-6 my-3">
                                <x-button class="">
                                    Finalizar
                                </x-button>
                            </div>

                        </div>

                    </form>
                    <!-- FIM FORM -->


                    @endif
                    <!-- FIM STEP -->

                </div>
                <!-- FIM COLUNA -->

                <!-- COLUNA -->
                <div class="col-6 d-flex align-items-center">
                    <img src="{{asset("storage/images/login-seguro.svg")}}" width="500px" alt="">

                </div>
                <!-- FIM COLUNA -->

            </div>
            <!-- FIM LINHA -->
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    // FUNÇÃO PARA EXIBIR CAMPOS DE CPF OU CNPJ
    document.addEventListener('DOMContentLoaded', () => {
        const radioCNPJ = document.getElementById('radioCNPJ');
        const radioCPF = document.getElementById('radioCPF');
        const cnpjField = document.getElementById('cnpj-field');
        const cpfField = document.getElementById('cpf-field');

        if (radioCNPJ && radioCPF && cnpjField && cpfField) {
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
        }
    });

    // MÁSCARA PARA CAMPO CPF
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
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
    }

    // MÁSCARA PARA CAMPO CNPJ
    const cnpjInput = document.getElementById('cnpj');
    if (cnpjInput) {
        cnpjInput.addEventListener('input', function(e) {
            let input = e.target;
            let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
            let formattedValue = '';

            if (value.length > 0) {
                formattedValue = value.slice(0, 2);

                if (value.length > 2) {
                    formattedValue += '.' + value.slice(2, 5);
                }

                if (value.length > 5) {
                    formattedValue += '.' + value.slice(5, 8);
                }

                if (value.length > 8) {
                    formattedValue += '/' + value.slice(8, 12);
                }

                if (value.length > 12) {
                    formattedValue += '-' + value.slice(12, 14);
                }
            }

            input.value = formattedValue;
        });
    }

    // IDs dos campos de telefone
    const telefoneInputs = ['telefone1', 'telefone2'];

    // FUNÇÃO PARA APLICAR MÁSCARA DE TELEFONE
    telefoneInputs.forEach(id => {
        const telefoneInput = document.getElementById(id);
        if (telefoneInput) {
            telefoneInput.addEventListener('input', function(e) {
                let input = e.target;
                let value = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                let formattedValue = '';

                if (value.length > 0) {
                    formattedValue = '(' + value.slice(0, 2); // Adiciona o DDD

                    if (value.length > 2) {
                        formattedValue += ') ' + value.slice(2, 7); // Parte inicial do número
                    }

                    if (value.length > 7) {
                        formattedValue += '-' + value.slice(7, 11); // Parte final do número
                    }
                }

                input.value = formattedValue; // Atualiza o valor do campo
            });
        }
    });

    // BUSCAR CEP
    async function buscarEndereco() {
        const cep = document.getElementById('cep').value.replace(/\D/g, '');

        if (cep) {
            if (cep.length !== 8) {
                alert('CEP inválido!');
                return;
            }
            try {
                const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await response.json();
                if (!data.erro) {
                    document.getElementById('rua').value = data.logradouro;
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('cidade').value = data.localidade;
                    document.getElementById('estado').value = data.uf;
                    document.getElementById('complemento').value = data.complemento;
                } else {
                    alert('CEP não encontrado!');
                }
            } catch (error) {
                alert('Erro ao buscar o CEP!');
            }
        }

    }

    const dinheirosInputs = ['taxa_entrega_fixa', 'taxa_por_km_entrega'];

    // FUNÇÃO MASCARA DINHEIRO
    function mask(value) {
        // Converte o valor para número
        var numberValue = parseFloat(value) / 100;

        // Formata o número com vírgula como separador decimal e duas casas decimais
        return numberValue.toLocaleString('pt-BR', {
            minimumFractionDigits: 2
        });
    }

    //FORMATAR CAMPOS DE DINHEIRO
    dinheirosInputs.forEach(id => {
        const dinheirosInput = document.getElementById(id);
        if (dinheirosInput) {
            dinheirosInput.addEventListener('input', function() {
                // Remover os caracteres não numéricos
                var unmaskedValue = dinheirosInput.value.replace(/\D/g, '');

                // Atualiza o valor do input com a máscara
                dinheirosInput.value = mask(unmaskedValue);
            });
        }
    });
    </script>
</x-app-layout>