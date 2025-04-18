<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO y Metadatos -->
    <title>{{ $title ?? 'Travel Connect' }}</title>
    <meta name="description" content="Transformamos agencias de viajes  con soluciones digitales. -RED DE AGENCIAS- CRM, reservas online, chatBot y más. Travel Connect Red de Agenias.">
    <meta name="keywords" content="agencias de viajes, tecnología, digitalización, ChatBot con IA, CRM, turismo, Travel Connect">
    <meta name="author" content="Travel Connect">
    <meta name="robots" content="index, follow">

    <!-- Open Graph (Facebook, LinkedIn, etc.) -->
    <meta property="og:title" content="{{ $title ?? 'Travel Connect - RED DE AGENCIAS - Transformación Digital para Agencias de Viajes' }}">
    <meta property="og:description" content="Digitalizamos tu agencia de viajes. Automatización, gestión de clientes, reservas online, CRM, ChatBot con IA y más.">
    <meta property="og:image" content="{{ asset('storage/travel/og-image.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Travel Connect">
    <meta property="og:locale" content="es_AR">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? 'Travel Connect - Soluciones Tecnológicas para Turismo' }}">
    <meta name="twitter:description" content="Potenciamos agencias de viajes con herramientas digitales. Soluciones integrales para crecer en el mercado actual.">
    <meta name="twitter:image" content="{{ asset('storage/travel/og-image.png') }}">
    <meta name="twitter:site" content="@travelconnectar">

    <!-- Redes Sociales -->
    <link rel="me" href="https://www.instagram.com/travelconnectar/">
    <link rel="me" href="https://www.linkedin.com/company/travelconnectarg">

    <!-- Icono del sitio -->
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">

    <!-- Estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    @vite(['resources/css/styles.css'])
    @vite(['resources/css/app.css'])
</head>


<body>

    <!-- Header con Logo -->
 <header class="text-center py-4">
    <nav class="relative flex items-center justify-between px-4 py-4 bg-white shadow-md z-50">
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

        <!-- Menú principal (pantallas grandes) -->
        <ul id="menu"
            class="absolute hidden lg:flex lg:static transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 lg:items-center lg:space-x-6 text-sm">
            <li><a class="text-gray-600 hover:text-blue-600 font-medium" href="#carouselExampleCaptions">Inicio</a></li>
            <li><a class="text-gray-600 hover:text-blue-600 font-medium" href="#QuienesSomos">Quiénes somos</a></li>
            <li><a class="text-gray-600 hover:text-blue-600 font-medium" href="#Caracteristicas">Características</a></li>
            <li><a class="text-gray-600 hover:text-blue-600 font-medium" href="#Beneficios">Beneficios</a></li>
            <li><a class="text-gray-600 hover:text-blue-600 font-medium" href="#Planes">Planes</a></li>
            <li><a class="text-gray-600 hover:text-blue-600 font-medium" href="#NosAcompanan">Nos acompañan</a></li>
            <li><a class="text-gray-600 hover:text-blue-600 font-medium" href="#Contacto">Contacto</a></li>
        </ul>
    </nav>

    <!-- Menú lateral para móviles -->
    <div id="offcanvasMenu" class="fixed inset-0 z-50 bg-black bg-opacity-25 hidden lg:hidden">
        <div class="fixed top-0 right-0 w-64 bg-white shadow-lg p-6 h-full transform translate-x-full transition-all duration-300 ease-in-out" id="sideMenu">
            <div class="flex items-center justify-between mb-8">
                <a href="#">
                    <img src="{{ asset('storage/travel/logo.png') }}" alt="Logo" class="w-10 h-auto ">
                </a>
                <button class="text-3xl font-bold p-2 ml-4" onclick="toggleMenu()">×</button>
            </div>

            <ul class="space-y-6 text-gray-600">
                <li><a class="flex items-center font-medium" href="#carouselExampleCaptions" onclick="toggleMenu()">Inicio</a></li>
                <li><a class="flex items-center font-medium" href="#QuienesSomos" onclick="toggleMenu()">Quiénes somos</a></li>
                <li><a class="flex items-center font-medium" href="#Caracteristicas" onclick="toggleMenu()">Características</a></li>
                <li><a class="flex items-center font-medium" href="#Beneficios" onclick="toggleMenu()">Beneficios</a></li>
                <li><a class="flex items-center font-medium" href="#Planes" onclick="toggleMenu()">Planes</a></li>
                <li><a class="flex items-center font-medium" href="#NosAcompanan" onclick="toggleMenu()">Nos acompañan</a></li>
                <li><a class="flex items-center font-medium" href="#Contacto" onclick="toggleMenu()">Contacto</a></li>
            </ul>
        </div>
    </div>

    <!-- Botón flotante para abrir menú en móviles -->
   <!-- Botón flotante para abrir menú en móviles -->
