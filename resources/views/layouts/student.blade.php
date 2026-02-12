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

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex bg-gray-100 dark:bg-gray-900">

        {{-- SIDEBAR SISWA --}}
        @include('partials.sidebar-user')

        {{-- KONTEN UTAMA --}}
        <div class="flex-1 flex flex-col min-h-screen">

            {{-- NAVBAR --}}
            @include('partials.navbar')

{{-- HEADER --}}
@hasSection('header')
<header class="bg-slate-800">
    <div class="w-full py-6 px-6">
        <h2 class="font-black text-3xl text-white leading-tight">
            @yield('header')
        </h2>
    </div>
</header>
@endif




            {{-- ISI HALAMAN --}}
            <main class="flex-1 p-6">
                @yield('content')
            </main>

        </div>
    </div>
</body>

</html>
