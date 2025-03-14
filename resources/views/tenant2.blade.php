<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>React en Laravel 2</title>
    @viteReactRefresh
    @vite(['resources/js/frontReactTravel/src/main.tsx'])
</head>
<body>
    <div id="root"></div>
    <script>
        function cargarSimulacion(idAgencia) {
          const simulaciones = {
            "001": { // Desierto Aventura
              idAgencia: "001",
              nombreAgencia: "Desierto Aventura",
              logoAgencia: "/logo1.png",
              tipografiaAgencia: "Arial",
              colorTipografiaAgencia: "#F4A261", // Naranja claro
              colorFondoAgencia: "#E76F51", // Rojo tierra
              colorPrincipalAgencia: "#E9C46A", // Amarillo arena
              colorSecundarioAgencia: "#264653", // Azul oscuro
              colorTerciarioAgencia: "#2A9D8F", // Verde desierto

              header: {
                imagenBackground: '{{
            preg_replace('/^https?:\/\/([^\/]+)\//', 'http://tudominio.com/', asset($agencia->fondo_1))
        }}',                imagenBackgroundOpacidad: 0.9
              },

              buscador: {
                tipografia: "Roboto",
                tipografiaColor: "#FFFFFF", // Blanco
                fondoColor: "#E76F51", // Rojo tierra
                inputColor: "#264653", // Azul oscuro
                calendarioColorPrimario: "#E9C46A", // Amarillo arena
                calendarioColorSecundario: "#2A9D8F", // Verde desierto
                botonBuscarColor: "#F4A261", // Naranja claro
                tabsColor: "#264653" // Azul oscuro
              },

              publicidadCliente: {
                existe: true,
                titulo: "Explora el desierto",
                tituloTipografia: "Montserrat",
                tituloTipografiaTamanio: "24px",
                tituloTipografiaColor: "#FFFFFF", // Blanco
                flechasColor: "#E9C46A", // Amarillo arena
                imagenes: ["/desierto.jpg", "/montania.jpg", "/jungla.jpg"]
              },

              destacadosMes: {
                titulo: "Lugares destacados",
                tituloTipografia: "Montserrat",
                tituloTipografiaTamanio: "28px",
                tituloTipografiaColor: "#FFFFFF", // Blanco
                tarjetaTipografia: "Roboto",
                tarjetaTipografiaColor: "#264653", // Azul oscuro
                tarjetaColorPrimario: "#E9C46A", // Amarillo arena
                tarjetaColorSecundario: "#2A9D8F", // Verde desierto
                tarjetaColorTerciario: "#F4A261" // Naranja claro
              },

              bannerRegistro: {
                titulo: "¡Regístrate y obtén descuentos!",
                tituloTipografia: "Montserrat",
                tituloTipografiaTamanio: "24px",
                tituloTipografiaColor: "#FFFFFF", // Blanco
                bannerColor: "#E76F51" // Rojo tierra
              },

              footer: {
                texto: "© 2023 Desierto Aventura. Todos los derechos reservados.",
                tipografia: "Arial",
                tipografiaColor: "#FFFFFF", // Blanco
                fondoColor: "#264653", // Azul oscuro
                iconosColor: "#E9C46A", // Amarillo arena
                redes: {
                  facebook: "https://facebook.com",
                  twitter: "https://twitter.com",
                  instagram: "https://instagram.com",
                  whatsapp: "https://wa.me"
                },
                datos: {
                  telefono: "+123456789",
                  email: "info@desiertoaventura.com",
                  ubicacion: "Desierto, Chile",
                  direccion: "Calle Desierto 123"
                },
                contacto: {
                  telefono: "+123456789",
                  email: "info@desiertoaventura.com"
                },
                ubicacion: {
                  direccion: "Calle Desierto 123",
                  ciudad: "Desierto",
                  pais: "Chile"
                }
              }
            },

            "002": { // Jungla EcoTours
              idAgencia: "002",
              nombreAgencia: "Jungla EcoTours",
              logoAgencia: "/logo2.png",
              tipografiaAgencia: "Georgia",
              colorTipografiaAgencia: "#2A9D8F", // Verde claro jungla
              colorFondoAgencia: "#264653", // Verde oscuro selva
              colorPrincipalAgencia: null, // 🔥 Null (debe usar el valor por defecto)
              colorSecundarioAgencia: "#E9C46A", // Amarillo sol selva
              colorTerciarioAgencia: "#F4A261", // Marrón hojas secas

              header: {
                imagenBackground: "/jungla.jpg",
                imagenBackgroundOpacidad: 0.8
              },

              buscador: {
                tipografia: "Lora",
                tipografiaColor: "#FFFFFF", // Blanco
                fondoColor: null, // 🔥 Null (debe usar el valor por defecto)
                inputColor: "#E9C46A", // Amarillo sol selva
                calendarioColorPrimario: "#F4A261", // Marrón hojas secas
                calendarioColorSecundario: "#264653", // Verde oscuro selva
                botonBuscarColor: "#E9C46A", // Amarillo sol selva
                tabsColor: "#264653" // Verde oscuro selva
              },

              publicidadCliente: {
                existe: false,
                titulo: "Vive la selva",
                tituloTipografia: "Montserrat",
                tituloTipografiaTamanio: "24px",
                tituloTipografiaColor: "#FFFFFF", // Blanco
                flechasColor: null, // 🔥 Null (debe usar el valor por defecto)
                imagenes: ["/jungla.jpg", "/comarca.jpg", "/montania.jpg"]
              },

              destacadosMes: {
                titulo: "Aventuras en la selva",
                tituloTipografia: "Montserrat",
                tituloTipografiaTamanio: "28px",
                tituloTipografiaColor: "#FFFFFF", // Blanco
                tarjetaTipografia: "Lora",
                tarjetaTipografiaColor: "#2A9D8F", // Verde claro jungla
                tarjetaColorPrimario: "#F4A261", // Marrón hojas secas
                tarjetaColorSecundario: "#E9C46A", // Amarillo sol selva
                tarjetaColorTerciario: null // 🔥 Null (debe usar el valor por defecto)
              },

              bannerRegistro: {
                titulo: "¡Únete a nuestras aventuras!",
                tituloTipografia: "Montserrat",
                tituloTipografiaTamanio: "24px",
                tituloTipografiaColor: "#FFFFFF", // Blanco
                bannerColor: null // 🔥 Null (debe usar el valor por defecto)
              },

              footer: {
                texto: "© 2023 Jungla EcoTours. Todos los derechos reservados.",
                tipografia: "Georgia",
                tipografiaColor: "#FFFFFF", // Blanco
                fondoColor: "#2A9D8F", // Verde claro jungla
                iconosColor: "#F4A261", // Marrón hojas secas
                redes: {
                  facebook: "https://facebook.com",
                  twitter: "https://twitter.com",
                  instagram: "https://instagram.com",
                  whatsapp: "https://wa.me"
                },
                datos: {
                  telefono: "+987654321",
                  email: "info@junglaecotours.com",
                  ubicacion: "Selva, Costa Rica",
                  direccion: "Calle Selva 456"
                },
                contacto: {
                  telefono: "+987654321",
                  email: "info@junglaecotours.com"
                },
                ubicacion: {
                  direccion: "Calle Selva 456",
                  ciudad: "Selva",
                  pais: "Costa Rica"
                }
              }
            },

            "003": { // Glaciar Explorer
              idAgencia: "003",
              nombreAgencia: "Glaciar Explorer",
              logoAgencia: "/logo1.png",
              tipografiaAgencia: "Tahoma",
              colorTipografiaAgencia: "#FFFFFF", // Blanco
              colorFondoAgencia: "#1B263B", // Azul hielo profundo
              colorPrincipalAgencia: "#415A77", // Azul medio glaciar
              colorSecundarioAgencia: "#778DA9", // Azul claro reflejo
              colorTerciarioAgencia: null, // 🔥 Null (debe usar el valor por defecto)

              header: {
                imagenBackground: "/montania.jpg",
                imagenBackgroundOpacidad: 0.25
              },

              buscador: {
                tipografia: "Verdana",
                tipografiaColor: "#FFFFFF", // Blanco
                fondoColor: "#415A77", // Azul medio glaciar
                inputColor: "#778DA9", // Azul claro reflejo
                calendarioColorPrimario: "#E0E1DD", // Blanco nieve
                calendarioColorSecundario: "#1B263B", // Azul hielo profundo
                botonBuscarColor: null, // 🔥 Null (debe usar el valor por defecto)
                tabsColor: "#E0E1DD" // Blanco nieve
              },

              publicidadCliente: {
                existe: true,
                titulo: "Explora los glaciares",
                tituloTipografia: "Trebuchet MS",
                tituloTipografiaTamanio: "24px",
                tituloTipografiaColor: "#FFFFFF", // Blanco
                flechasColor: "#E0E1DD", // Blanco nieve
                imagenes: ["/montania.jpg", "/jungla.jpg", "/desierto.jpg"]
              },

              destacadosMes: {
                titulo: "Aventuras en el hielo",
                tituloTipografia: "Trebuchet MS",
                tituloTipografiaTamanio: "28px",
                tituloTipografiaColor: "#FFFFFF", // Blanco
                tarjetaTipografia: "Verdana",
                tarjetaTipografiaColor: "#1B263B", // Azul hielo profundo
                tarjetaColorPrimario: "#E0E1DD", // Blanco nieve
                tarjetaColorSecundario: "#778DA9", // Azul claro reflejo
                tarjetaColorTerciario: null // 🔥 Null (debe usar el valor por defecto)
              },

              bannerRegistro: {
                titulo: "¡Descubre los glaciares!",
                tituloTipografia: "Trebuchet MS",
                tituloTipografiaTamanio: "24px",
                tituloTipografiaColor: "#FFFFFF", // Blanco
                bannerColor: "#415A77" // Azul medio glaciar
              },

              footer: {
                texto: "© 2023 Glaciar Explorer. Todos los derechos reservados.",
                tipografia: "Tahoma",
                tipografiaColor: "#FFFFFF", // Blanco
                fondoColor: "#1B263B", // Azul hielo profundo
                iconosColor: "#E0E1DD", // Blanco nieve
                redes: {
                  facebook: "https://facebook.com",
                  twitter: "https://twitter.com",
                  instagram: "https://instagram.com",
                  whatsapp: "https://wa.me"
                },
                datos: {
                  telefono: "+1122334455",
                  email: "info@glaciarexplorer.com",
                  ubicacion: "Glaciar, Argentina",
                  direccion: "Calle Glaciar 789"
                },
                contacto: {
                  telefono: "+1122334455",
                  email: "info@glaciarexplorer.com"
                },
                ubicacion: {
                  direccion: "Calle Glaciar 789",
                  ciudad: "Glaciar",
                  pais: "Argentina"
                }
              }
            }
          };

          window.__DATOS_AGENCIA__ = simulaciones[idAgencia] || simulaciones["001"];

          window.dispatchEvent(new Event("cambioSimulacion"));
        }

        // 🔥 Carga la primera simulación por defecto
        cargarSimulacion("001");

        // 🔥 Exponer la función para cambiar la simulación desde React
        window.cambiarSimulacion = cargarSimulacion;
      </script>
</body>
</html>
