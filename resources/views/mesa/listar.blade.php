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
        <div class="row">
            <div class="col">
                <h2 class="my-3 fw-bolder fs-1">
                    Mesas <span class="text-secondary fs-3">
                        ({{$data['mesas']->count()}})
                    </span>
                </h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn bg-padrao text-white fw-semibold d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    <span class="material-symbols-outlined">
                        add
                    </span>
                    Cadastrar
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- MODAL CADASTRO MESA -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5" id="exampleModalLabel">
                            Cadastro de mesa
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <!-- FORM -->
                        <form action="{{!empty($mesa) ? '/mesa/alterar/' . $mesa->id : '/mesa/cadastrar/'}}"
                            method="post" autocomplete="off" enctype="multipart/form-data">
                            @csrf

                            <div class="form-floating">
                                <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome"
                                    id="floatingInput" value="{{!empty($mesa) ? $mesa->nome : old('nome')}}"
                                    placeholder="TESTE10" required {{!empty($mesa) ? 'readonly disabled' : ''}}>
                                <label for="floatingInput" class="text-secondary fw-semibold">
                                    Nome ou número da mesa
                                </label>
                            </div>

                            <!-- BTN SUBMIT -->
                            <div class="mt-3 d-flex justify-content-end">
                                <a href="{{url()->previous()}}" class="btn text-padrao mx-1">Voltar</a>
                                <button type="submit" class="btn bg-padrao text-white fw-bolder">
                                    {{!empty($mesa) ? 'Editar' : 'Cadastrar'}}
                                </button>

                            </div>

                        </form>
                        <!-- FIM FORM -->

                    </div>
                </div>
            </div>
        </div>
        <!-- FIM MODAL CADASTRO MESA -->

        <!-- MESAS -->
        @if($data['mesas'] != null)
        @foreach($data['mesas'] as $mesa)
        {{$mesa->nome}}
        @endforeach
        @endif

    </div>
</x-app-layout>