<x-guest-layout title="Login">

<div class="min-h-screen flex bg-gray-200">

    <!-- LEFT IMAGE -->
    <div class="hidden md:flex w-1/2 items-center justify-center bg-gray-300">
        <img src="{{ asset('images/login-illustration.png') }}" 
             class="w-3/4"
             alt="login image">
    </div>


    <!-- RIGHT FORM -->
    <div class="w-full md:w-1/2 flex items-center justify-center px-6">

        <div class="max-w-md w-full flex flex-col items-center">

            <!-- TITLE -->
            <p class="text-gray-500 text-center">
                Selamat Datang di
            </p>

            <h1 class="text-3xl font-bold mb-6 text-center">
                PKL-ONLINE
            </h1>


            <!-- TAB -->
            <div class="flex bg-teal-100 rounded-full p-1 mb-8 w-64">
                <button id="loginTab"
                    class="flex-1 bg-teal-400 text-white rounded-full py-1 text-sm">
                    Masuk
                </button>

                <button id="registerTab"
                    class="flex-1 text-gray-500 text-sm">
                    Daftar
                </button>
            </div>


            <x-auth-session-status class="mb-4 w-full" :status="session('status')" />


            <form id="loginForm" method="POST" action="{{ route('student.login') }}" class="w-full">
                @csrf


                <!-- EMAIL -->
                <div class="mb-4 w-full text-left">

                    <label class="text-sm text-gray-600 block">
                        Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        placeholder="example@gmail.com"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-teal-300">

                    <p id="emailError" class="text-red-500 text-sm hidden mt-1">
                        Email wajib diisi
                    </p>

                </div>


                <!-- PASSWORD -->
                <div class="mb-2 w-full text-left">

                    <label class="text-sm text-gray-600 block">
                        Kata Sandi
                    </label>

                    <div class="relative">

                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="********"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-teal-300">

                        <button type="button"
                            onclick="togglePassword()"
                            class="absolute right-3 top-3 text-gray-400">

                            <i id="eyeIcon" class="fa fa-eye"></i>

                        </button>

                    </div>

                    <p id="passwordError" class="text-red-500 text-sm hidden mt-1">
                        Password wajib diisi
                    </p>

                </div>


                <!-- FORGOT -->
                <div class="text-right mb-4 w-full">

                    <a href="{{ route('password.request') }}"
                        class="text-sm text-gray-500 hover:underline">
                        Lupa kata sandi?
                    </a>

                </div>


                <!-- BUTTON -->
                <button
                    class="w-full bg-teal-400 hover:bg-teal-500 text-white py-2 rounded-full transition">
                    Masuk
                </button>

            </form>

        </div>

    </div>

</div>


<!-- FRONTEND LOGIC -->
<script>

document.addEventListener("DOMContentLoaded", function(){

    const form = document.getElementById("loginForm");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");

    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    const registerTab = document.getElementById("registerTab");
    const loginTab = document.getElementById("loginTab");


    // VALIDASI FORM LOGIN
    if(form){
        form.addEventListener("submit", function(e){

            let email = emailInput.value.trim();
            let password = passwordInput.value.trim();

            let valid = true;

            // VALIDASI EMAIL
            if(email === ""){
                emailError.textContent = "Email wajib diisi";
                emailError.classList.remove("hidden");
                emailInput.focus();
                valid = false;
            }
            else if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)){
                emailError.textContent = "Format email tidak valid";
                emailError.classList.remove("hidden");
                emailInput.focus();
                valid = false;
            }
            else{
                emailError.classList.add("hidden");
            }


            // VALIDASI PASSWORD
            if(password === ""){
                passwordError.textContent = "Password wajib diisi";
                passwordError.classList.remove("hidden");

                if(valid){
                    passwordInput.focus();
                }

                valid = false;
            }
            else{
                passwordError.classList.add("hidden");
            }


            if(!valid){
                e.preventDefault();
            }

        });
    }


    // HAPUS ERROR SAAT MENGETIK
    if(emailInput){
        emailInput.addEventListener("input", function(){
            emailError.classList.add("hidden");
        });
    }

    if(passwordInput){
        passwordInput.addEventListener("input", function(){
            passwordError.classList.add("hidden");
        });
    }


    // SHOW / HIDE PASSWORD
    window.togglePassword = function(){

        const icon = document.getElementById("eyeIcon");

        if(passwordInput.type === "password"){
            passwordInput.type = "text";
            icon.classList.replace("fa-eye","fa-eye-slash");
        }else{
            passwordInput.type = "password";
            icon.classList.replace("fa-eye-slash","fa-eye");
        }

    };


    // TAB LOGIN
    if(loginTab){
        loginTab.addEventListener("click", function(){
            window.location.href = "{{ route('student.login') }}";
        });
    }

    // TAB REGISTER
    if(registerTab){
        registerTab.addEventListener("click", function(){
            window.location.href = "{{ route('student.register') }}";
        });
    }

});

</script>

</x-guest-layout>