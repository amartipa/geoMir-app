<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/cbe6fa6a2e.js" crossorigin="anonymous"></script>

        <!-- Scripts -->
        @env(['local','development'])
            @vite(['resources/css/app.css', 'resources/js/app.js'])  
        @endenv
        @env(['production'])
            @php
                $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
            @endphp
            <link rel="stylesheet" href="{{ asset('build/'.$manifest['resources/css/app.css']['file']) }}">
            <script type="module" src="{{ asset('build/'.$manifest['resources/js/app.js']['file']) }}"></script>
        @endenv

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @hasSection('header')
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @include('partials.flash')
                @yield('content')
            </main>
        </div>
    </body>
</html>