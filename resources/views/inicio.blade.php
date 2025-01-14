<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Foomy</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <link href="{{ asset('css/inicio.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="">

    <nav class="navbar navbar-expand-lg sticky-top bg-white shadow-lg">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{asset('storage/images/logo-black.png')}}" alt="Logo" width="150"
                    class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item mx-1">
                        <a class="nav-link text-black">
                            Planos
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link text-black" href="#">
                            Sobre nós
                        </a>
                    </li>
                    <li class="nav-item dropdown mx-1">
                        <a class="nav-link dropdown-toggle text-black" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Soluções
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        @if (Route::has('login'))
                        @auth('web')
                        <a class="btn btn-dark text-white px-2 fw-bold mx-1" href="{{ url('/dashboard') }}">
                            Dashboard
                        </a>
                        @else
                        <a class="btn btn-dark text-white px-2 fw-bold mx-1" href="{{ route('login') }}">
                            Entrar
                        </a>
                        @endauth
                        @endif
                        <a class="btn bg-padrao text-white px-2 fw-bold mx-1" href="{{ route('register') }}">
                            Experimente gratuitamente
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- INICIO -->
    <section class="h-100 pt-3"
        style="background: linear-gradient(0deg, rgba(255,255,255,1) 0%, rgba(253,1,64,1) 100%);">
        <div class="container">
            <h1 class="text-white text-center" style="font-weight: 900; font-size: 60px;">
                A solução completa <br>para restaurantes
            </h1>
            <div class="justify-content-center">
                <img src="{{asset('storage/images/imagem-inicio.png')}}" alt="Software completo de restaurante"
                    class="w-100">
            </div>
        </div>
    </section>


    <!-- NUMEROS -->
    <section class="bg-white my-3">
        <div class="container">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="fs-1 fw-bolder m-0 text-padrao">
                        + 100
                    </p>
                    <p class="m-0">
                        lojas cadastradas
                    </p>
                </div>
                <div>
                    <p class="fs-1 fw-bolder m-0 text-padrao">
                        + 15 mil
                    </p>
                    <p class="m-0">
                        pedidos recebidos
                    </p>
                </div>
                <div>
                    <p class="fs-1 fw-bolder m-0 text-padrao">
                        3 minutos
                    </p>
                    <p class="m-0">
                        tempo médio de resposta do suporte
                    </p>
                </div>
                <div>
                    <p class="fs-1 fw-bolder m-0 text-padrao">
                        + 96%
                    </p>
                    <p class="m-0">
                        de aprovação dos clientes
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- O QUE OFERECEMOS -->
    <section class="bg-white my-5">
        <div class="container">
            <h2 class="title my-3">
                Somos a solução de software mais completa<br>para seu negócio!
            </h2>


            <div class="row g-3">
                <div class="col-sm-4">
                    <div class="border-circular p-3 h-100 bg-grey">
                        <h3 class="fw-semibold fs-4 mb-3 px-2">
                            Sistema de gestão completo
                        </h3>
                        <p class="d-flex align-items-start fw-light">
                            <span class="material-symbols-outlined fill-icon text-padrao me-2">
                                receipt_long
                            </span>
                            Receba todos seus pedidos do Foomy e iFood em um só lugar.
                        </p>
                        <p class="d-flex align-items-start fw-light">
                            <span class="material-symbols-outlined fill-icon text-padrao me-2">
                                point_of_sale
                            </span>
                            Ponto de Venda (PDV) moderno que organiza informações financeiras, de estoque e pedidos.
                        </p>
                        <p class="d-flex align-items-start fw-light">
                            <span class="material-symbols-outlined fill-icon text-padrao me-2">
                                sports_motorsports
                            </span>
                            Controle toda sua operação de delivery com nossa plataforma completa.
                        </p>
                        <img src="{{asset('storage/images/sistema-metade.png')}}" alt="" class="w-100">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="border-circular p-3 h-100 bg-grey">
                        <h3 class="fw-semibold fs-4 mb-3 px-2">
                            Aplicativo completo para sua loja
                        </h3>
                        <p class="d-flex align-items-start fw-light">
                            <span class="material-symbols-outlined fill-icon text-padrao me-2">
                                kid_star
                            </span>
                            Fidelize seus clientes com cupons, cashback e programa de recompensas.
                        </p>
                        <p class="d-flex align-items-start fw-light">
                            <span class="material-symbols-outlined fill-icon text-padrao me-2">
                                notifications
                            </span>
                            Envie notificações através do app sobre promoções, avisos e o que desejar.
                        </p>
                        <p class="d-flex align-items-start fw-light">
                            <span class="material-symbols-outlined fill-icon text-padrao me-2">
                                shopping_cart
                            </span>
                            Permita que seus clientes façam pedidos pelo app.
                        </p>
                        <img src="{{asset('storage/images/app-metade.png')}}" alt="" class="w-100">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="border-circular p-3 h-100 bg-grey">
                        <h3 class="fw-semibold fs-4 mb-3 px-2">
                            Cardápio digital com QRCode
                        </h3>
                        <p class="d-flex align-items-start fw-light">
                            <span class="material-symbols-outlined fill-icon text-padrao me-2">
                                qr_code
                            </span>
                            Receba pedidos pelo cardápio digital sem a necessidade de um atendente.
                        </p>
                        <p class="d-flex align-items-start fw-light">
                            <span class="material-symbols-outlined fill-icon text-padrao me-2">
                                link
                            </span>
                            Compartilhe o link e receba pedidos também para delivery e retirada no local.
                        </p>
                        <p class="d-flex align-items-start fw-light">
                            <span class="material-symbols-outlined fill-icon text-padrao me-2">
                                currency_exchange
                            </span>
                            Pagamento fácil e direto: os clientes podem pagar no próprio cardápio digital.
                        </p>
                        <img src="{{asset('storage/images/sistema-metade.png')}}" alt="" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- SEM TAXAS -->
    <section>
        <div class="container">
            <p class="text-black text-center" style="font-weight: 900; font-size: 40px;">
                Aqui <span class="text-destaque">não tem taxas por pedido</span> independente do seu faturamento.
            </p>
        </div>
    </section>


    <!-- IMAGEM -->
    <section>
        <img src="{{asset('storage/images/foto-pessoa.png')}}" alt="" class="w-100">
    </section>


    <!-- FUNCIONAMENTO -->
    <section class="">
        <div class="container">
            <h2 class="title my-3">
                Tudo que sua loja precisa, simplesmente <span class="text-destaque">incomparável</span>
            </h2>
            <div class="row">
                <div class="col-sm-3 my-3">
                    <p class="text-padrao fw-semibold fs-4">
                        Financeiro completo
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Controle de caixa
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Demonstração de resultados (DRE)
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Movimentação de caixa
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Contas e carteiras
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Extrato financeiro
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Relatórios completos financeiros e de estoque
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Aviso para reposição de insumos
                    </p>
                </div>
                <div class="col-sm-3 my-3">
                    <p class="text-padrao fw-semibold fs-4">
                        Atendimento de qualidade
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Sistema de frente de caixa (PDV)
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Cardápios personalizados
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Aplicativo para garçons (IOS e Android)
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Mapa para controle de mesas
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Autoatendimento via cardápio digital
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Tela de preparo (KDS)
                    </p>
                </div>
                <div class="col-sm-3 my-3">
                    <p class="text-padrao fw-semibold fs-4">
                        Eficiência nos pedidos
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Abertura e fechamento de mesas e comandas
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Impressão automática na cozinha e caixa
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Fechamento e divisão de conta
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Monitor de preparo KDS
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Receba pedidos vindo do iFood e Aiqfome
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Solicite entregador do iFood, se necessário
                    </p>
                </div>
                <div class="col-sm-3 my-3">
                    <p class="text-padrao fw-semibold fs-4">
                        Seu aplicativo próprio
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        App de delivery e promoções
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Sua logo, seu nome e suas cores
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Dísponibilidade para IOS e Android
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Receba pagamento através do app
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Programa de fidelidade para clientes
                    </p>
                    <p class="d-flex align-items-center fw-light">
                        <span class="material-symbols-outlined text-secondary me-2">
                            check
                        </span>
                        Envie notificações push e WhatsApp.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- AVALIAÇÕES -->
    <section class="py-3">
        <div class="container">
            <p class="title my-3">
                Veja algumas avaliações de nossos clientes...
            </p>
            <div class="border-circular bg-grey p-3 fill-icon">
                <div class="d-flex">
                    <span class="material-symbols-outlined text-warning">
                        star
                    </span>
                    <span class="material-symbols-outlined text-warning">
                        star
                    </span>
                    <span class="material-symbols-outlined text-warning">
                        star
                    </span>
                    <span class="material-symbols-outlined text-warning">
                        star
                    </span>
                    <span class="material-symbols-outlined text-warning">
                        star
                    </span>
                </div>
                <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner fs-3 fw-semibold py-3">
                        <div class="carousel-item active" data-bs-interval="5000">
                            <p>
                                "O Foomy uniu tudo que meu negócio precisa em um só sistema, antes usava um sistema para
                                PDV, outro para cardápio digital e o iFood eram 3 sistemas abertos. Hoje com Foomy
                                consigo tudo isso em um só sistema por um valor menor que pagava nos outros."
                            </p>
                            <p class="fw-semibold m-0 fs-6">
                                Aline Fraga
                            </p>
                            <p class="m-0 text-secondary fw-light fs-6">
                                Gordinho Lanches - Campo Grande MS
                            </p>
                        </div>
                        <div class="carousel-item" data-bs-interval="5000">
                            <p>
                                "O Foomy uniu tudo que meu negócio precisa em um só sistema, antes usava um sistema para
                                PDV, outro para cardápio digital e o iFood eram 3 sistemas abertos. Hoje com Foomy
                                consigo tudo isso em um só sistema por um valor menor que pagava nos outros."
                            </p>
                            <p class="fw-semibold m-0 fs-6">
                                Aline Fraga
                            </p>
                            <p class="m-0 text-secondary fw-light fs-6">
                                Gordinho Lanches - Campo Grande MS
                            </p>
                        </div>
                        <div class="carousel-item" data-bs-interval="5000">
                            <p>
                                "O Foomy uniu tudo que meu negócio precisa em um só sistema, antes usava um sistema para
                                PDV, outro para cardápio digital e o iFood eram 3 sistemas abertos. Hoje com Foomy
                                consigo tudo isso em um só sistema por um valor menor que pagava nos outros."
                            </p>
                            <p class="fw-semibold m-0 fs-6">
                                Aline Fraga
                            </p>
                            <p class="m-0 text-secondary fw-light fs-6">
                                Gordinho Lanches - Campo Grande MS
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section style="background-color: #1A1A1A;">


    </section>


    <!-- FOOTER -->
    <footer class="text-center text-lg-start bg-body-tertiary text-muted">
        <!-- Section: Social media -->
        <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <!-- Left -->
            <div class="me-5 d-none d-lg-block">
                <span>Get connected with us on social networks:</span>
            </div>
            <!-- Left -->


            <!-- Right -->
            <div>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-google"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-github"></i>
                </a>
            </div>
            <!-- Right -->
        </section>
        <!-- Section: Social media -->


        <!-- Section: Links  -->
        <section class="">
            <div class="container text-center text-md-start mt-5">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-gem me-3"></i>Company name
                        </h6>
                        <p>
                            Here you can use rows and columns to organize your footer content. Lorem ipsum
                            dolor sit amet, consectetur adipisicing elit.
                        </p>
                    </div>
                    <!-- Grid column -->


                    <!-- Grid column -->
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Products
                        </h6>
                        <p>
                            <a href="#!" class="text-reset">Angular</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">React</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Vue</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Laravel</a>
                        </p>
                    </div>
                    <!-- Grid column -->


                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Useful links
                        </h6>
                        <p>
                            <a href="#!" class="text-reset">Pricing</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Settings</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Orders</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Help</a>
                        </p>
                    </div>
                    <!-- Grid column -->


                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                        <p><i class="fas fa-home me-3"></i> New York, NY 10012, US</p>
                        <p>
                            <i class="fas fa-envelope me-3"></i>
                            info@example.com
                        </p>
                        <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
                        <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->


        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2021 Copyright:
            <a class="text-reset fw-bold" href="https://mdbootstrap.com/">MDBootstrap.com</a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

</body>


</html>