<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Travel Connect' }}</title>

    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">

    @vite(['resources/css/styles.css'])
    @vite(['resources/css/app.css'])




</head>

<body>

    <!-- Header con Logo -->
    <header class="py-4 text-center">
        <nav class="relative flex items-center justify-between px-4 py-4 bg-white shadow-md">
            <!-- Logo -->
            <a class="text-3xl font-bold leading-none" href="index.php?seccion=inicio">
                <img src="{{ asset('storage/travel/logo.png') }}" alt="Logo" class="w-32 mx-auto mt-6">
            </a>

            <!-- Botón hamburguesa para móvil -->
            <div class="lg:hidden">
                <button class="flex items-center p-3 text-black-600 navbar-burger" onclick="toggleMenu()">
                    <svg class="block w-5 h-5 fill-current" viewBox="0 0 20 20">
                        <title>Menú</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                    </svg>
                </button>
            </div>

            <!-- Menú principal -->
            <ul id="menu"
                class="absolute hidden text-sm transform -translate-x-1/2 -translate-y-1/2 lg:flex lg:static lg:translate-x-0 lg:translate-y-0 top-1/2 left-1/2 lg:items-center lg:space-x-6">
                <li><a class="font-medium text-gray-600 hover:text-blue-600" href="#carouselExampleCaptions">Inicio</a>
                </li>
                <li><a class="font-medium text-gray-600 hover:text-blue-600" href="#QuienesSomos">Quiénes somos</a></li>
                <li><a class="font-medium text-gray-600 hover:text-blue-600" href="#Caracteristicas">Características</a>
                </li>
                <li><a class="font-medium text-gray-600 hover:text-blue-600" href="#Beneficios">Beneficios</a></li>
                <li><a class="font-medium text-gray-600 hover:text-blue-600" href="#Planes">Planes</a></li>
                <li><a class="font-medium text-gray-600 hover:text-blue-600" href="#NosAcompanan">Nos acompañan</a></li>
                <li><a class="font-medium text-gray-600 hover:text-blue-600" href="#Contacto">Contacto</a></li>
            </ul>
        </nav>

        <!-- Menú lateral para móviles (off-canvas) -->
        <div id="offcanvasMenu" class="fixed inset-0 z-50 hidden bg-black bg-opacity-25 lg:hidden">
            <div class="fixed top-0 right-0 z-50 w-64 h-full p-6 transition-all duration-300 ease-in-out transform translate-x-full bg-white shadow-lg"
                id="sideMenu">
                <div class="flex items-center mb-8">
                    <a class="mr-auto text-3xl font-bold leading-none" href="#">
                        <img src="{{ asset('storage/travel/logo.png') }}" alt="Logo" class="w-10 h-auto">
                    </a>
                    <path xmlns="http://www.w3.org/2000/svg"
                        d="M8284 9162 c-2 -207 -55 -427 -161 -667 -147 -333 -404 -644 -733 -886 -81 -59 -247 -169 -256 -169 -3 0 -18 -9 -34 -20 -26 -19 -344 -180 -354 -180 -3 0 -29 -11 -58 -24 -227 -101 -642 -225 -973 -290 -125 -25 -397 -70 -480 -80 -22 -3 -76 -9 -120 -15 -100 -13 -142 -17 -357 -36 -29 -2 -98 -7 -153 -10 -267 -15 -436 -28 -525 -40 -14 -2 -45 -7 -70 -10 -59 -8 -99 -14 -130 -20 -14 -3 -41 -7 -60 -11 -19 -3 -39 -7 -45 -8 -5 -2 -28 -6 -50 -10 -234 -45 -617 -165 -822 -257 -23 -10 -45 -19 -48 -19 -7 0 -284 -138 -340 -170 -631 -355 -1107 -842 -1402 -1432 -159 -320 -251 -633 -308 -1056 -26 -190 -27 -635 -1 -832 3 -19 7 -59 10 -89 4 -30 11 -84 17 -120 6 -36 12 -77 14 -91 7 -43 33 -174 39 -190 3 -8 7 -28 9 -45 6 -35 52 -221 72 -285 7 -25 23 -79 35 -120 29 -99 118 -283 189 -389 67 -103 203 -244 286 -298 75 -49 178 -103 196 -103 16 0 27 16 77 110 124 231 304 529 485 800 82 124 153 227 157 230 3 3 28 36 54 74 116 167 384 497 546 671 148 160 448 450 560 542 14 12 54 45 90 75 88 73 219 172 313 238 42 29 77 57 77 62 0 5 -13 34 -29 66 -69 137 -149 405 -181 602 -7 41 -14 82 -15 90 -1 8 -6 46 -10 83 -3 37 -8 77 -10 88 -2 11 -7 65 -11 122 -3 56 -8 104 -9 107 -2 3 0 12 5 19 6 10 10 8 15 -10 10 -34 167 -346 228 -454 118 -210 319 -515 340 -515 4 0 40 18 80 40 230 128 521 255 787 343 118 40 336 102 395 113 28 5 53 11 105 23 25 5 59 12 75 15 17 3 41 8 55 11 34 7 274 43 335 50 152 18 372 29 565 29 194 0 481 -11 489 -19 2 -3 -3 -6 -12 -6 -9 -1 -20 -2 -24 -3 -33 -8 -73 -16 -98 -21 -61 -10 -264 -56 -390 -90 -649 -170 -1243 -437 -1770 -794 -60 -41 -121 -82 -134 -93 l-24 -18 124 -59 c109 -52 282 -116 404 -149 92 -26 192 -51 220 -55 17 -3 64 -12 105 -21 71 -14 151 -28 230 -41 19 -3 46 -7 60 -10 14 -2 45 -7 70 -10 25 -4 56 -8 70 -10 14 -2 53 -7 88 -10 35 -4 71 -8 81 -10 10 -2 51 -6 92 -9 101 -9 141 -14 147 -21 3 -3 -15 -5 -39 -6 -24 0 -52 -2 -62 -4 -21 -4 -139 -12 -307 -22 -242 -14 -700 -7 -880 13 -41 4 -187 27 -250 39 -125 23 -274 68 -373 111 -43 19 -81 34 -86 34 -4 0 -16 -8 -27 -17 -10 -10 -37 -33 -59 -52 -166 -141 -422 -395 -592 -586 -228 -257 -536 -672 -688 -925 -21 -36 -43 -66 -47 -68 -4 -2 -8 -7 -8 -11 0 -5 -24 -48 -54 -97 -156 -261 -493 -915 -480 -935 2 -3 47 -21 101 -38 54 -18 107 -36 118 -41 58 -25 458 -138 640 -181 118 -34 243 -71 277 -81 20 -4 46 -7 62 -7 24 0 55 -3 89 -9 49 -7 186 -9 237 -4 28 2 47 12 63 28 101 99 277 293 412 470 67 73 127 140 159 152 32 13 104 21 158 17 90 -8 255 -35 338 -59 81 -24 244 -80 366 -123 39 -14 78 -29 88 -33 34 -23 28 -37 -21 -60z" />
                    </svg>
                    </a>
                    <button class="m-3 close-button" onclick="toggleMenu()">×</button>
                </div>
                <style>
                    @keyframes pulse {

                        0%,
                        100% {
                            transform: scale(1);
                        }

                        50% {
                            transform: scale(1.2);
                        }
                    }

                    .animate-pulse {
                        animation: pulse 1s infinite;
                    }
                </style>

                <ul class="space-y-6 text-gray-600">
                    <li class="mb-1">
                        <a class="flex items-center font-medium" href="#carouselExampleCaptions">
                            <i class="mr-2 text-green-600 bi bi-star animate-pulse"></i>
                            <span>Inicio</span>
                        </a>
                    </li>

                    <li class="mb-1">
                        <a class="flex items-center font-medium" href="#QuienesSomos">
                            <i class="mr-2 text-green-600 bi bi-people animate-pulse"></i>
                            <span>Quiénes somos</span>
                        </a>
                    </li>

                    <li class="mb-1">
                        <a class="flex items-center font-medium" href="#Caracteristicas">
                            <i class="mr-2 text-green-600 bi bi-grid animate-pulse"></i>
                            <span>Características</span>
                        </a>
                    </li>

                    <li class="mb-1">
                        <a class="flex items-center font-medium" href="#Beneficios">
                            <i class="mr-2 text-green-600 bi bi-star animate-pulse"></i>
                            <span>Beneficios</span>
                        </a>
                    </li>

                    <li class="mb-1">
                        <a class="flex items-center font-medium" href="#Planes">
                            <i class="mr-2 text-green-600 bi bi-calendar2-event animate-pulse"></i>
                            <span>Planes</span>
                        </a>
                    </li>

                    <li class="mb-1">
                        <a class="flex items-center font-medium" href="#NosAcompanan">
                            <i class="mr-2 text-green-600 bi bi-people-fill animate-pulse"></i>
                            <span>Nos acompañan</span>
                        </a>
                    </li>

                    <li class="mb-1">
                        <a class="flex items-center font-medium" href="#Contacto">
                            <i class="mr-2 text-green-600 bi bi-envelope animate-pulse"></i>
                            <span>Contacto</span>
                        </a>
                    </li>
                </ul>


            </div>
        </div>
    </header>

    <script>
        // Función para mostrar y ocultar el menú off-canvas
        function toggleMenu() {
            const menu = document.getElementById('offcanvasMenu');
            const sideMenu = document.getElementById('sideMenu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                sideMenu.classList.remove('translate-x-full'); // Desliza el menú
            } else {
                sideMenu.classList.add('translate-x-full'); // Oculta el menú
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 300); // Espera a la animación para ocultarlo
            }
        }
    </script>



    <main>
        <!-- Carrusel de Bootstrap -->
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <h1 style="display: none;">Carrusel</h1>

            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3"
                    aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner">

                <div class="carousel-item active">
                    <img src="{{ asset('storage/travel/1.jpg') }}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('storage/travel/2.jpg.avif') }}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('storage/travel/3.jpg.avif') }}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('storage/travel/4.jpg.png') }}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>


        <section class="text-black welcome-section position-relative">
            <style>
                .welcome-section {
                    position: relative;
                    text-align: center;
                    color: white;
                    height: 7cm;
                    overflow: hidden;
                }

                .welcome-section .background-image {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-repeat: repeat-x;
                    background-position: center;
                    background-attachment: fixed;
                    background-color: rgb(252, 248, 248);
                    z-index: 1;
                }

                .welcome-section .container {
                    position: relative;
                    z-index: 2;
                    padding: 1rem 0;
                }

                .welcome-section h1 {
                    color: white;
                    font-size: 1.5rem;
                }

                .welcome-section p {
                    color: white;
                    font-size: 1rem;
                }
            </style>

            <!-- Imagen de fondo definida en línea -->
            <div class="background-image" style="background-image: url('{{ asset('storage/travel/logosf.png') }}');">
            </div>

            <div class="container text-center">


                @if (isset($textoBienvenida) && isset($textoBienvenida->contenido) && !empty($textoBienvenida->contenido))
                    <p class="mt-2 animate-text lead">
                        {{ $textoBienvenida->contenido }}
                    </p>
                @else
                    <p class="mt-2 animate-text lead">
                        <!-- Texto alternativo si no hay contenido -->
                    </p>
                @endif
            </div>
        </section>




        <section id="QuienesSomos" class="transformacion-negocio-viajes">



            <div class="content-wrapper-viajes">
                <div class="image-container-viajes">

                    <img src="{{ asset('storage/travel/3.jpg.avif') }}" class="image-viajes" alt="Imagen 3">
                </div>

                <div class="text-content-viajes ">
                    <h2 style="margin-bottom:30px; font-size: 2rem;"><strong>Transformación del Negocio de los
                            Viajes</strong></h2>
                    <p>En el pasado, las empresas de viajes dependían principalmente de métodos tradicionales
                        para
                        gestionar sus
                        operaciones, desde la venta manual de boletos hasta la atención al cliente a través de llamadas
                        telefónicas.
                        Sin embargo, la digitalización ha abierto nuevas avenidas que permiten a las empresas de turismo
                        gestionar
                        sus operaciones de manera más eficiente, atractiva y accesible.
                        Travel Connect brinda una solución integral que permite a los agentes de viajes y las PYMEs del
                        sector del
                        turismo transformar su modelo de negocio, aprovechando las herramientas digitales que optimizan
                        todos
                        los
                        aspectos de su operación. Desde la gestión de clientes hasta la automatización de tareas
                        administrativas,
                        pasando por la integración con plataformas de reservas online, CRM, chatbots y sistemas de
                        back-office
                        eficientes, Travel Connect ofrece el conjunto de herramientas necesario para modernizar y
                        agilizar los
                        procesos, haciendo que el negocio sea más rentable y competitivo en el mercado actual.</p>
                </div>
            </div>



            <div class="content-wrapper-viajes2">
                <div class="image-container-viajes2">

                    <img src="{{ asset('storage/travel/mision 3.jpg') }}" class="image-viajes2" alt="Misión 3">
                </div>

                <div class="text-content-viajes2">
                    <h2 class="section-title" style="color: #333">Del
                        Modelo Tradicional al Digital</h2>
                    <p>El Futuro del Turismo Está en la Digitalización. La digitalización es el futuro del sector de
                        viajes y
                        turismo, y Travel Connect está aquí para guiar a los agentes de viajes y PYMEs en este proceso
                        de
                        transformación. Al adoptar nuestras soluciones, estas empresas no solo mejoran su eficiencia
                        operativa,
                        sino que también se posicionan como líderes en un mercado cada vez más competitivo, ofreciendo
                        un
                        servicio de calidad que se adapta a las expectativas de los clientes del siglo XXI.</p>

                    <p>Travel Connect también permite integrar y optimizar el uso de las redes sociales, lo que mejora
                        la
                        visibilidad y la interacción con los clientes. Las herramientas de automatización y análisis
                        permiten
                        gestionar campañas de marketing digital, interactuar con clientes potenciales y medir el impacto
                        de las
                        acciones. Esta integración facilita la captación de leads cualificados y la conversión de
                        interacciones
                        en oportunidades de ventas.</p>
                </div>
            </div>
        </section>



        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Observador de intersección para detectar cuando la sección entra en el viewport
                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('in-view');
                            observer.unobserve(entry
                                .target); // Deja de observar una vez que se ha mostrado
                        }
                    });
                }, {
                    threshold: 0.5
                }); // 50% de la sección debe ser visible

                // Observamos las secciones correspondientes
                const sections = document.querySelectorAll('.content-wrapper, .content-wrapper1');
                sections.forEach(section => observer.observe(section));
            });
        </script>


        <section id="Caracteristicas" class="caracteristicas">
            <div class="containerCaracterisitcas">
                <h2 class="section-title" style="color: #333; text-align: center;">Características</h2>

                <!-- Contenedor general flexible -->
                <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center;">

                    <!-- Tarjeta 1 -->
                    <div style="flex: 1 1 250px; max-width: 300px;">
                        <div style="text-align: center; margin-bottom: 1rem;">
                            <img src="{{ asset('storage/travel/integrarnos.jpg') }}" alt="Integración"
                                style="max-width: 100%; height: auto;">
                        </div>
                        <div
                            style="background: linear-gradient(0deg, rgba(203, 230, 138, 1) 0%, rgba(92, 179, 95, 1) 42%);
                            padding: 2rem;
                            display: flex;
                            flex-direction: column;
                            justify-content: center;
                            align-items: center;
                            text-align: center;
                            min-height: 200px;
                            border-radius: 12px;
                            box-sizing: border-box;">
                            <h3><strong>Integrar</strong></h3>
                            <p>Con los principales contenidos del mercado.</p>
                        </div>
                    </div>

                    <!-- Tarjeta 2 -->
                    <div style="flex: 1 1 250px; max-width: 300px;">
                        <div style="text-align: center; margin-bottom: 1rem;">
                            <img src="{{ asset('storage/travel/vincular.jpg') }}" alt="Vincular"
                                style="max-width: 100%; height: auto;">
                        </div>
                        <div
                            style="background: linear-gradient(0deg, rgba(203, 230, 138, 1) 0%, rgba(92, 179, 95, 1) 42%);
                            padding: 2rem;
                            display: flex;
                            flex-direction: column;
                            justify-content: center;
                            align-items: center;
                            text-align: center;
                            min-height: 200px;
                            border-radius: 12px;
                            box-sizing: border-box;">
                            <h3><strong>Vincular</strong></h3>
                            <p>Desde la web hasta el back office pasando por procesos intermedios.</p>
                        </div>
                    </div>

                    <!-- Tarjeta 3 -->
                    <div style="flex: 1 1 250px; max-width: 300px;">
                        <div style="text-align: center; margin-bottom: 1rem;">
                            <img src="{{ asset('storage/travel/activar.jpg') }}" alt="Marketing Digital"
                                style="max-width: 100%; height: auto;">
                        </div>
                        <div
                            style="background: linear-gradient(0deg, rgba(203, 230, 138, 1) 0%, rgba(92, 179, 95, 1) 42%);
                            padding: 2rem;
                            display: flex;
                            flex-direction: column;
                            justify-content: center;
                            align-items: center;
                            text-align: center;
                            min-height: 200px;
                            border-radius: 12px;
                            box-sizing: border-box;">
                            <h3><strong>Activar</strong></h3>
                            <p>El marketing digital para la generación de la demanda.</p>
                        </div>
                    </div>

                    <!-- Tarjeta 4 -->
                    <div style="flex: 1 1 250px; max-width: 300px;">
                        <div style="text-align: center; margin-bottom: 1rem;">
                            <img src="{{ asset('storage/travel/nosotros 4.jpg') }}" alt="Negociar"
                                style="max-width: 100%; height: auto;">
                        </div>
                        <div
                            style="background: linear-gradient(0deg, rgba(203, 230, 138, 1) 0%, rgba(92, 179, 95, 1) 42%);
                            padding: 2rem;
                            display: flex;
                            flex-direction: column;
                            justify-content: center;
                            align-items: center;
                            text-align: center;
                            min-height: 200px;
                            border-radius: 12px;
                            box-sizing: border-box;">
                            <h3><strong>Negociar</strong></h3>
                            <p>Siempre desde una visión digital.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>




        <section id="Beneficios">
            <h2 class="section-title" style="color: #333; text-align: center;">Beneficios</h2>
            <section class="beneficios-section">
                <style>
                    .beneficios-section {
                        display: flex;
                        gap: 40px;
                        justify-content: center;
                        align-items: stretch;
                        padding: 80px 20px;
                        background-image: url('https://img.freepik.com/foto-gratis/dos-companeros-trabajo-trabajando-nueva-estrategia-empresarial_329181-17664.jpg');
                        background-size: cover;
                        background-attachment: fixed;
                        background-position: center;
                        background-color: rgba(0, 0, 0, 0.4);
                        /* Oscurece la imagen */
                        background-blend-mode: darken;
                        flex-wrap: wrap;
                        width: 100%;
                        box-sizing: border-box;

                    }


                    /* Pantallas más grandes: cambia a fila */
                    @media (min-width: 880px) {
                        .beneficios-section {
                            flex-direction: row;
                            gap: 30px;
                        }
                    }

                    .beneficio-columna {
                        background-color: rgba(255, 255, 255, 0.8);
                        flex: 1;
                        margin: 10px;
                        max-width: 420px;
                        min-width: 280px;
                        height: auto;
                        padding: 30px;
                        border-radius: 15px;
                        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
                        transition: transform 0.8s ease, opacity 0.8s ease;
                        opacity: 0;
                        transform: translateY(50px);
                        color: #333;
                    }

                    .beneficio-columna h3 {
                        font-size: 2rem;
                        font-weight: bold;
                        margin-bottom: 20px;

                    }

                    .beneficio-columna p,
                    .beneficio-columna ul {
                        font-size: 1.1rem;
                        line-height: 1.6;

                    }

                    .beneficio-columna ul {
                        padding-left: 20px;
                    }

                    .izquierda {
                        animation: slideInLeft 1s forwards;
                    }

                    .derecha {
                        animation: slideInRight 1s forwards;
                    }

                    @keyframes slideInLeft {
                        from {
                            transform: translateX(-100px);
                            opacity: 0;
                        }

                        to {
                            transform: translateX(0);
                            opacity: 1;
                        }
                    }

                    @keyframes slideInRight {
                        from {
                            transform: translateX(100px);
                            opacity: 0;
                        }

                        to {
                            transform: translateX(0);
                            opacity: 1;
                        }
                    }

                    /* Media Queries */

                    @media (max-width: 1200px) {
                        .beneficios-section {
                            flex-direction: row;
                            /* Mantener en una fila pero más compacta */
                            gap: 30px;
                        }

                        .beneficio-columna {
                            max-width: 350px;
                            /* Ajusta el tamaño en pantallas grandes pero no tan grandes */
                        }
                    }

                    @media (max-width: 880px) {
                        .beneficios-section {
                            flex-direction: column;
                            gap: 20px;

                        }

                        .beneficio-columna {
                            max-width: 100%;
                            height: auto;
                            font-size: 1rem
                        }
                    }

                    @media (max-width:380px) {
                        .beneficio-columna h3 {
                            font-size: 1.5rem;
                            height: auto;
                        }

                        .beneficio-columna p,
                        .beneficio-columna ul {
                            font-size: 0.5rem;
                            /* Ajusta el tamaño del texto para pantallas pequeñas */
                        }
                    }
                </style>

                <div class="beneficio-columna izquierda">
                    <h3>Para el asociado</h3>
                    <p>
                        Como asociado, tendrás acceso a herramientas innovadoras que facilitarán el crecimiento de tu
                        agencia y optimizarán los procesos operativos. Entre los beneficios destacados se incluyen:
                    </p>
                    <ul style="color: #555; font-size: 1.2rem; line-height: 1.6; padding-left: 20px;">
                        <li><i class="bi bi-rocket" style="margin-right: 8px; color: #0fc94d;"></i>Maximizar un modelo
                            de negocios productivo por medio de una fuerte impronta tecnológica.</li>
                        <li><i class="bi bi-layers" style="margin-right: 8px; color: #0fc94d;"></i>Contar con un
                            ecosistema digital integrado con productos y procesos para lograr mejores resultados
                            comerciales y operativos en el día a día.</li>
                        <li><i class="bi bi-people" style="margin-right: 8px; color: #0fc94d;"></i>Ser parte de una
                            comunidad activa y con fuerza de desarrollo y crecimiento.</li>
                        <li><i class="bi bi-graph-up" style="margin-right: 8px; color: #0fc94d;"></i>Gestionar de
                            manera eficaz, a través de indicadores y variables del negocio.</li>
                    </ul>
                </div>

                <div class="beneficio-columna derecha">
                    <h3>Más ventajas</h3>
                    <p>
                        Es una plataforma de transformación en donde la emisión automática de aéreos, la web con los
                        paquetes de hoteles y aéreos, los prospectos de consultas, el CRM y el backoffice te ayudarán a
                        optimizar la gestión de tus procesos, mejorar la experiencia del cliente, y aumentar la
                        eficiencia operativa en tu negocio. Todo esto con el objetivo de simplificar y potenciar tu
                        estrategia en el mercado.
                    </p>
                    <ul style="color: #555; font-size: 1.2rem; line-height: 1.6; padding-left: 20px;">
                        <li><i class="bi bi-bar-chart-line" style="margin-right: 8px; color: #0fc94d;"></i>Potencia tu
                            estrategia en el mercado.</li>
                        <li><i class="bi bi-gear" style="margin-right: 8px; color: #0fc94d;"></i>Optimiza la gestión
                            comercial.</li>
                        <li><i class="bi bi-robot" style="margin-right: 8px; color: #0fc94d;"></i>CRM, BackOffice,
                            ChatBot al servicio de tu empresa.</li>
                    </ul>

                </div>

                <script>
                    window.addEventListener("scroll", () => {
                        document.querySelectorAll(".beneficio-columna").forEach((col) => {
                            const pos = col.getBoundingClientRect().top;
                            const trigger = window.innerHeight - 100;

                            if (pos < trigger) {
                                col.style.opacity = "1";
                                col.style.transform = "translateY(0)";
                            }
                        });
                    });
                </script>
            </section>



        </section>



  <section>
            <!-- Banner de imagen -->
            <div
                style="width: 100%; padding-top: 20%;  background-image: url('{{ asset('storage/travel/1.jpg') }}'); background-size: cover; background-position: center;">
            </div>



        </section>




       <section id="Planes" style="max-width: 1200px; margin: 0 auto; padding: 40px; position: relative;
    background: url('https://img.freepik.com/foto-gratis/amable-disenador-cliente-que-discute-color-pared_74855-2806.jpg?uid=R102197663&ga=GA1.1.1238354021.1740411874&semt=ais_hybrid&w=740') no-repeat center center/cover; overflow: hidden;">

    <!-- Capa de opacidad oscura + desenfoque -->
    <div style="
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 0;">
    </div>

    <!-- Contenido principal con z-index mayor -->
    <div style="position: relative; z-index: 1;">

        <h2 class="section-title" style="color: #fff">Planes</h2>
        <p style="color: #f1f1f1;">Somos expertos en tecnología para agencias de viajes.</p>

        <div class="cards-container" style="background: none; display: flex; gap: 20px; flex-wrap: wrap;">

            <!-- Tarjeta 1 -->
            <div class="card card-1">
                <button class="price-btn">Precio: $152000</button>
                <h3>Socio Full</h3>
                <ul>
                    <li>Sitio web</li>
                    <li>Motor reserva aéreos</li>
                    <li>Contenidos dinámicos</li>
                    <li>Acceso coworking</li>
                    <li>Dominio propio</li>
                    <li>Integración backoffice</li>
                </ul>
                <button class="consultar-btn" onclick="consultar(1)">Consultar</button>
            </div>

            <!-- Tarjeta 2 -->
            <div class="card card-2">
                <button class="price-btn">Precio: $120000</button>
                <h3>Socio Basic</h3>
                <ul>
                    <li>Sitio web</li>
                    <li>Motor reserva aéreos</li>
                    <li>Contenidos dinámicos</li>
                    <li>Acceso coworking</li>
                    <li>Dominio propio</li>
                </ul>
                <button class="consultar-btn" onclick="consultar(2)">Consultar</button>
            </div>

            <!-- Tarjeta 3 -->
            <div class="card card-3">
                <button class="price-btn">Precio: $290000</button>
                <h3>Socio Comercial</h3>
                <ul>
                    <li>Sitio web</li>
                    <li>Motor reserva aéreos</li>
                    <li>Contenidos dinámicos</li>
                    <li>Acceso coworking</li>
                    <li>Dominio propio</li>
                    <li>Integración backoffice</li>
                    <li>Gestión comercial</li>
                </ul>
                <button class="consultar-btn" onclick="consultar(3)">Consultar</button>
            </div>
        </div>

        <!-- Formulario de consulta -->
        <div id="formulario-consulta" style="display: none; color: white;">
            <h2 class="section-title">Formulario de consulta</h2>
            <p id="plan-info">Estás solicitando información por el plan número: <span id="plan-numero"></span></p>

            <form action="" method="POST">
                @csrf
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" required>
                </div>
                <div>
                    <label for="email">Correo electrónico:</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div>
                    <label for="consulta">Consulta:</label>
                    <textarea name="consulta" id="consulta" required></textarea>
                </div>
                <button type="submit">Enviar consulta</button>
            </form>

            @if (session('success'))
                <p>{{ session('success') }}</p>
            @endif
        </div>

        <script>
            function consultar(plan) {
                document.getElementById("formulario-consulta").style.display = "block";
                document.getElementById("plan-numero").textContent = plan;
            }
        </script>
    </div>
