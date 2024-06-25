<x-app-layout>

    <!-- CONTAINER -->
    <div class="container">

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

        <!-- HEADER -->
        <div class="row">
            <div class="col">
                <h2 class="my-3 fw-bolder fs-1">
                    Novo pedido - Simulador
                </h2>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- FORMULARIO -->
        <form class="" action="{{ route('pedido.cadastrar') }}" method="post" autocomplete="off">
            @csrf

            <div class="row">
                <div class="col-md-4">
                    <label for="inputQtd" class="form-label">Quantidade</label>
                    <input type="text" name="quantidade" class="form-control" id="inputQtd" required>
                </div>

                @if(!empty($data['produtos']))
                <div class="col-md-8">
                    <label for="inputProduto" class="form-label">Produto</label>
                    <select required id="inputProduto" name="produto_id" class="form-select form-control">
                        <option value="" {{ old('produto_id') == null ? 'selected' : '' }}>-- Selecione --</option>
                        @foreach ($data['produtos'] as $produto)
                        <option value="{{ $produto->id }}" {{ old('produto_id') == $produto->id ? 'selected' : '' }}>
                            {{$produto->nome}} / R$ {{$produto->preco}}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>

            <div class="row my-3">
                <div class="col-md-4">
                    <label for="inputEntrega" class="form-label">Entrega</label>
                    <select required id="inputEntrega" name="entrega" class="form-select form-control">
                        <option value="0">-- Selecione --</option>
                        <option value="1">
                            Comer no local
                        </option>
                        <option value="2">
                            Para viagem
                        </option>
                        <option value="3">
                            Delivery
                        </option>
                    </select>
                </div>

                @if(!empty($data['clientes']))
                <div class="col-md-8">
                    <label for="inputCliente" class="form-label">Cliente</label>
                    <select required id="inputCliente" name="cliente_id" class="form-select form-control">
                        <option value="" {{ old('cliente_id') == null ? 'selected' : '' }}>-- Selecione --</option>
                        @foreach ($data['clientes'] as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $produto->id ? 'selected' : '' }}>
                            {{$cliente->nome}}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>

            <div class="row my-3">
                @if(!empty($data['forma_pagamento_entrega']))
                <div class="col-md-4">
                    <label for="inputForma" class="form-label">Forma de pagamento</label>
                    <select required id="inputForma" name="forma_pagamento_entrega_id" class="form-select form-control">
                        <option value="" {{ old('forma_pagamento_entrega_id') == null ? 'selected' : '' }}>-- Selecione
                            --</option>
                        @foreach ($data['forma_pagamento_entrega'] as $forma)
                        <option value="{{ $forma->id }}"
                            {{ old('forma_pagamento_entrega_id') == $forma->id ? 'selected' : '' }}>
                            {{$forma->forma}}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>

            <!-- ACCORDION ENDEREÇO -->
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#panelsStayOpen-endereco" aria-expanded="false"
                            aria-controls="panelsStayOpen-endereco">
                            Endereço (se for delivery)
                        </button>
                    </h2>
                    <div id="panelsStayOpen-endereco" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-5">
                                    <label for="inputCep" class="form-label">CEP</label>
                                    <input type="text" name="cep"
                                        value="{{!empty($restaurante) ? $restaurante->cep : old('cep')}}"
                                        class="form-control" id="inputCep" required>
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
                                        value="{{!empty($restaurante) ? $restaurante->rua : old('rua')}}"
                                        class="form-control" id="inputRua" required>
                                </div>
                                <div class="col-md-5">
                                    <label for="inputBairro" class="form-label">Bairro</label>
                                    <input type="text" name="bairro"
                                        value="{{!empty($restaurante) ? $restaurante->bairro : old('bairro')}}"
                                        class="form-control" id="inputBairro" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="inputNumero" class="form-label">Número</label>
                                    <input type="text" name="numero"
                                        value="{{!empty($restaurante) ? $restaurante->numero : old('numero')}}"
                                        class="form-control" id="inputNumero" required>
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
                                        class="form-control" id="inputCidade" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="inputEstado" class="form-label">Estado</label>
                                    <input type="text" name="estado"
                                        value="{{!empty($restaurante) ? $restaurante->estado : old('estado')}}"
                                        class="form-control" id="inputEstado" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-12 my-3">
                <button type="submit" class="btn btn-primary">Fazer pedido</button>
            </div>
        </form>
        <!-- FIM FORMULARIO -->

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
</x-app-layout>