<button
    onclick="toggleMenu()"
    class="fixed bottom-4 right-4 z-50 text-white rounded-full p-3 shadow-lg lg:hidden hover:brightness-110 transition duration-300"
    style="background-color: #0fc94d;"
    title="Abrir menú">
    <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
    </svg>
</button>

</header>

<script>
    function toggleMenu() {
        const menu = document.getElementById('offcanvasMenu');
        const sideMenu = document.getElementById('sideMenu');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            setTimeout(() => {
                sideMenu.classList.remove('translate-x-full');
            }, 10);
        } else {
            sideMenu.classList.add('translate-x-full');
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 300);
        }
    }
</script>

<!-- Scripts -->
<script>
    function toggleMenu() {
        const menu = document.getElementById('offcanvasMenu');
        const sideMenu = document.getElementById('sideMenu');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            sideMenu.classList.remove('translate-x-full');
        } else {
            sideMenu.classList.add('translate-x-full');
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 300);
        }
    }

    // Permite cerrar con la tecla ESC
    document.addEventListener('keydown', function (event) {
        if (event.key === "Escape") {
            const menu = document.getElementById('offcanvasMenu');
            const sideMenu = document.getElementById('sideMenu');
            if (!menu.classList.contains('hidden')) {
                sideMenu.classList.add('translate-x-full');
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 300);
            }
        }
    });
</script>

<!-- Pulsación animada -->
<style>
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    .animate-pulse {
        animation: pulse 1s infinite;
    }
</style>




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


  <section>
            <!-- Banner de imagen -->
            <div
                style="width: 100%; padding-top: 20%; margin-bottom: 30px; background-image: url('{{ asset('storage/travel/1.jpg') }}'); background-size: cover; background-position: center;">
            </div>



        </section>

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




       <section id="Beneficios" style="width: 100%;  padding: 10px; position: relative;">


    <h2 class="section-title" style="color: #333; text-align: center; font-weight: bold;">Beneficios</h2>
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






  <section id="Planes" style="width: 100%; padding: 10px ; position: relative; margin-top: 30px;
background: url('https://img.freepik.com/foto-gratis/amable-disenador-cliente-que-discute-color-pared_74855-2806.jpg') no-repeat center center/cover;
overflow: hidden;">

<!-- Contenido principal -->
<div style="position: relative; z-index: 1;">

     <h2 class="section-title" style="color: #faf5f5; text-align: center; font-weight: bold;">Planes</h2>
    <p style="color: #f1f1f1; text-align: center; font-size:larger;">Somos expertos en tecnología para agencias de viajes.</p>

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
            <a class="consultar-btn" href="https://wa.me/5491123456789?text=Hola,%20quiero%20consultar%20por%20el%20plan%20Socio%20Full" target="_blank">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" style="height: 20px; vertical-align: middle; margin-right: 8px;">
                Consultar
            </a>
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
            <a class="consultar-btn" href="https://wa.me/5491123456789?text=Hola,%20quiero%20consultar%20por%20el%20plan%20Socio%20Basic" target="_blank">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" style="height: 20px; vertical-align: middle; margin-right: 8px;">
                Consultar
            </a>
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
            <a class="consultar-btn" href="https://wa.me/5491123456789?text=Hola,%20quiero%20consultar%20por%20el%20plan%20Socio%20Comercial" target="_blank">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" style="height: 20px; vertical-align: middle; margin-right: 8px;">
                Consultar
            </a>
        </div>
    </div>
</div>

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

</section>

<!-- Estilos para el botón con WhatsApp -->
<style>
    .consultar-btn {
        display: inline-flex;
        align-items: center;
        background-color: #0fc94d;
        color: #0e0d0d;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        text-decoration: none;
        font-weight: bold;
        border-radius: 16px;
    }

    .consultar-btn:hover {
        background-color: #0abf45;
        color: #1a1919;
    }
      .price-btn {
            pointer-events: none;
            background-color: #0fc94d;
            color: #333;
            border: none;
            cursor: default;
            box-shadow: none;
            transform: none;
            transition: none;
        }

    @media (max-width: 768px) {
        .card:hover {
            transform: none !important;
            box-shadow: none !important;
        }

        .consultar-btn {
            box-shadow: none !important;
            transform: none !important;
        }

        .price-btn {
            pointer-events: none;
            background-color: #0fc94d;
            color: #333;
            border: none;
            cursor: default;
            box-shadow: none;
            transform: none;
            transition: none;
        }

        .price-btn:hover,
        .price-btn:active,
        .price-btn:focus {
            background-color: #0fc94d;
            color: #333;
        }
    }
