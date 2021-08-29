<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="auth">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" style="font-size: 30px;" href="{{ url('/') }}">
                    {{ config('app.name', 'Atte') }}
                </a>
            </div>
        </nav>

        <main class="py-4" style="height: max; position: relative; height: 100%;">
            @yield('content')
        </main>
        <footer style="display: flex; justify-content: center; align-items: center; position: absolute; bottom: 0; background-color: white; height: 50px; width: 100%;">
            <a style="text-align: center; font-weight: bolder; font-size: 15px; text-decoration: none; color: black;" href="/">Atte, inc.</a>
        </footer>
    </div>
</body>
</html>
