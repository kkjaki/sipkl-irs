<x-guest-layout>

<div class="min-h-screen flex bg-gray-200">

    <!-- LEFT IMAGE -->
    <div class="w-1/2 flex items-center justify-center bg-gray-300">
        <img src="{{ asset('images/login-illustration.png') }}" 
             class="w-3/4"
             alt="forgot password image">
    </div>


    <!-- RIGHT FORM -->
    <div class="w-1/2 flex items-center justify-center">

        <div class="w-96 flex flex-col items-center text-center">

            <!-- TITLE -->
            <p class="text-gray-500">Lupa Kata Sandi</p>
            <h1 class="text-3xl font-bold mb-8">PKL-ONLINE</h1>


            <!-- SESSION STATUS -->
            <x-auth-session-status class="mb-4" :status="session('status')" />


            <!-- FORM -->
            <form id="forgotForm" method="POST" action="{{ route('password.email') }}" class="w-full">
            @csrf


            <!-- EMAIL -->
            <div class="mb-4 text-left">

                <label class="text-sm text-gray-600">Email</label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    placeholder="example@gmail.com"
                    class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-teal-300">

                <p id="emailError" class="text-red-500 text-sm hidden mt-1">
                    Email wajib diisi
                </p>

            </div>


            <!-- BUTTON -->
            <div class="w-full flex justify-end">

                <button
                    class="bg-teal-400 hover:bg-teal-500 text-white px-10 py-2 rounded-full transition">
                    Kirim
                </button>

            </div>

            </form>

        </div>

    </div>

</div>


<script>

const form = document.getElementById("forgotForm");
const email = document.getElementById("email");
const emailError = document.getElementById("emailError");


// VALIDASI SUBMIT
form.addEventListener("submit", function(e){

    let valid = true;

    if(email.value.trim() === ""){

        emailError.textContent = "Email wajib diisi";
        emailError.classList.remove("hidden");
        email.focus();

        valid = false;

    }
    else if(!email.value.includes("@")){

        emailError.textContent = "Format email tidak valid";
        emailError.classList.remove("hidden");
        email.focus();

        valid = false;

    }
    else{

        emailError.classList.add("hidden");

    }

    if(!valid){
        e.preventDefault();
    }

});


// HAPUS ERROR SAAT MENGETIK
email.addEventListener("input", function(){
    emailError.classList.add("hidden");
});

</script>

</x-guest-layout>