</style>






        <section id="NosAcompanan" class="mt-6 mb-6 py-6 px-6 bg-gray-100 rounded-lg shadow-lg">
            <h2 class="section-title" style="color: #333; margin-top: 2rem; text-align: center;">Nos acompañan</h2>

            <div class="overflow-hidden w-full mt-6 mb-6 py-6 px-6">
                <div class="flex whitespace-nowrap animate-scroll-logos">


                    <!-- Primer bloque de logos -->
                    <div class="flex gap-10 shrink-0">
                        @for ($i = 0; $i < 2; $i++)
                            <img src="{{ asset('storage/travel/acompanan1.png') }}" alt="Logo 1"
                                class="h-12 object-contain">
                            <img src="{{ asset('storage/travel/acompanan2.png') }}" alt="Logo 2"
                                class="h-12 object-contain">
                            <img src="{{ asset('storage/travel/acompanan3.png') }}" alt="Logo 3"
                                class="h-12 object-contain">
                            <img src="{{ asset('storage/travel/acompanan4.jpg') }}" alt="Logo 4"
                                class="h-12 object-contain">
                            <img src="{{ asset('storage/travel/acompanan5.jpg') }}" alt="Logo 5"
                                class="h-12 object-contain">
                            <img src="{{ asset('storage/travel/acompanan6.png') }}" alt="Logo 6"
                                class="h-12 object-contain">
                            <img src="{{ asset('storage/travel/acompanan70.png') }}" alt="Logo 7"
                                class="h-12 object-contain">
                            <img src="{{ asset('storage/travel/acompanan1.png') }}" alt="Logo 1"
                                class="h-12 object-contain">
                            <img src="{{ asset('storage/travel/acompanan2.png') }}" alt="Logo 2"
                                class="h-12 object-contain">
                            <img src="{{ asset('storage/travel/acompanan3.png') }}" alt="Logo 3"
                                class="h-12 object-contain">
                            <img src="{{ asset('storage/travel/acompanan4.jpg') }}" alt="Logo 4"
                                class="h-12 object-contain">
                            <img src="{{ asset('storage/travel/acompanan5.jpg') }}" alt="Logo 5"
                                class="h-12 object-contain">
                            <img src="{{ asset('storage/travel/acompanan6.png') }}" alt="Logo 6"
                                class="h-12 object-contain">
                            <img src="{{ asset('storage/travel/acompanan70.png') }}" alt="Logo 7"
                                class="h-12 object-contain">
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
                    <p class="contacto-description">Utilizá el siguiente formulario para ponerte en contacto con
                        nosotros. ¡Nos
                        encantaría saber de ti!</p>

                    <form action="#" method="POST">
                        <div class="form-group">
                            <div>
                                <label for="nombre">Nombre</label>
                                <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                            </div>

                            <div>
                                <label for="apellido">Apellido</label>
                                <input type="text" id="apellido" name="apellido" placeholder="Apellido"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <label for="telefono">Teléfono</label>
                                <input type="tel" id="telefono" name="telefono" placeholder="54 11 XXXXXXXX"
                                    required>
                            </div>

                            <div>
                                <label for="email">Mail</label>
                                <input type="email" id="email" name="email"
                                    placeholder="usuario@dominio.com" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <label for="agencia">¿Es agencia?</label>
                                <input type="text" id="agencia" name="agencia" placeholder="Sí / No" required>
                            </div>

                            <div>
                                <label for="pais">País</label>
                                <select id="paisSelect">
                                    <option value="">Selecciona un país</option>
                                </select>
                            </div>

                            <div>
                                <label for="provicnia">Provincia</label>
                                <select id="ciudadSelect">
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
                <div class="col-md-3 text-center mb-4 social-section">
                    <h4 class="footer-title">¡Seguinos!
                        <a href="https://www.instagram.com/travelconnectar/" target="_blank" class="social-icon"><i
                                class="bi bi-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/travelconnectarg"
                            target="_blank" class="social-icon"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>

       <div class="row text-center contact-info">
    <div class="col-12">
        <p>
            <i class="fas fa-phone mr-2"></i>
            <a href="tel:+541155786993">+(54) 11 5578 6993</a>
        </p>
    </div>
</div>


        <div class="row text-center contact-info">
            <div class="col-12">
                <p>Empresa de servicios tecnológicos: <strong> TRAVEL CONNECT </strong> - Buenos Aires, Argentina. ©
                    Todos los derechos reservados.</p>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-12">
                <p><span class="consumer-defense">Defensa del consumidor. Para reclamos <a
                            href="https://www.argentina.gob.ar/produccion/defensadelconsumidor/formulario"
                            target="_blank">ingrese aquí</a></span></p>
            </div>
        </div>

        <div class="row text-center mt-5">
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
