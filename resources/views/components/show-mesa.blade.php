<div class="my-3">

    <!-- HEADER MESA DETALHES -->
    <div class="d-flex justify-content-between align-items-center border p-3 rounded">
        <h4 class="m-0 fw-bold text-black">
            Mesa {{$mesa->nome}}
        </h4>
        <div class="d-flex align-items-center">
            <p class="my-0 mx-1">
                <span class="fw-bold">
                    Tempo:
                </span>
                @if($mesa->hora_abertura != null)
                {{$mesa->hora_abertura}}
                @else
                00h00m
                @endif
            </p>
            <p class="my-0 mx-1">
                <span class="fw-bold">
                    Qtd de itens:
                </span>
                0
            </p>

            <div class="dropdown">
                <a class="btn border d-flex align-items-center ml-2" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span class="material-symbols-outlined">
                        more_vert
                    </span>
                </a>

                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>

        </div>
    </div>
    <!-- HEADER MESA DETALHES -->

    <div class="d-flex align-items-center my-3">
        <span class="material-symbols-outlined fs-3 mr-1">
            account_circle
        </span>
        <p class="m-0 fs-5 fw-semibold">
            Nome cliente
        </p>
    </div>
</div>