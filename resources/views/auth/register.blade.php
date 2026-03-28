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
                    <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2" type="text" name="name" :value="old('name')"
                        required autofocus autocomplete="name" placeholder="John Doe" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" value="Email" class="text-gray-700 font-semibold" />
                    <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2" type="email" name="email" :value="old('email')"
                        required autocomplete="username" placeholder="john@example.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- School -->
                <div>
                    <x-input-label for="school_id" value="Asal Sekolah" class="text-gray-700 font-semibold" />
                    <select id="school_id" name="school_id"
                        class="block mt-1 w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2 bg-white"
                        required>
                        <option value="" disabled selected>-- Pilih Sekolah --</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('school_id')" class="mt-2" />
                </div>
                
                <!-- Invitation Code -->
                <div>
                    <x-input-label for="invitation_code" value="Kode Undangan" class="text-gray-700 font-semibold" />
                    <x-text-input id="invitation_code" class="block mt-1 w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2 placeholder-gray-400" type="text" name="invitation_code"
                        :value="old('invitation_code')" required autocomplete="off" placeholder="Contoh: XQ9P2A" />
                    <x-input-error :messages="$errors->get('invitation_code')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="Password" class="text-gray-700 font-semibold"  />
                    <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2" type="password" name="password" required
                        autocomplete="new-password" placeholder="Min. 8 karakter" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-gray-700 font-semibold" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm px-4 py-2" type="password"
                        name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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
