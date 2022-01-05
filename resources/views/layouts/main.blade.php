<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title') @yield('title') - @endif{{ config('app.name') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/init-alpine.js') }}"></script>

    @stack('head')
</head>
<body>
<nav class="flex sticky top-0 z-40 flex-none py-3 mx-auto w-full bg-white border-b border-gray-200 dark:border-gray-600 dark:bg-gray-800">
    <div class="flex justify-between items-center px-3 mx-auto w-full max-w-7xl lg:px-4">
        <div class="flex items-center">
            <div class="flex justify-between">
                <a href="{{ route('index') }}" class="flex">
                    <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{ config('app.name') }}</span>
                </a>
            </div>
        </div>
        <div class="flex items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ml-3"><span class="hidden lg:inline">Панель управления</span></a>
        </div>
    </div>
</nav>

<div class="px-4 mx-auto w-full max-w-7xl">
    @yield('content')
</div>

@stack('footer-scripts')


</body>
</html>
