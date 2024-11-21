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
        <div class="">
            <h2 class="my-3 fw-bolder fs-1">
                Estornar {{$estornarRecebimento ? 'recebimento' : 'parcela'}}
            </h2>
        </div>
        <!-- FIM HEADER -->

        <div class="bg-white rounded p-3 border">

            <form action="{{ $estornarRecebimento ? route('parcela.updateEstornarPagamentoRecebimento') : route('parcela.updateEstornarPagamentoRecebimento') }}" method="post">
                @csrf
                @method('PUT')

                <div class="border rounded p-3 my-3">
                    <p class="fw-semibold">
                        {{count($parcelas)}} parcelas a serem estornadas:
                    </p>

                    <!-- TABELA PARCELAS -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col" class="col-1">ID</th>
                                <th scope="col">Nº / Total</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Data Vencimento</th>
                                <th scope="col">Conta Corrente</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($parcelas))
                            @foreach($parcelas as $index => $parcela)

                            <tr class="">
                                <th scope="row">
                                    <input type="text" name="" value="{{ $parcela[0]->id }}" readonly disabled
                                        class="form-control">
                                    <input type="hidden" name="parcela_id[]" value="{{ $parcela[0]->id }}">
                                </th>
                                <th scope="row">
                                    <input type="text" name="" value="{{ $parcela[0]->numero_parcela }} / {{ $parcela[0]->lancamento->quantidade_parcela }}" readonly disabled
                                        class="form-control">
                                </th>
                                <th scope="row">
                                    <input type="text" name="" value="{{ $parcela[0]->lancamento->categoria_financeiro->nome }}" readonly disabled
                                        class="form-control">
                                </th>
                                <th scope="row">
                                    <input type="text" name="valor"
                                        value="{{ number_format($parcela[0]->valor, 2, ',', '.') }}" readonly disabled
                                        class="form-control">
                                </th>
                                <th scope="row">
                                    <input type="text" name="data_vencimento"
                                        value="{{ \Carbon\Carbon::parse( $parcela[0]->data_vencimento )->format('d/m/Y') }}"
                                        readonly disabled class="form-control">
                                </th>
                                <th scope="row">
                                    <input type="text" value="{{ $parcela[0]->movimentacao->conta_corrente->nome }}"
                                        readonly disabled class="form-control">
                                </th>
                            </tr>

                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <!-- FIM TABELA PARCELAS -->

                </div>

                <div class="p-3 d-flex justify-content-end">
                    <button type="submit" class="btn bg-padrao text-white px-5 fw-semibold">
                        Salvar
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>