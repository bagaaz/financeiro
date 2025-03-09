<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contas - DevConecta</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('/src/logos/favicon.ico') }}">

    {{--  CSS  --}}
    @vite('resources/css/app.css')
    @stack('styles')
</head>
<body class="max-h-screen flex bg-smoke">
    @include('partials.sidebar')

    <main class="w-full flex flex-col">
        @include('partials.header')

        <div class="relative flex-auto p-4 inset-shadow-[0_0_15px_3px_rgba(0,0,0,0.07)] overflow-auto">
            @yield('content')

            @include('components.alerts', ['bottom' => '16'])
        </div>

        @include('partials.footer')
    </main>


    {{--  JavaScripts  --}}
    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>
