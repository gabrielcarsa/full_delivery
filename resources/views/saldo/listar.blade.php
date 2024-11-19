<x-app-layout>

    <div class="container">

        <!-- MENSAGENS -->
        <div class="toast-container position-fixed top-0 end-0">
            @if(session('success'))
            <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true">
                <div class="d-flex align-items-center p-3">
                    <span class="material-symbols-outlined fs-1 text-success" style="font-variation-settings:'FILL' 1;">
                        check_circle
                    </span>
                    <div class="toast-body">
                        <p class="fs-5 m-0">
                            {{ session('success') }}
                        </p>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            @endif
            @if (session('error'))
            <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true">
                <div class="d-flex align-items-center p-3">
                    <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                        error
                    </span>
                    <div class="toast-body">
                        <p class="fs-5 m-0">
                            {{ session('error') }}
                        </p>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            @endif
            @if ($errors->any())
            <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="true">
                <div class="d-flex align-items-center p-3">
                    <span class="material-symbols-outlined fs-1 text-padrao" style="font-variation-settings:'FILL' 1;">
                        error
                    </span>
                    <div class="toast-body">
                        @foreach ($errors->all() as $error)
                        <p class="fs-5 m-0">
                            {{ $error }}
                        </p>
                        @endforeach
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
            @endif
        </div>
        <!-- FIM MENSAGENS -->

        <!-- HEADER -->
        <h2 class="mt-3 mb-0 fw-bolder fs-1">
            Saldo
        </h2>
        <p class="text-secondary">
            Conta Corrente: {{$dados['conta_corrente']->nome}}
        </p>
        <!-- FIM HEADER -->

        <div class="bg-white p-3 border rounded">
            <canvas id="graficoSaldo"></canvas>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    // Obtém os dados do PHP e armazena em variáveis JavaScript
    const saldos = {!!json_encode($dados['saldos']) !!};
    const datas = {!!json_encode($dados['datas']) !!};

    const grafico = document.getElementById('graficoSaldo');

    new Chart(grafico, {
        type: 'line',
        data: {
            labels: datas,
            datasets: [{
                label: 'Saldo do dia',
                data: saldos,
                borderWidth: 3,
                borderColor: '#FD0146',
                backgroundColor: '#FD0146',
                tension: 0.1,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</x-app-layout>