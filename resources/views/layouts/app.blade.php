<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.cdnfonts.com/css/sf-pro-display"
        rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: true }"
        class="min-h-screen flex bg-[#F4F6F9]">

        {{-- Sidebar (role-based) --}}
        @if(auth()->user()->role === 'student')
            @include('partials.sidebar-student')
        @else
            @include('partials.sidebar-industry')
        @endif

        {{-- Konten utama (navbar + isi halaman) --}}
        <div :class="sidebarOpen ? 'ml-64' : 'ml-16'"
            class="flex-1 min-h-screen transition-all duration-300">
            {{-- Navbar --}}
            @include('partials.navbar')

            {{-- Header jika ada --}}
            @isset($header)
            <header class="bg-transparent">
                <div class="py-6 px-8">
                    {{ $header }}
                </div>
            </header>
            @endisset

            {{-- Konten halaman --}}
            <main class="flex-1">
                {{ $slot ?? '' }}
                @yield('content')
            </main>

        </div>
    </div>
    @stack('scripts')
</body>

</html>