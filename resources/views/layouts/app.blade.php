<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Wisuda')</title>

    <!-- Vite CSS -->
    @vite('resources/css/app.css')

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-gray-50">
    @yield('content')
    @stack('scripts')
</body>
</html>
