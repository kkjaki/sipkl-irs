<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-8 border border-gray-100">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-black text-teal-600 tracking-tight">PKL ONLINE</h1>
            <p class="text-gray-500 mt-2 text-sm">Lupa password Anda? Tidak masalah. Masukkan email Anda dan kami akan mengirimkan tautan reset password.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-center font-medium text-teal-600" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" value="Email" class="text-gray-700 font-semibold" />
                <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2" type="email" name="email" :value="old('email')" required autofocus placeholder="Masukkan email terdaftar" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-8 flex flex-col gap-4">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
                    Kirim Tautan Reset
                </button>
                
                <a href="{{ route('login') }}" class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>