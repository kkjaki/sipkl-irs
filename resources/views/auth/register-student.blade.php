<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Student Fields -->
        <div id="studentFields">

            <!-- Kode Undangan -->
            <div class="mt-4">
                <x-input-label for="invite_code" value="Kode Undangan" />
                <x-text-input id="invite_code"
                    class="block mt-1 w-full"
                    type="text"
                    name="invite_code" />
            </div>

            <!-- Nama Lengkap -->
            <div class="mt-4">
                <x-input-label for="name" value="Nama Lengkap" />
                <x-text-input id="name"
                    class="block mt-1 w-full"
                    type="text"
                    name="name"
                    :value="old('name')" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" value="Email" />
                <x-text-input id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    :value="old('email')" />
            </div>

        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Kata Sandi" />
            <x-text-input id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />
            <x-text-input id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required />
        </div>
        <!-- Asal Sekolah -->
        <div class="mt-4">
            <x-input-label for="school" value="Asal Sekolah" />
            <select id="school" name="school"
                class="block mt-1 w-full rounded-md border-gray-300">
                <option value="">Pilih Asal Sekolah Anda</option>
            </select>
        </div>


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600"
               href="{{ route('student.login') }}">
                Sudah punya akun?
            </a>

            <x-primary-button class="ms-4">
                Daftar
            </x-primary-button>
        </div>
    </form>

    <!-- Script tampilkan field student -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const roleSelect = document.getElementById("role");
            const studentFields = document.getElementById("studentFields");

            function toggleStudentFields() {
                if (roleSelect.value === "student") {
                    studentFields.style.display = "block";
                } else {
                    studentFields.style.display = "none";
                }
            }

            toggleStudentFields();
            roleSelect.addEventListener("change", toggleStudentFields);
        });
    </script>

</x-guest-layout>
