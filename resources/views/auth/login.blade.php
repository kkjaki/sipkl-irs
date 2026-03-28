<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-8 border border-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-teal-600 tracking-tight">PKL ONLINE</h1>
            <p class="text-gray-500 mt-2 text-sm">Selamat datang kembali! Masukkan kredensial Anda.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" value="Email" class="text-gray-700 font-semibold" />
                <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email Anda" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-5">
                <x-input-label for="password" value="Password" class="text-gray-700 font-semibold" />
                <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="Masukkan password Anda" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mt-5">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-teal-600 hover:text-teal-700 font-medium transition-colors" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
                    Masuk
                </button>
            </div>
            
            @if (Route::has('register'))
            <div class="mt-6 text-center text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-teal-600 hover:text-teal-700 transition-colors">
                    Daftar di sini
                </a>
            </div>
            @endif
        </form>
    </div>
</x-guest-layout>
