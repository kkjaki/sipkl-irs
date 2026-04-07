<x-guest-layout title="Login">
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
                <x-text-input
                    id="email"
                    class="block mt-1 w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2 {{ $errors->has('email') ? 'border-red-500' : '' }}"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Masukkan email Anda"
                />
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-5" x-data="{ show: false }">
                <x-input-label for="password" value="Password" class="text-gray-700 font-semibold" />
                <div class="relative mt-1">
                    <input
                        id="password"
                        :type="show ? 'text' : 'password'"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Masukkan password Anda"
                        class="block w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2 pr-10 {{ $errors->has('password') ? 'border-red-500' : '' }}"
                    >
                    <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none"
                        tabindex="-1">
                        <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
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
