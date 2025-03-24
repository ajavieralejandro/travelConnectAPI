<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>React en Laravel 2</title>
    <?php echo app('Illuminate\Foundation\Vite')->reactRefresh(); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/frontReactTravel/src/main.tsx']); ?>
</head>
<body>
    <div id="root"></div>

    <script>
        console.log("Estoy iniciando");

        // Simulaciones de diferentes agencias de turismo
        const SIMULACIONES = {
            agencia1: {
                idAgencia: "12345",
                nombreAgencia: "Viajes Express",
                logoAgencia: "/resources/js/reactFrontTravel/assets/logos/viajes_express.png",
                tipografiaAgencia: "Arial",
                colorTipografiaAgencia: "#222222",
                colorFondoAgencia: "#F5F5F5",
                colorPrincipalAgencia: "#FF5733",
                colorSecundarioAgencia: "#33FF57",
                colorTerciarioAgencia: "#0055AA",
                header: {
                    imagenBackground: "/resources/js/reactFrontTravel/assets/header_bg.jpg",
                    imagenBackgroundOpacidad: 0.8
                },
                buscador: {
                    tipografia: "Roboto",
                    tipografiaColor: "#111111",
                    fondoColor: "#FFFFFF",
                    inputColor: "#CCCCCC",
                    calendarioColorPrimario: "#FF5733",
                    calendarioColorSecundario: "#33FF57",
                    botonBuscarColor: "#FF5733",
                    tabsColor: "#0055AA"
                },
                footer: {
                    texto: "Viajes Express © 2025",
                    tipografia: "Tahoma",
                    tipografiaColor: "#FFFFFF",
                    fondoColor: "#000000",
                    iconosColor: "#FF5733",
                    redes: {
                        facebook: "https://facebook.com/viajesexpress",
                        twitter: "https://twitter.com/viajesexpress"
                    },
                    datos: {
                        telefono: "+54 9 11 2345 6789",
                        email: "contacto@viajesexpress.com",
                        ubicacion: "Buenos Aires, Argentina",
                        direccion: "Av. Siempre Viva 123"
                    }
                }
            }
        };

        // Función para cambiar la simulación
        window.cambiarSimulacion = function (agencia) {
            if (SIMULACIONES[agencia]) {
                window.__DATOS_AGENCIA__ = SIMULACIONES[agencia];

                // Actualiza el meta tag
                let metaTag = document.querySelector("meta[name='datos-agencia']");
                if (!metaTag) {
                    metaTag = document.createElement("meta");
                    metaTag.name = "datos-agencia";
                    document.head.appendChild(metaTag);
                }
                metaTag.content = JSON.stringify(window.__DATOS_AGENCIA__);

                // 🔥 Disparar evento para que React lo detecte
                window.dispatchEvent(new Event("cambioSimulacion"));
                console.log("Estado actual de __DATOS_AGENCIA__:", window.__DATOS_AGENCIA__);
            }
        };

        // 🔥 Carga la primera simulación por defecto
        window.cambiarSimulacion("agencia1");

        console.log("Terminé");
    </script>
</body>
</html>
<?php /**PATH C:\Users\amoro\OneDrive\Escritorio\travelConnect\travelConnectAPI\resources\views/tenant2.blade.php ENDPATH**/ ?>