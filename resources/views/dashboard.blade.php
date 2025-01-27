<x-app-layout>

    <div class="p-3">

        <!-- SE HOUVER LOJAS CADASTRADAS -->
        @if(!empty($dados['lojas']))

        <div class="row">

        </div>

        <!-- SENÃO HOUVER LOJAS CADASTRADAS -->
        @else

        <div class="d-flex align-items-center justify-content-center">
            <div>
                <p class="m-0 fs-1 my-3 fw-regular">
                    Olá, <span class="fw-semibold">{{Auth::user()->name}}</span>
                </p>

                <p class="m-0 fs-3 my-3 fw-medium">
                    Vamos dar os primeiros passos e criar sua loja aqui?<br>
                    É bem rápido, menos de 5 minutos.
                </p>
                <div class="d-flex justify-content-center my-5">
                    <img src="{{asset("storage/images/criar-loja.svg")}}" width="300px" alt="Foomy">
                </div>
                <a href="{{ route('store.create') }}" class="btn bg-padrao text-white fw-semibold w-100">
                    Criar loja
                </a>
            </div>

        </div>

        @endif
        <!-- FIM SENÃO HOUVER LOJAS CADASTRADAS -->

    </div>

</x-app-layout>