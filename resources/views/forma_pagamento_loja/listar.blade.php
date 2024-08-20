<x-app-layout>

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
        <h2 class="my-3 fw-bolder fs-1">Formas de pagamento</h2>
        <!-- FIM HEADER -->

        <!-- CARD FORMAS DE PAGAMENTO -->
        <div class="p-3 bg-white rounded border">

            <!-- FORM -->
            <form action="{{ route('forma_pagamento.cadastrar') }}" method="post">
                @csrf

                <p>Selecione as formas de pagamento aceitas pela sua loja</p>

                <!-- ROW -->
                <div class="row px-3">

                    <!-- FORMAS DE PAGAMENTO -->
                    @foreach($data['formas_pagamento_loja'] as $forma_pagamento)
                    <div class="form-check col-md-6">
                        <input class="form-check-input" type="checkbox" name="formas_pagamento_loja[]"
                            value="{{$forma_pagamento->id}}" id="flexCheckDefault" {{$forma_pagamento->is_ativo == true ? 'checked' : ''}}>
                        <label class="form-check-label d-flex align-items-center" for="flexCheckDefault">
                            <img src="{{ asset('storage/icones-forma-pagamento/' . $forma_pagamento->imagem . '.svg') }}"
                                alt="" width="30px">
                            <span class="ml-1 fw-semibold">
                                {{$forma_pagamento->nome}}
                            </span>
                        </label>
                    </div>
                    @endforeach
                    <!-- FORMAS DE PAGAMENTO -->

                </div>
                <!-- FIM ROW -->

                <div class="d-flex justify-content-end w-100">
                    <button type="submit" class="btn bg-padrao text-white px-5 fw-semibold">
                        Salvar
                    </button>
                </div>
            </form>
            <!-- FIM FORM -->

        </div>
        <!-- FIM CARD FORMAS DE PAGAMENTO -->

    </div>

</x-app-layout>