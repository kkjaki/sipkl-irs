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

<body class="bg-[#EFF3FD]">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('partials.sidebar-user')

    {{-- MAIN CONTENT --}}
    <div id="mainContent" class="flex-1 flex flex-col transition-all duration-300">

        {{-- NAVBAR --}}
        @include('partials.navbar')

        {{-- HEADER --}}
        <header class="bg-[#EFF3FD] text-gray-800 px-6 py-4">
            <h2 class="text-4xl font-extrabold">
                @yield('header')
            </h2>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-6 bg-[#EFF3FD]">
            @yield('content')
        </main>

    </div>

</div>


{{-- SCRIPT SIDEBAR TOGGLE --}}
<script>

let sidebarOpen = true;

function toggleSidebar(){

    const sidebar = document.getElementById('sidebar');

    if(!sidebar) return;

    if(sidebarOpen){

        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-0');

        sidebarOpen = false;

    }else{

        sidebar.classList.remove('w-0');
        sidebar.classList.add('w-64');

        sidebarOpen = true;

    }

}

</script>

</body>
</html>