</section>



        <section id="NosAcompanan" class="px-6 py-6 mt-6 mb-6 bg-gray-100 rounded-lg shadow-lg">
            <h2 class="section-title" style="color: #333; margin-top: 2rem; text-align: center;">Nos acompañan</h2>

            <div class="w-full px-6 py-6 mt-6 mb-6 overflow-hidden">
                <div class="flex whitespace-nowrap animate-scroll-logos">


                    <!-- Primer bloque de logos -->
                    <div class="flex gap-10 shrink-0">
                        @for ($i = 0; $i < 2; $i++)
                            <img src="{{ asset('storage/travel/acompanan1.png') }}" alt="Logo 1"
                                class="object-contain h-12">
                            <img src="{{ asset('storage/travel/acompanan2.png') }}" alt="Logo 2"
                                class="object-contain h-12">
                            <img src="{{ asset('storage/travel/acompanan3.png') }}" alt="Logo 3"
                                class="object-contain h-12">
                            <img src="{{ asset('storage/travel/acompanan4.jpg') }}" alt="Logo 4"
                                class="object-contain h-12">
                            <img src="{{ asset('storage/travel/acompanan5.jpg') }}" alt="Logo 5"
                                class="object-contain h-12">
                            <img src="{{ asset('storage/travel/acompanan6.png') }}" alt="Logo 6"
                                class="object-contain h-12">
                            <img src="{{ asset('storage/travel/acompanan70.png') }}" alt="Logo 7"
                                class="object-contain h-12">
                            <img src="{{ asset('storage/travel/acompanan1.png') }}" alt="Logo 1"
                                class="object-contain h-12">
                            <img src="{{ asset('storage/travel/acompanan2.png') }}" alt="Logo 2"
                                class="object-contain h-12">
                            <img src="{{ asset('storage/travel/acompanan3.png') }}" alt="Logo 3"
                                class="object-contain h-12">
                            <img src="{{ asset('storage/travel/acompanan4.jpg') }}" alt="Logo 4"
                                class="object-contain h-12">
                            <img src="{{ asset('storage/travel/acompanan5.jpg') }}" alt="Logo 5"
                                class="object-contain h-12">
                            <img src="{{ asset('storage/travel/acompanan6.png') }}" alt="Logo 6"
                                class="object-contain h-12">
                            <img src="{{ asset('storage/travel/acompanan70.png') }}" alt="Logo 7"
                                class="object-contain h-12">
                        @endfor

                    </div>
                </div>
        </section>
        <style>
            @media (max-width: 768px) {
                .price-btn {
                    transition: none !important;
                    transform: none !important;
                }

                .price-btn:hover {
                    transform: none !important;
                    background-color: inherit !important;
                    color: inherit !important;
                }

                .consultar-btn:hover {
                    background-color: inherit !important;
                }

            }
        </style>
        <!-- Agregar animación en Tailwind -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Agrega la animación personalizada en Tailwind
                const style = document.createElement('style');
                style.innerHTML = `
            @keyframes scroll-logos {
                0% {
                    transform: translateX(0);
                }
                100% {
                    transform: translateX(-50%);
                }
            }

            .animate-scroll-logos {
                animation: scroll-logos 10s linear infinite;
            }
        `;
                document.head.appendChild(style);
            });
        </script>




