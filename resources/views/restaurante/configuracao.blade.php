<x-app-layout>

    <!-- Card Consulta -->
    <div class="card mb-4 mt-4">
        <!-- Card Header  -->
        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between dropdown">
            <h2 class="m-0 fw-semibold fs-5">Restaurante</h2>

        </div>
        <!-- Card Body -->
        <div class="card-body">
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
            <form class="row g-3"
                action="{{!empty($restaurante) ? '/restaurante/alterar/' . Auth::user()->id . '/' . $restaurante->id : '/restaurante/cadastrar/' . Auth::user()->id}}"
                method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                @if(!empty($restaurante))
                @method('PUT')
                @endif
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
                                @if(empty($restaurante))
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
                                            value="{{!empty($restaurante) ? $restaurante->nome : old('nome')}}"
                                            class="form-control @error('nome') is-invalid @enderror" id="inputNome">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputDescricao" class="form-label">Descrição</label>
                                        <input type="text" name="descricao"
                                            value="{{!empty($restaurante) ? $restaurante->descricao : old('descricao')}}"
                                            class="form-control @error('descricao') is-invalid @enderror"
                                            id="inputDescricao">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                            value="{{!empty($restaurante) ? $restaurante->cep : old('cep')}}"
                                            class="form-control" id="inputCep">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">

                                    <div class="col-md-5">
                                        <label for="inputRua" class="form-label">Rua</label>
                                        <input type="text" name="rua"
                                            value="{{!empty($restaurante) ? $restaurante->rua : old('rua')}}"
                                            class="form-control" id="inputRua">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="inputBairro" class="form-label">Bairro</label>
                                        <input type="text" name="bairro"
                                            value="{{!empty($restaurante) ? $restaurante->bairro : old('bairro')}}"
                                            class="form-control" id="inputBairro">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="inputNumero" class="form-label">Número</label>
                                        <input type="text" name="numero"
                                            value="{{!empty($restaurante) ? $restaurante->numero : old('numero')}}"
                                            class="form-control" id="inputNumero">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="inputComplemento" class="form-label">Complemento</label>
                                        <input type="text" name="complemento"
                                            value="{{!empty($restaurante) ? $restaurante->complemento : old('complemento')}}"
                                            class="form-control" id="inputComplemento">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="inputCidade" class="form-label">Cidade</label>
                                        <input type="text" name="cidade"
                                            value="{{!empty($restaurante) ? $restaurante->cidade : old('cidade')}}"
                                            class="form-control" id="inputCidade">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="inputEstado" class="form-label">Estado</label>
                                        <input type="text" name="estado"
                                            value="{{!empty($restaurante) ? $restaurante->estado : old('estado')}}"
                                            class="form-control" id="inputEstado">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
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
                                @if(!empty($restaurante))

                                @foreach($horarios as $horario)
                                @if($horario->dia_semana == 1 && $horario->restaurante_id == $restaurante->id)
                                <div class="row mt-3">
                                    <h4>Segunda-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="1_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('1_abertura')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="1_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('1_fechamento')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                </div>
                                @elseif($horario->dia_semana == 2 && $horario->restaurante_id == $restaurante->id)
                                <div class="row mt-3">
                                    <h4>Terça-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="2_abertura" value="{{!empty($horario) ? $horario->hora_abertura : old('2_abertura')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="2_fechamento" value="{{!empty($horario) ? $horario->hora_fechamento : old('2_fechamento')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                </div>
                                @elseif($horario->dia_semana == 3 && $horario->restaurante_id == $restaurante->id)
                                <div class="row mt-3">
                                    <h4>Quarta-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="3_abertura" value="{{!empty($horario) ? $horario->hora_abertura : old('3_abertura')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="3_fechamento" value="{{!empty($horario) ? $horario->hora_fechamento : old('3_fechamento')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                </div>
                                @elseif($horario->dia_semana == 4 && $horario->restaurante_id == $restaurante->id)
                                <div class="row mt-3">
                                    <h4>Quinta-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="4_abertura" value="{{!empty($horario) ? $horario->hora_abertura : old('4_abertura')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="4_fechamento" value="{{!empty($horario) ? $horario->hora_fechamento : old('4_fechamento')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                </div>
                                @elseif($horario->dia_semana == 5 && $horario->restaurante_id == $restaurante->id)
                                <div class="row mt-3">
                                    <h4>Sexta-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="5_abertura" value="{{!empty($horario) ? $horario->hora_abertura : old('5_abertura')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="5_fechamento" value="{{!empty($horario) ? $horario->hora_fechamento : old('5_fechamento')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                </div>
                                @elseif($horario->dia_semana == 6 && $horario->restaurante_id == $restaurante->id)
                                <div class="row mt-3">
                                    <h4>Sabádo</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="6_abertura" value="{{!empty($horario) ? $horario->hora_abertura : old('6_abertura')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="6_fechamento" value="{{!empty($horario) ? $horario->hora_fechamento : old('6_fechamento')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                </div>
                                @elseif($horario->dia_semana == 0 && $horario->restaurante_id == $restaurante->id)
                                <div class="row mt-3">
                                    <h4>Domingo</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="0_abertura" value="{{!empty($horario) ? $horario->hora_abertura : old('0_abertura')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="0_fechamento" value="{{!empty($horario) ? $horario->hora_fechamento : old('0_fechamento')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                </div>
                                @endif
                                @endforeach


                                @else
                                <div class="row mt-3">
                                    <h4>Segunda-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="1_abertura"
                                            value="{{!empty($horario) ? $horario->hora_abertura : old('1_abertura')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="1_fechamento"
                                            value="{{!empty($horario) ? $horario->hora_fechamento : old('1_fechamento')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h4>Terça-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="2_abertura" value="{{!empty($horario) ? $horario->hora_abertura : old('2_abertura')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="2_fechamento" value="{{!empty($horario) ? $horario->hora_fechamento : old('2_fechamento')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h4>Quarta-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="3_abertura" value="{{!empty($horario) ? $horario->hora_abertura : old('3_abertura')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="3_fechamento" value="{{!empty($horario) ? $horario->hora_fechamento : old('3_fechamento')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h4>Quinta-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="4_abertura" value="{{!empty($horario) ? $horario->hora_abertura : old('4_abertura')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="4_fechamento" value="{{!empty($horario) ? $horario->hora_fechamento : old('4_fechamento')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h4>Sexta-feira</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="5_abertura" value="{{!empty($horario) ? $horario->hora_abertura : old('5_abertura')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="5_fechamento" value="{{!empty($horario) ? $horario->hora_fechamento : old('5_fechamento')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h4>Sabádo</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="6_abertura" value="{{!empty($horario) ? $horario->hora_abertura : old('6_abertura')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="6_fechamento" value="{{!empty($horario) ? $horario->hora_fechamento : old('6_fechamento')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h4>Domingo</h4>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Abertura</label>
                                        <input type="time" name="0_abertura" value="{{!empty($horario) ? $horario->hora_abertura : old('0_abertura')}}"
                                            class="form-control" id="inputDiaSemana">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputDiaSemana" class="form-label">Fechamento</label>
                                        <input type="time" name="0_fechamento" value="{{!empty($horario) ? $horario->hora_fechamento : old('0_fechamento')}}"
                                            class="form-control" id="inputDiaSemana">
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

        </div>
    </div>
</x-app-layout>