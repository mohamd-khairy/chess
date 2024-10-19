<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <style>
        .yellow {
            border: 2px solid yellow;
        }
        .player1-name,
        .player2-name {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
            text-transform: uppercase;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Styles for the active player */
        .active-player {
            background-color: #4CAF50;
            /* Highlight background for active player */
            color: white;
            /* White text for better contrast */
        }

        .piece-icon {
            width: 40px;
            margin-bottom: 25px
        }

        /* public/css/chessboard.css */
        .chessboard-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .chessboard {
            display: grid;
            grid-template-columns: repeat(8, 80px);
            grid-template-rows: repeat(8, 80px);
            border: 2px solid black;
        }

        .square {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .square.white {
            background-color: #f0d9b5;
        }

        .square.black {
            background-color: #b58863;
        }

        .square.selected {
            border: 2px solid red;
        }

        .selected-text {
            font-size: 12px;
            color: red;
        }

        .new-game-container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @livewireStyles

</head>

<body>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item pr-4 nav-link">
                                {{ Auth::user()->name }}
                            </li>

                            <li class="nav-item">
                                <a  class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">

            {{ $slot ?? '' }}

            @yield('content')
        </main>
    </div>

    @livewireScripts
</body>

</html>
