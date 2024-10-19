{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
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
    {{-- Vite CSS (if using Vite) --}}
    @vite('resources/css/app.css')

    {{-- Livewire Styles --}}
    @livewireStyles
</head>

<body class="antialiased">
    <div id="app">
        {{-- Navbar can go here if needed --}}

        {{-- Main Content Section --}}
        <main class="py-4">

            {{ $slot ?? '' }}

            @yield('content')

        </main>
    </div>

    {{-- Vite JS (if using Vite) --}}
    @vite('resources/js/app.js')

    {{-- Livewire Scripts --}}
    @livewireScripts
</body>

</html>
