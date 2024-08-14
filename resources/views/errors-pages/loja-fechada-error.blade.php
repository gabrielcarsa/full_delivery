<x-layout-cardapio>
    <div class="container">
        <div class="vh-100 row d-flex align-items-center justify-content-center">
            <!-- IMAGEM -->
            <div class="col-sm-6 d-flex align-items-center justify-content-center">
                <img src="{{ asset('storage/images/loja-fechada.svg') }}" class="" style="min-width: 150px;">
            </div>
            <!-- FIM IMAGEM -->
            <div class="col-sm-6 px-3">
                <h4>Loja Fechada!</h4>
                <p>
                    Infelizmente não estamos aberto agora, consulte nossos horários de atendimento para saber mais.
                    Vemos
                    você mais tarde!
                </p>
                <a href="{{ route('cardapio', ['loja_id' => $data['loja_id'], 'consumo_local_viagem' => $data['consumo_local_viagem'], 'endereco_selecionado' => $data['endereco_selecionado']]) }}"
                    class="text-decoration-none py-2 px-5 text-white fw-semibold rounded w-100" style="background-color: #FD0146 !important">
                    Voltar início
                </a>
            </div>
        </div>
    </div>



</x-layout-cardapio>