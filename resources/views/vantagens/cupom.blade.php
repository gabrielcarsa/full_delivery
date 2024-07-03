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
                <h2 class="my-3 fw-bolder fs-1">Cupons <span class="text-secondary fs-3">({{$cupons->count()}})</span>
                </h2>
            </div>
            <div class="col d-flex align-items-center justify-content-end p-0">
                <a class="btn btn-primary m-0 py-1 px-5 fw-semibold d-flex align-items-center justify-content-center"
                    href="{{ route('cupom.novo') }}">
                    <span class="material-symbols-outlined mr-1">
                        add
                    </span>
                    Cadastrar
                </a>
            </div>
        </div>
        <!-- FIM HEADER -->

        <!-- TABLE -->
        @if(isset($cupons))

        <table class="table table-padrao border-top table align-middle">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Código</th>
                    <th scope="col">Status</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Desconto</th>
                    <th scope="col">Tipo desconto</th>
                    <th scope="col">Data validade</th>
                    <th scope="col">Limite de uso</th>
                    <th scope="col">Qtd. de usos</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- CUPONS -->
                @foreach ($cupons as $cupom)
                <tr>
                    <td>{{$cupom->id}}</td>
                    <td class="fw-semibold">{{$cupom->codigo}}</td>
                    <td class="fw-semibold {{$cupom->is_ativo ? 'text-success' : 'text-danger'}}">
                        {{$cupom->is_ativo ? 'Ativo' : 'Desativado'}}</td>
                    <td>{{$cupom->descricao}}</td>
                    <td>{{$cupom->tipo_desconto == 1 ? 'R$ '.number_format($cupom->desconto, 2, ',', '.') : $cupom->desconto . '%' }}
                    </td>
                    <td>{{$cupom->tipo_desconto == 1 ? 'Valor fixo' : 'Porcentagem'}}</td>
                    <td>{{\Carbon\Carbon::parse($cupom->data_validade)->format('d/m/Y')}}</td>
                    <td>{{$cupom->limite_uso}}</td>
                    <td>{{$cupom->usos}}</td>
                    <td>
                        <a href="{{ route('cupom.status', ['id' => $cupom->id]) }}"
                            class="acoes-listar text-decoration-none">
                            <span class="material-symbols-outlined {{$cupom->is_ativo ? 'text-danger' : 'text-success'}}">
                                {{$cupom->is_ativo ? 'cancel' : 'check_circle'}}
                            </span>
                        </a>
                        <a href="{{ route('cupom.editar', ['id' => $cupom->id]) }}"
                            class="acoes-listar text-decoration-none">
                            <span class="material-symbols-outlined">
                                edit
                            </span>
                        </a>
                        <a href="" data-bs-toggle="modal" class="acoes-listar text-danger"
                            data-bs-target="#exampleModal{{$cupom->id}}">
                            <span class="material-symbols-outlined">
                                delete
                            </span>
                        </a>
                    </td>

                    <!-- MODAL EXCLUIR -->
                    <div class="modal fade" id="exampleModal{{$cupom->id}}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir
                                        {{$cupom->nome}}?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Essa ação é irreversível! Tem certeza?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                                    <form action="{{ route('cupom.excluir', ['id' => $cupom->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Sim, eu
                                            tenho</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- MODAL EXCLUIR -->

                </tr>
                @endforeach
                <!-- FIM CUPONS -->

            </tbody>
        </table>
        @endif

        <!-- FIM TABLE -->

    </div>

</x-app-layout>