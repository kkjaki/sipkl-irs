<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-8 border border-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-teal-600 tracking-tight">PKL ONLINE</h1>
            <p class="text-gray-500 mt-2 text-sm">Daftar Akun Baru. Kelola magang jadi lebih mudah.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Name -->
                <div>
                    <x-input-label for="name" value="Nama Lengkap" class="text-gray-700 font-semibold" />
                    <x-text-input
                        id="name"
                        class="block mt-1 w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2 {{ $errors->has('name') ? 'border-red-500' : '' }}"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="John Doe"
                    />
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
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
                        autocomplete="username"
                        placeholder="john@example.com"
                    />
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- School -->
                <div>
                    <x-input-label for="school_id" value="Asal Sekolah" class="text-gray-700 font-semibold" />
                    <select id="school_id" name="school_id"
                        class="block mt-1 w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2 bg-white {{ $errors->has('school_id') ? 'border-red-500' : '' }}"
                        required>
                        <option value="" disabled {{ old('school_id') ? '' : 'selected' }}>-- Pilih Sekolah --</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('school_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Invitation Code -->
                <div>
                    <x-input-label for="invitation_code" value="Kode Undangan" class="text-gray-700 font-semibold" />
                    <x-text-input
                        id="invitation_code"
                        class="block mt-1 w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2 placeholder-gray-400 {{ $errors->has('invitation_code') ? 'border-red-500' : '' }}"
                        type="text"
                        name="invitation_code"
                        :value="old('invitation_code')"
                        required
                        autocomplete="off"
                        placeholder="Contoh: XQ9P2A"
                    />
                    @error('invitation_code')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div x-data="{ show: false }">
                    <x-input-label for="password" value="Password" class="text-gray-700 font-semibold" />
                    <div class="relative mt-1">
                        <input
                            id="password"
                            :type="show ? 'text' : 'password'"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Min. 8 karakter"
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

                <!-- Confirm Password -->
                <div x-data="{ show: false }">
                    <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-gray-700 font-semibold" />
                    <div class="relative mt-1">
                        <input
                            id="password_confirmation"
                            :type="show ? 'text' : 'password'"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Ulangi password"
                            class="block w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2 pr-10 {{ $errors->has('password_confirmation') ? 'border-red-500' : '' }}"
                        >
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none"
                            tabindex="-1">
                            <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
                    Daftar Sekarang
                </button>
            </div>
            
            <div class="mt-6 text-center text-sm text-gray-600">
                Sudah punya akun? 
                <a class="font-bold text-teal-600 hover:text-teal-700 transition-colors" href="{{ route('login') }}">
                    Masuk di sini
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