<section id="Contacto">
    <div class="contacto-container">
        <div class="contacto-form">
            <h2 class="section-title" style="color: #333">Contacto</h2>
            <p class="contacto-description">Utilizá el siguiente formulario para ponerte en contacto con nosotros. ¡Nos encantaría saber de ti!</p>

            @if(session('success'))
                <div style="color: green">{{ session('success') }}</div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST">
                @csrf

                <div class="form-group">
                    <div>
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                    </div>

                    <div>
                        <label for="apellido">Apellido</label>
                        <input type="text" id="apellido" name="apellido" placeholder="Apellido" required>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" placeholder="54 11 XXXXXXXX" required>
                    </div>

                    <div>
                        <label for="email">Mail</label>
                        <input type="email" id="email" name="email" placeholder="usuario@dominio.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="agencia">¿Es agencia?</label>
                        <input type="text" id="agencia" name="agencia" placeholder="Sí / No" required>
                    </div>

                    <div>
                        <label for="pais">País</label>
                        <select id="paisSelect" name="pais">
                            <option value="">Selecciona un país</option>
                        </select>
                    </div>

                    <div>
                        <label for="provincia">Provincia</label>
                        <select id="ciudadSelect" name="provincia">
                            <option value="">Selecciona una ciudad</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div style="width: 100%;">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" placeholder="Escribí tu mensaje aquí..." required></textarea>
                    </div>
                </div>

                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paisSelect = document.getElementById('paisSelect');
            const ciudadSelect = document.getElementById('ciudadSelect');

            // 1️⃣ Cargar países desde la API y ordenarlos alfabéticamente
            fetch('https://restcountries.com/v3.1/all')
                .then(response => response.json())
                .then(data => {
                    paisSelect.innerHTML = '<option value="">Selecciona un país</option>';

                    // Ordenar alfabéticamente por nombre común
                    data.sort((a, b) => a.name.common.localeCompare(b.name.common));

                    data.forEach(pais => {
                        const option = document.createElement('option');
                        option.value = pais.cca2; // Código ISO 3166-1 alfa-2 (ej: AR, US)
                        option.textContent = pais.name.common;
                        paisSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error al cargar los países:', error);
                    paisSelect.innerHTML = '<option value="">Error al cargar países</option>';
                });

            // 2️⃣ Cargar ciudades cuando se seleccione un país
            paisSelect.addEventListener('change', function() {
                const countryCode = this.value; // Código del país seleccionado
                ciudadSelect.innerHTML = '<option value="">Cargando ciudades...</option>';

                if (!countryCode) {
                    ciudadSelect.innerHTML = '<option value="">Selecciona un país primero</option>';
                    return;
                }

                // 🔹 Reemplaza 'TU_USUARIO_GEONAMES' con tu usuario de GeoNames
                fetch(
                        `http://api.geonames.org/searchJSON?country=${countryCode}&featureClass=P&maxRows=50&username=paolanovick`
                    )
                    .then(response => response.json())
                    .then(data => {
                        ciudadSelect.innerHTML = '<option value="">Selecciona una ciudad</option>';

                        if (data.geonames.length === 0) {
                            ciudadSelect.innerHTML =
                                '<option value="">No hay ciudades disponibles</option>';
                            return;
                        }

                        // Ordenar las ciudades alfabéticamente
                        data.geonames.sort((a, b) => a.name.localeCompare(b.name));

                        data.geonames.forEach(ciudad => {
                            const option = document.createElement('option');
                            option.value = ciudad.name;
                            option.textContent = ciudad.name;
                            ciudadSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error al cargar las ciudades:', error);
                        ciudadSelect.innerHTML = '<option value="">Error al cargar ciudades</option>';
                    });
            });
        });
    </script>

</section>
    </main>



    <!-- Footer  -->
    <footer class="footer">
        <div class="container">
            <div class="row justify-content-center">
                <div class="mb-4 text-center col-md-3 social-section">
                    <h4 class="footer-title">¡Seguinos!
                        <a href="https://www.instagram.com/travelconnectar/" target="_blank" class="social-icon"><i
                                class="bi bi-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/travelconnectarg/posts/?feedView=all"
                            target="_blank" class="social-icon"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>

        <div class="text-center row contact-info">
            <div class="col-12">
                <p><i class="mr-2 fas fa-phone"></i> +(54) 11 5578 6993</p>
            </div>
        </div>

        <div class="text-center row contact-info">
            <div class="col-12">
                <p>Empresa de servicios tecnológicos: <strong> TRAVEL CONNECT </strong> - Buenos Aires, Argentina. ©
                    Todos los derechos reservados.</p>
            </div>
        </div>

        <div class="text-center row">
            <div class="col-12">
                <p><span class="consumer-defense">Defensa del consumidor. Para reclamos <a
                            href="https://www.argentina.gob.ar/produccion/defensadelconsumidor/formulario"
                            target="_blank">ingrese aquí</a></span></p>
            </div>
        </div>

        <div class="mt-5 text-center row">
            <div class="col-12">
                <p class="text-white">

                    <span>&copy; 2025 Idea Original - Todos los derechos reservados</span>
                </p>
            </div>
        </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>