<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dev Conecta Card</title>

    {{--  CSS  --}}
    @vite('resources/css/app.css')
    @stack('styles')
</head>
<body>

<main class="relative">
    @yield('content')

    @include('components.alerts', ['bottom' => '4'])
</main>

{{--  JavaScripts  --}}
@vite('resources/js/app.js')
@stack('scripts')
</body>
</html>
