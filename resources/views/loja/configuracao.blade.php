<x-app-layout>

    <!-- CARD -->
    <div class="card mb-4 mt-4">

        <!-- CARD HEADER -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between dropdown">
            <h2 class="m-0 fw-semibold fs-5">Loja</h2>

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
                action="{{!empty($loja) ? '/loja/alterar/' . Auth::user()->id . '/' . $loja->id : '/loja/cadastrar/' . Auth::user()->id}}"
                method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                @if(!empty($loja))
                @method('PUT')
                @endif

                <!-- ACCORDION INFORMAÇÕES GERAIS -->
                <div class="accordion" id="accordionPanelsStayOpenExample">
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
                                @if(empty($loja))
                                <div class="input-group">
                                    <label class="input-group-text" for="inputImagem">Logo</label>
                                    <input type="file" class="form-control @error('imagem') is-invalid @enderror"
                                        name="imagem" id="inputImagem">
                                </div>
                                <p class="text-secondary ml-2">300 x 300 (px)</p>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="inputNome" class="form-label">Nome</label>
                                        <input type="text" name="nome"
                                            value="{{!empty($loja) ? $loja->nome : old('nome')}}"
                                            class="form-control @error('nome') is-invalid @enderror" id="inputNome"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputDescricao" class="form-label">Descrição</label>
                                        <input type="text" name="descricao"
                                            value="{{!empty($loja) ? $loja->descricao : old('descricao')}}"
                                            class="form-control @error('descricao') is-invalid @enderror"
                                            id="inputDescricao" required>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="inputTelefone1" class="form-label">Telefone 1</label>
                                        <input type="text" name="telefone1"
                                            value="{{!empty($loja) ? $loja->telefone1 : old('telefone1')}}"
                                            class="form-control @error('telefone1') is-invalid @enderror"
                                            id="inputTelefone1">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputTelefone2" class="form-label">Telefone 2</label>
                                        <input type="text" name="telefone2"
                                            value="{{!empty($loja) ? $loja->telefone2 : old('telefone2')}}"
                                            class="form-control @error('telefone2') is-invalid @enderror"
                                            id="inputTelefone2">
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
                                            value="{{!empty($loja) ? $loja->cep : old('cep')}}" class="form-control"
                                            id="inputCep" required>
                                    </div>
                                    <div class="col-3">
                                        <label for="" class="form-label">Buscar CEP</label>
                                        <button type="button" class="btn btn-outline-secondary d-block"
                                            onclick="buscarEndereco()">Buscar</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-5">
                                        <label for="inputRua" class="form-label">Rua</label>
                                        <input type="text" name="rua"
                                            value="{{!empty($loja) ? $loja->rua : old('rua')}}" class="form-control"
                                            id="inputRua" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="inputBairro" class="form-label">Bairro</label>
                                        <input type="text" name="bairro"
                                            value="{{!empty($loja) ? $loja->bairro : old('bairro')}}"
                                            class="form-control" id="inputBairro" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="inputNumero" class="form-label">Número</label>
                                        <input type="text" name="numero"
                                            value="{{!empty($loja) ? $loja->numero : old('numero')}}"
                                            class="form-control" id="inputNumero" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="inputComplemento" class="form-label">Complemento</label>
                                        <input type="text" name="complemento"
                                            value="{{!empty($loja) ? $loja->complemento : old('complemento')}}"
                                            class="form-control" id="inputComplemento">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="inputCidade" class="form-label">Cidade</label>
                                        <input type="text" name="cidade"
                                            value="{{!empty($loja) ? $loja->cidade : old('cidade')}}"
                                            class="form-control" id="inputCidade" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="inputEstado" class="form-label">Estado</label>
                                        <input type="text" name="estado"
                                            value="{{!empty($loja) ? $loja->estado : old('estado')}}"
                                            class="form-control" id="inputEstado" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ACCORDION HORARIOS -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-funcionamento" aria-expanded="false"
                                aria-controls="panelsStayOpen-funcionamento">
                                Horários de funcionamento
                            </button>
                        </h2>
                        <div id="panelsStayOpen-funcionamento" class="accordion-collapse collapse">
                            <div class="accordion-body">

                                <!-- se já houver cadastro -->
                                @if(!empty($loja))

                                @foreach($horarios as $horario)
                                @if($horario->dia_semana == 1 && $horario->loja_id == $loja->id)
                                <div class="row mt-3">
                                    <h4>Segunda-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="1_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('1_abertura')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="1_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('1_fechamento')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                </div>
                                @elseif($horario->dia_semana == 2 && $horario->loja_id == $loja->id)
                                <div class="row mt-3">
                                    <h4>Terça-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="2_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('2_abertura')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="2_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('2_fechamento')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                </div>
                                @elseif($horario->dia_semana == 3 && $horario->loja_id == $loja->id)
                                <div class="row mt-3">
                                    <h4>Quarta-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="3_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('3_abertura')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="3_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('3_fechamento')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                </div>
                                @elseif($horario->dia_semana == 4 && $horario->loja_id == $loja->id)
                                <div class="row mt-3">
                                    <h4>Quinta-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="4_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('4_abertura')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="4_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('4_fechamento')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                </div>
                                @elseif($horario->dia_semana == 5 && $horario->loja_id == $loja->id)
                                <div class="row mt-3">
                                    <h4>Sexta-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="5_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('5_abertura')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="5_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('5_fechamento')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                </div>
                                @elseif($horario->dia_semana == 6 && $horario->loja_id == $loja->id)
                                <div class="row mt-3">
                                    <h4>Sabádo</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="6_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('6_abertura')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="6_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('6_fechamento')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                </div>
                                @elseif($horario->dia_semana == 0 && $horario->loja_id == $loja->id)
                                <div class="row mt-3">
                                    <h4>Domingo</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="0_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('0_abertura')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="0_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('0_fechamento')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                </div>
                                @endif
                                @endforeach

                                <!-- se não houver cadastro -->
                                @else
                                <div class="row mt-3">
                                    <h4>Segunda-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="1_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('1_abertura')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="1_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('1_fechamento')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h4>Terça-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="2_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('2_abertura')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="2_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('2_fechamento')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h4>Quarta-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="3_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('3_abertura')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="3_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('3_fechamento')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h4>Quinta-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="4_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('4_abertura')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="4_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('4_fechamento')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h4>Sexta-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="5_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('5_abertura')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="5_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('5_fechamento')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h4>Sabádo</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="6_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('6_abertura')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="6_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('6_fechamento')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h4>Domingo</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="0_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('0_abertura')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="0_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('0_fechamento')}}"
                                            class="form-control" id="inputDiaSemana" required>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
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
    aplicarMascaraTelefone('inputTelefone1');
    aplicarMascaraTelefone('inputTelefone2');

    </script>
</x-app-layout>