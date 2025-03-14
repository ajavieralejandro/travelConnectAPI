<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="absolute flex flex-col w-64 h-screen p-4 text-white transition-transform transform -translate-x-full bg-gray-900 md:relative md:h-auto md:flex md:w-64 md:translate-x-0" id="sidebar">
            <button class="mb-4 text-white md:hidden" onclick="toggleSidebar()">✖</button>
            <h2 class="mb-6 text-xl font-bold">Admin Panel</h2>
            <nav>
                <ul>
                    <li class="mb-2"><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Agencias</a></li>
                    <li class="mb-2"><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Web Institucional</a></li>
                    <li class="mb-2"><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Clientes</a></li>
                    <li class="mb-2"><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Fuentes de Ingresos</a></li>
                    <li class="mb-2"><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Consulta</a></li>
                    <li class="mb-2"><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Administración</a></li>
                    <li class="mb-2"><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Encuestas</a></li>
                    <li class="mb-2"><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Reportes</a></li>
                    <li class="mb-2"><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Soporte</a></li>
                </ul>
            </nav>
        </div>

        <!-- Contenido principal -->
        <div class="flex-1 p-10 ">
            <button class="mb-4 md:hidden" onclick="toggleSidebar()">☰</button>
            <div class="flex items-center justify-between mb-4">
                @yield('content')


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }
    </script>
</body>
</html>
