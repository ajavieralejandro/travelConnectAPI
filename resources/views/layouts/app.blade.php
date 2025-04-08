<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Registro' }}</title>

    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/css/styles.css', 'resources/js/app.jsx'])
</head>
<body>
    @yield('content')
</body>
</html>
