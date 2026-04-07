<x-guest-layout title="Register">

<div class="min-h-screen flex bg-gray-200">

    <!-- LEFT IMAGE -->
    <div class="w-1/2 flex items-center justify-center bg-gray-300">
        <img src="{{ asset('images/login-illustration.png') }}" 
             class="w-3/4"
             alt="register image">
    </div>


    <!-- RIGHT FORM -->
    <div class="w-1/2 flex items-center justify-center">

        <div class="w-96 flex flex-col items-center text-center">

            <!-- TITLE -->
            <p class="text-gray-500">Selamat Datang di</p>
            <h1 class="text-3xl font-bold mb-6">PKL-ONLINE</h1>


            <!-- TAB -->
            <div class="flex bg-teal-100 rounded-full p-1 mb-8 w-64">

                <button id="loginTab"
                    class="flex-1 text-gray-500 text-sm">
                    Masuk
                </button>

                <button
                    class="flex-1 bg-teal-400 text-white rounded-full py-1 text-sm">
                    Daftar
                </button>

            </div>


            <!-- FORM -->
            <form id="registerForm" method="POST" action="{{ route('student.register') }}" class="w-full">
            @csrf


            <!-- KODE UNDANGAN -->
            <div class="mb-3 text-left">
                <label class="text-sm text-gray-600">Kode Undangan</label>

                <input id="invite" type="text" name="invite"
                    class="w-full border rounded-lg px-3 py-2 mt-1">

                <p id="inviteError" class="text-red-500 text-sm hidden mt-1">
                    Kode undangan wajib diisi
                </p>
            </div>


            <!-- NAMA -->
            <div class="mb-3 text-left">
                <label class="text-sm text-gray-600">Nama Lengkap</label>

                <input id="name" type="text" name="name"
                    class="w-full border rounded-lg px-3 py-2 mt-1">

                <p id="nameError" class="text-red-500 text-sm hidden mt-1">
                    Nama lengkap wajib diisi
                </p>
            </div>


            <!-- EMAIL -->
            <div class="mb-3 text-left">
                <label class="text-sm text-gray-600">Email</label>

                <input id="email" type="email" name="email"
                    class="w-full border rounded-lg px-3 py-2 mt-1">

                <p id="emailError" class="text-red-500 text-sm hidden mt-1">
                    Email tidak valid
                </p>
            </div>


            <!-- SEKOLAH -->
            <div class="mb-3 text-left">
                <label class="text-sm text-gray-600">Asal Sekolah</label>

                <select id="school" name="school"
                    class="w-full border rounded-lg px-3 py-2 mt-1">

                    <option value="">Pilih Asal Sekolah Anda</option>
                    <option>SMK 1</option>
                    <option>SMK 2</option>

                </select>

                <p id="schoolError" class="text-red-500 text-sm hidden mt-1">
                    Pilih asal sekolah
                </p>
            </div>


            <!-- PASSWORD -->
            <div class="mb-3 text-left">
                <label class="text-sm text-gray-600">Kata Sandi</label>

                <input id="password" type="password" name="password"
                    class="w-full border rounded-lg px-3 py-2 mt-1">

                <p id="passwordError" class="text-red-500 text-sm hidden mt-1">
                    Password minimal 6 karakter
                </p>
            </div>


            <!-- KONFIRMASI PASSWORD -->
            <div class="mb-5 text-left">
                <label class="text-sm text-gray-600">Konfirmasi Kata Sandi</label>

                <input id="password_confirmation" type="password"
                    name="password_confirmation"
                    class="w-full border rounded-lg px-3 py-2 mt-1">

                <p id="confirmError" class="text-red-500 text-sm hidden mt-1">
                    Password tidak sama
                </p>
            </div>


            <!-- BUTTON -->
            <div class="w-full flex justify-end">

                <button
                    class="bg-teal-400 hover:bg-teal-500 text-white px-10 py-2 rounded-full transition">
                    Daftar
                </button>

            </div>

            </form>

        </div>

    </div>

</div>


<script>

document.addEventListener("DOMContentLoaded", function(){

    const form = document.getElementById("registerForm");

    const invite = document.getElementById("invite");
    const name = document.getElementById("name");
    const email = document.getElementById("email");
    const school = document.getElementById("school");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("password_confirmation");

    const inviteError = document.getElementById("inviteError");
    const nameError = document.getElementById("nameError");
    const emailError = document.getElementById("emailError");
    const schoolError = document.getElementById("schoolError");
    const passwordError = document.getElementById("passwordError");
    const confirmError = document.getElementById("confirmError");

    const loginTab = document.getElementById("loginTab");


    // VALIDASI FORM REGISTER
    if(form){
        form.addEventListener("submit", function(e){

            let valid = true;


            // INVITE
            if(invite && invite.value.trim() === ""){
                inviteError.classList.remove("hidden");
                invite.focus();
                valid = false;
            } else {
                inviteError.classList.add("hidden");
            }


            // NAME
            if(name && name.value.trim() === ""){
                nameError.classList.remove("hidden");

                if(valid){
                    name.focus();
                }

                valid = false;

            } else {
                nameError.classList.add("hidden");
            }


            // EMAIL
            if(email){

                if(email.value.trim() === ""){
                    emailError.textContent = "Email wajib diisi";
                    emailError.classList.remove("hidden");

                    if(valid){
                        email.focus();
                    }

                    valid = false;

                }
                else if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)){
                    emailError.textContent = "Format email tidak valid";
                    emailError.classList.remove("hidden");

                    if(valid){
                        email.focus();
                    }

                    valid = false;

                }
                else{
                    emailError.classList.add("hidden");
                }

            }


            // SCHOOL
            if(school && school.value === ""){
                schoolError.classList.remove("hidden");

                if(valid){
                    school.focus();
                }

                valid = false;

            } else {
                schoolError.classList.add("hidden");
            }


            // PASSWORD
            if(password && password.value.length < 6){
                passwordError.classList.remove("hidden");

                if(valid){
                    password.focus();
                }

                valid = false;

            } else {
                passwordError.classList.add("hidden");
            }


            // CONFIRM PASSWORD
            if(confirmPassword && confirmPassword.value !== password.value){
                confirmError.classList.remove("hidden");

                if(valid){
                    confirmPassword.focus();
                }

                valid = false;

            } else {
                confirmError.classList.add("hidden");
            }


            if(!valid){
                e.preventDefault();
            }

        });
    }


    // HILANGKAN ERROR SAAT MENGETIK
    document.querySelectorAll("input, select").forEach(el=>{
        el.addEventListener("input",()=>{
            const err = document.getElementById(el.id + "Error");
            if(err){
                err.classList.add("hidden");
            }
        });
    });


    // TAB LOGIN
    if(loginTab){
        loginTab.addEventListener("click", function(){
            window.location.href = "{{ route('student.login') }}";
        });
    }

});

</script>

</x-guest-layout>