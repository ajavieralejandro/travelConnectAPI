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
        <div class="absolute flex flex-col w-64 h-full p-4 text-white transition-transform transform -translate-x-full bg-gray-900 md:relative md:h-auto md:flex md:w-64 md:translate-x-0" id="sidebar">
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
                <h2 class="text-xl font-bold">Lista de Agencias</h2>
                <a href="{{ route('agencias.create') }}" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                    + Nueva Agencia
                </a>
            </div>

            <table class="min-w-full overflow-hidden bg-white border border-gray-300 rounded-lg shadow-md">
                <thead class="text-white bg-gray-900">
                    <tr>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Fecha de Alta</th>
                        <th class="px-4 py-2 text-left">Estado</th>
                        <th class="px-4 py-2 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agencias as $agencia)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2">{{ $agencia->nombre }}</td>
                            <td class="px-4 py-2">{{ $agencia->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-white {{ $agencia->estado ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ $agencia->estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 space-x-2 text-center">
                                <a class="text-blue-600 hover:underline">Editar</a>
                                <form method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('¿Estás seguro de eliminar esta agencia?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }
    </script>
</body>
</html>
