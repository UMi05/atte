<!doctype html>
<html style="height: 100%;" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Atte') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/attendance.css') }}" rel="stylesheet">
    <link href="{{ asset('css/check.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body style="display: flex; flex-direction: column; height: 100%;">
    <header>
        <a class="logo" href="{{ route('home') }}">
            {{ config('app.name', 'Atte') }}
        </a>
        <nav class="nav" id="nav">
            <ul>
                <li>
                    <a href="{{ route('home') }}">
                        ホーム
                    </a>
                </li>

                <li class="ml-5">
                    <a href="{{ route('attendance') }}">
                        日付一覧
                    </a>
                </li>

                <li class="ml-5">
                    <a href="{{ route('mypage') }}">
                        マイページ
                    </a>
                </li>

                <li class="ml-5">
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <div class="menu" id="menu">
            <span class="line topbar"></span>
            <span class="line middlebar"></span>
            <span class="line bottombar"></span>
        </div>
        <nav class="drawer-nav" id="drawer-nav">
            <ul>
                <li>
                    <a href="{{ route('home') }}">
                        ホーム
                    </a>
                </li>

                <li>
                    <a href="{{ route('attendance') }}">
                        日付一覧
                    </a>
                </li>

                <li>
                    <a href="{{ route('mypage') }}">
                        マイページ
                    </a>
                </li>

                <li>
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <main class="py-5" style="flex: 1; height: 100%;">
        @yield('content')
    </main>
    <footer style="display: flex; justify-content: center; align-items: center; background-color: white; height: 50px; width: 100%;">
        <a style="text-align: center; font-weight: bolder; font-size: 15px; text-decoration: none; color: black;" href="/">Atte, inc.</a>
    </footer>
</body>
</html>
