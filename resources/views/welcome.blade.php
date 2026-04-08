<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi PKL Online</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon2.png') }}">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="antialiased bg-slate-50 text-gray-800 font-sans selection:bg-teal-500 selection:text-white flex flex-col min-h-screen">

    <!-- Navbar Minimalis -->
    <nav class="w-full bg-white bg-opacity-90 backdrop-blur-md border-b border-gray-100 z-50 fixed top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <!-- Custom Icon Logo -->
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-teal-400 to-teal-600 rounded-lg flex items-center justify-center text-white font-bold text-xl cursor-pointer">
                        P
                    </div>
                    <span class="font-black text-xl tracking-tight text-gray-900 cursor-pointer">PKL ONLINE</span>
                </div>

                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="text-sm font-semibold text-gray-600 hover:text-teal-600 transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-sm font-semibold text-gray-600 hover:text-teal-600 transition-colors">
                                Masuk
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="text-sm font-semibold bg-teal-50 text-teal-600 hover:bg-teal-100 px-4 py-2 rounded-lg transition-all border border-teal-100">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-grow flex items-center justify-center pt-24 pb-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Decoration (Subtle Blobs) -->
        <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full overflow-hidden -z-10 pointer-events-none">
            <div
                class="absolute -top-[10%] -right-[10%] w-[500px] h-[500px] rounded-full bg-teal-100/50 blur-3xl opacity-70">
            </div>
            <div
                class="absolute top-[20%] -left-[10%] w-[400px] h-[400px] rounded-full bg-blue-100/50 blur-3xl opacity-60">
            </div>
        </div>

        <div class="text-center max-w-3xl mx-auto mt-10">
            {{-- Badge / Chips --}}
            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 border border-teal-100 text-teal-700 text-sm font-medium mb-8 shadow-sm">
                <span class="flex w-2 h-2 rounded-full bg-teal-500"></span>
                Generasi Baru Pengelolaan Magang
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 tracking-tight leading-tight mb-6">
                Sistem Informasi <br />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-500 to-teal-700">PKL Online</span>
            </h1>

            <p class="mt-4 text-lg sm:text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                Kelola presensi harian, isi logbook kegiatan, hingga sistem penilaian magang industri dengan mudah dan
                terintegrasi dari satu dasbor yang pintar.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold text-white bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 shadow-lg shadow-teal-500/30 transition-transform transform hover:-translate-y-0.5">
                        Menuju Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold text-white bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 shadow-lg shadow-teal-500/30 transition-transform transform hover:-translate-y-0.5">
                        Masuk Sekarang
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 hover:border-gray-300 shadow-sm transition-all text-center">
                            Daftar Akun
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </main>

    <!-- Footer Minimalis -->
    <footer class="w-full py-6 text-center z-10 relative">
        <p class="text-sm text-gray-400">
            &copy; {{ date('Y') }} PKL ONLINE. Semua hak cipta dilindungi.
        </p>
    </footer>
</body>

</html>
