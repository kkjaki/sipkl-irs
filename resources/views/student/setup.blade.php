<x-app-layout>
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <!-- THE NUDGE (Onboarding Alert) -->
        @if (session('onboarding_nudge'))
            <div class="mb-6 bg-teal-50 border border-teal-200 rounded-xl p-4 flex items-start shadow-sm" role="alert">
                <x-heroicon-o-information-circle class="w-6 h-6 text-teal-600 mt-0.5 shrink-0 mr-3" />
                <div>
                    <h3 class="text-sm font-semibold text-teal-800">Waduh, kamu belum melengkapi data diri nih!</h3>
                    <p class="text-sm text-teal-700 mt-1">
                        Ayo isi dulu datamu di bawah ini biar bisa lanjut ke aktivitas presensi dan logbook PKL.
                    </p>
                </div>
            </div>
        @endif

        <!-- Card Container -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <x-heroicon-s-identification class="w-6 h-6 text-teal-100" />
                    Lengkapi Profil Siswa
                </h2>
                <p class="text-teal-100 text-sm mt-1">Silakan lengkapi data diri Anda sebagai KTP Siswa Magang.</p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 m-6 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <x-heroicon-s-x-circle class="h-5 w-5 text-red-500" />
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} kesalahan formulir:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('student.setup.store') }}" method="POST" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Kode Undangan (Read-only) -->
                    <div class="md:col-span-1 flex items-center">
                        <x-input-label for="invitation_code" value="Kode Undangan (Industry)" class="font-bold text-gray-700" />
                    </div>
                    <div class="md:col-span-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-heroicon-s-key class="h-5 w-5 text-gray-400" />
                            </div>
                            <x-text-input 
                                id="invitation_code" 
                                type="text" 
                                class="pl-10 block w-full bg-gray-100 text-gray-500 border-gray-300 cursor-not-allowed focus:ring-0" 
                                value="{{ $invitationCode ?? 'Tidak Ada' }}" 
                                disabled 
                                readonly 
                            />
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Ini adalah kode rujukan tempat PKL / industri Anda saat ini.</p>
                    </div>

                    <div class="col-span-1 md:col-span-3 border-b border-gray-100 my-2"></div>

                    <!-- NIS -->
                    <div class="md:col-span-1 flex items-center">
                        <x-input-label for="nis" value="Nomor Induk Siswa (wajib)" class="font-bold text-gray-700" />
                    </div>
                    <div class="md:col-span-2">
                        <x-text-input 
                            id="nis" 
                            name="nis" 
                            type="text" 
                            class="block w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm" 
                            :value="old('nis', $user->student->nis ?? '')" 
                            required 
                            autofocus 
                            placeholder="Contoh: 123456789"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('nis')" />
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="md:col-span-1 flex items-center">
                        <x-input-label for="name" value="Nama Lengkap (wajib)" class="font-bold text-gray-700" />
                    </div>
                    <div class="md:col-span-2">
                        <x-text-input 
                            id="name" 
                            name="name" 
                            type="text" 
                            class="block w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm" 
                            :value="old('name', $user->name)" 
                            required 
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Kelas -->
                    <div class="md:col-span-1 flex items-center">
                        <x-input-label for="class" value="Kelas (wajib)" class="font-bold text-gray-700" />
                    </div>
                    <div class="md:col-span-2">
                        <x-text-input 
                            id="class" 
                            name="class" 
                            type="text" 
                            class="block w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm" 
                            :value="old('class', $user->student->class ?? '')" 
                            required 
                            placeholder="Contoh: XII RPL 1"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('class')" />
                    </div>

                    <!-- Nomor HP -->
                    <div class="md:col-span-1 flex items-center">
                        <x-input-label for="phone" value="No. WhatsApp / HP (wajib)" class="font-bold text-gray-700" />
                    </div>
                    <div class="md:col-span-2">
                        <x-text-input 
                            id="phone" 
                            name="phone" 
                            type="text" 
                            class="block w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm" 
                            :value="old('phone', $user->student->phone ?? '')" 
                            required 
                            placeholder="Contoh: 081234567890"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="md:col-span-1 flex items-start mt-2">
                        <x-input-label for="address" value="Alamat Domisili (wajib)" class="font-bold text-gray-700" />
                    </div>
                    <div class="md:col-span-2">
                        <textarea 
                            id="address" 
                            name="address" 
                            rows="3" 
                            class="block w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm resize-none" 
                            required 
                            placeholder="Alamat rumah atau tempat singgah PKL saat ini..."
                        >{{ old('address', $user->student->address ?? '') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                    </div>

                    <!-- Hobby / Talenta -->
                    <div class="md:col-span-1 flex items-center mt-2">
                        <div class="flex flex-col">
                            <x-input-label for="hobby" value="Hobi / Talenta (opsional)" class="font-bold text-gray-700" />
                            <span class="text-xs text-gray-500">Membantu mentor mengenali potensi Anda</span>
                        </div>
                    </div>
                    <div class="md:col-span-2 mt-2 md:mt-0">
                        <x-text-input 
                            id="hobby" 
                            name="hobby" 
                            type="text" 
                            class="block w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm" 
                            :value="old('hobby', $user->student->hobby ?? '')" 
                            placeholder="Contoh: Desain Grafis, Main Musik, Coding HTML"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('hobby')" />
                    </div>

                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-teal-600 border border-transparent rounded-lg font-semibold text-white tracking-widest hover:bg-teal-700 active:bg-teal-800 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                        <x-heroicon-s-check-circle class="w-5 h-5 mr-2" />
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
