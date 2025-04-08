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



</head>

<body>

    <!-- Header con Logo -->
    <header class="text-center py-4 ">
        <img src="/travel/logo.png" alt="Logo">

    </header>

    <main>
        <!-- Carrusel de Bootstrap -->
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
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
                    <img src="{{ asset('storage/travel/2.jpg.avif') }}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('storage/travel/2jpg.png') }}" class="d-block w-100" alt="...">
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


        <section class="welcome-section position-relative text-black">
            <div class="background-image"></div>
            <div class="container text-center py-5">
                <h1 class="animate-title">¡Bienvenidos a TravelConnect!</h1>

                @if (isset($textoBienvenida) && isset($textoBienvenida->contenido) && !empty($textoBienvenida->contenido))
                    <p class="animate-text lead mt-3">
                        {{ $textoBienvenida->contenido }}
                    </p>
                @else
                    <p class="animate-text lead mt-3">

                    </p>
                @endif

            </div>
        </section>


        <section class="transformacion-negocio-viajes">
            <h2><strong>Transformación del Negocio de los Viajes: Del Modelo Tradicional al Digital</strong></h2>

            <div class="content-wrapper-viajes">
                <div class="image-container-viajes">

                    <img src="{{ asset('/travel/3.jpg.avif') }}" class="image-viajes" alt="Imagen 3">
                </div>

                <div class="text-content-viajes ">
                    <p>En el pasadooooooooo, las empresas de viajes dependían principalmente de métodos tradicionales
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


        <section class="caracteristicas">
            <div class="containerCaracterisitcas">
                <h2 class="section-title">Características</h2>
                <div class="rowCaracteristicas">
                    <!-- Contenedor para cada tarjeta e imagen -->
                    <div class="custom-feature-container">
                        <!-- Imagen fuera de la tarjeta -->
                        <div class="custom-feature-image">
                            <img src="{{ asset('storage/travel/integrarnos.jpg') }}" alt="Integración">
                        </div>
                        <!-- Contenedor de la tarjeta -->
                        <div class="custom-feature-item">
                            <h3>Integrarnos</h3>
                            <p>Con los principales contenidos del mercado.</p>
                        </div>
                    </div>

                    <div class="custom-feature-container">
                        <div class="custom-feature-image">
                            <img src="{{ asset('storage/travel/vincular.jpg') }}" alt="Vincular">
                        </div>
                        <div class="custom-feature-item">
                            <h3>Vincular</h3>
                            <p>Desde la web hasta el back office pasando por procesos intermedios.</p>
                        </div>
                    </div>

                    <div class="custom-feature-container">
                        <div class="custom-feature-image">
                            <img src="{{ asset('storage/travel/activar.jpg') }}" alt="Marketing Digital">
                        </div>
                        <div class="custom-feature-item">
                            <h3>Activar</h3>
                            <p>El marketing digital para la generación de la demanda.</p>
                        </div>
                    </div>

                    <div class="custom-feature-container">
                        <div class="custom-feature-image">
                            <img src="{{ asset('storage/travel/nosotros 4.jpg') }}" alt="Negociar">
                        </div>
                        <div class="custom-feature-item">
                            <h3>Negociar</h3>
                            <p>Siempre desde una visión digital.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <!-- Banner de imagen -->
            <div
                style="width: 100%; padding-top: 20%; background-image: url('{{ asset('storage/travel/1.jpg') }}'); background-size: cover; background-position: center;">
            </div>



        </section>



        <h1 class="beneficios">Beneficios</h1>
        <section style="display: flex; justify-content: center; padding: 40px; background-color: #f51a1a;">
            <div style="display: flex; gap: 40px; max-width: 1200px; width: 100%;">
                <!-- Columna 1 -->
                <div
                    style="flex: 1; background-color: #f51a1a; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <h3 style="color: #333;">Beneficios principales</h3>
                    <p style="color: #555; font-size: 1.2rem; line-height: 1.6;">
                        Es una plataforma de transformación en donde la emisión automática de aéreos, la web con los
                        paquetes de hoteles y aéreos, los prospectos de consultas, el CRM y el backoffice te ayudarán a
                        optimizar la gestión de tus procesos, mejorar la experiencia del cliente, y aumentar la
                        eficiencia operativa en tu negocio. Todo esto con el objetivo de simplificar y potenciar tu
                        estrategia en el mercado.
                    </p>
                </div>

                <!-- Columna 2 -->
                <div
                    style="flex: 1; background-color: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <h3 style="color: #333;">Beneficios para el asociado</h3>
                    <p style="color: #555; font-size: 1.2rem; line-height: 1.6;">
                        Como asociado, tendrás acceso a herramientas innovadoras que facilitarán el crecimiento de tu
                        agencia y optimizarán los procesos operativos. Entre los beneficios destacados se incluyen:
                    </p>
                    <ul style="color: #555; font-size: 1.2rem; line-height: 1.6; padding-left: 20px;">
                        <li>Maximizar un modelo de negocios productivo por medio de una fuerte impronta tecnológica.
                        </li>
                        <li>Contar con un ecosistema digital integrado con productos y procesos para lograr mejores
                            resultados comerciales y operativos en el día a día.</li>
                        <li>Ser parte de una comunidad activa y con fuerza de desarrollo y crecimiento.</li>
                        <li>Gestionar de manera eficaz, a través de indicadores y variables del negocio.</li>
                    </ul>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const words = ['FIDELIZAR', 'CAPTAR', 'INNOVAR', 'GENERAR'];
                    const animatedText = document.querySelector('.animated-text');
                    let currentIndex = 0;

                    const animateWord = () => {
                        animatedText.style.opacity = 0; // Ocultar palabra actual
                        animatedText.style.transform = 'translateX(100%)'; // Posición inicial fuera de la pantalla
                        setTimeout(() => {
                            animatedText.textContent = words[currentIndex]; // Cambiar palabra
                            animatedText.style.opacity = 1; // Mostrar palabra
                            animatedText.style.transform = 'translateX(0)'; // Mover palabra al centro
                            currentIndex = (currentIndex + 1) % words.length; // Siguiente palabra
                        }, 900); // Tiempo para actualizar la palabra
                    };

                    setInterval(animateWord, 5000); // Cambiar palabras cada 3 segundos
                    animateWord(); // Iniciar animación
                });
            </script>

        </section>

        <!-- Script para cambiar las palabras -->



        <section style="display: flex; align-items: center; justify-content: center; gap: 20px;">
            <div
                style="margin-top: 20px; padding: 20px; ; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <h1><strong> Planes</strong></h1>
                <p>Somos expertos en tecnología para agencias de viajes.</p>

                <div class="cards-container">
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
                        <button class="price-btn price-btn-3">Precio: $290000</button>
                        <h5>Socio <br>con sistema de <br>gestion comercial</h5>
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
                <div id="formulario-consulta" style="display: none;">
                    <h2>Formulario de consulta</h2>
                    <p id="plan-info">Estás solicitando información por el plan número: <span id="plan-numero"></span>
                    </p>

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
                        // Mostrar el formulario
                        document.getElementById("formulario-consulta").style.display = "block";

                        // Actualizar el número de plan en el mensaje
                        document.getElementById("plan-numero").textContent = plan;
                    }
                </script>
            </div>

        </section>
        <section>
            <div class="contacto-container">
                <div class="contacto-form">
                    <h1 class="contacto-title">Contacto</h1>
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



    <!-- Footer (versión que ya diseñamos) -->
    <footer class="footer">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-3 text-center mb-4 social-section">
                    <h4 class="footer-title">¡Seguinos!
                        <a href="https://www.instagram.com/travelconnectar/" target="_blank" class="social-icon"><i
                                class="bi bi-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/travelconnectarg/posts/?feedView=all"
                            target="_blank" class="social-icon"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>

        <div class="row text-center contact-info">
            <div class="col-12">
                <p><i class="fas fa-phone mr-2"></i> (11) 5578 6993</p>
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
                    Diseñado por <strong><a href="mailto:paonovick@hotmail.com" class="text-white">Paola
                            Novick</a></strong> - <span>Diseñadora Web</span> <br>
                    <span>&copy; 2024 Idea Original - Todos los derechos reservados</span>
                </p>
            </div>
        </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
