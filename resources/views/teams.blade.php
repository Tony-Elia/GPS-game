<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: url('storage/images/bg.jpg') center center / cover no-repeat;
            opacity: 0.1;
            z-index: -1; /* behind everything */
        }
        /* Dots animation */
        @keyframes blink {
            0%, 80%, 100% { opacity: 0; }
            40% { opacity: 1; }
        }
        .dot {
            animation: blink 1.5s infinite;
        }
        .dot:nth-child(2) {
            animation-delay: 0.2s;
        }
        .dot:nth-child(3)   {
            animation-delay: 0.3s;
        }
    </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex flex-col min-h-screen">

<!-- Main Section -->
<main class="flex-1 flex items-center justify-center text-center px-4">
    @if (isset($game))
        <div class="flex flex-col items-center gap-4">
            <!-- Always show game name -->
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold dark:text-[#EDEDEC]">
                {{ $game->name }}
            </h1>

            <!-- Show image only if available -->
            @if (!empty($game->image_url))
                <img src="{{ $game->image_url }}" alt="{{ $game->name }}"
                     class="max-h-[70vh] max-w-full object-contain">
            @endif
    @elseif (isset($message))
        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-bold dark:text-[#EDEDEC]">
            {{ $message }}
        </h1>
    @else
        <div class="flex items-center justify-center gap-2">
            <h1 class="text-6xl sm:text-8xl lg:text-9xl font-extrabold dark:text-[#EDEDEC] flex">
                GPS
                <span class="dot">.</span>
                <span class="dot">.</span>
                <span class="dot">.</span>
            </h1>
            <!-- Pinned location icon -->
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-12 h-12 sm:w-16 sm:h-16 text-red-500 ml-2"
                 fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0
                             9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12
                             6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
            </svg>
        </div>
    @endif
</main>

<!-- Inline Form at Bottom -->
<footer class="w-full p-4 bg-white dark:bg-[#161615] border-t border-gray-200 dark:border-[#3E3E3A]">
    <form action="{{ route('apply') }}" method="POST" class="flex items-center gap-2">
        @csrf
        <input type="text" name="code"
               placeholder="دخل كود اللعبة..."
               required
               class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
        <x-input-error :messages="$errors->all()" class="mt-2 text-red-500" />
        <button type="submit"
                class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            سجل الكود
        </button>
    </form>
</footer>
</body>
</html>
