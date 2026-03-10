@extends('layouts.student')

@section('header')
Logbook Harian
@endsection

@section('content')

<div class="max-w-6xl">

    {{-- CARD --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">

        {{-- HEADER CARD --}}
        <div class="bg-teal-400 text-white px-6 py-3 font-semibold">
            Logbook Harian
        </div>

        {{-- BODY --}}
        <div class="p-6">

            <form id="logbookForm"
                action="{{ route('student.logbook.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6">

                @csrf


                {{-- TANGGAL --}}
                <div class="flex items-center gap-6">

                    <label class="w-40 text-gray-700">
                        Hari, Tanggal
                    </label>

                    <input
                        type="text"
                        value="{{ now()->translatedFormat('l, d-m-Y') }}"
                        readonly
                        class="w-56 border border-gray-300 rounded px-3 py-2 bg-gray-100 text-gray-700"
                    >

                </div>


                {{-- DESKRIPSI --}}
                <div class="flex gap-6">

                    <label class="w-40 text-gray-700 pt-2">
                        Deskripsi Kegiatan
                    </label>

                    <textarea
                        name="deskripsi"
                        rows="4"
                        class="flex-1 border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-teal-300 focus:outline-none"
                        placeholder="Tuliskan kegiatan yang dilakukan hari ini..."
                    ></textarea>

                </div>


                {{-- PENDAMPING --}}
                <div class="flex items-center gap-6">

                    <label class="w-40 text-gray-700">
                        Nama Pendamping
                    </label>

                    <select
                        name="pendamping"
                        class="w-64 border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-teal-300 focus:outline-none">

                        <option value="">
                            Pilih Pendamping
                        </option>

                        <option value="Pak Budi">
                            Pak Budi
                        </option>

                        <option value="Bu Sari">
                            Bu Sari
                        </option>

                    </select>

                </div>


                {{-- UPLOAD --}}
                <div class="flex gap-6">

                    <label class="w-40 text-gray-700 pt-3">
                        Dokumentasi Kegiatan
                    </label>

                    <div class="flex-1">

                        <label id="uploadBox"
                            for="uploadFile"
                            class="w-full h-40 border-2 border-dashed border-gray-300 rounded-lg
                            flex flex-col items-center justify-center cursor-pointer
                            hover:border-teal-400 transition">

                            <input
                                type="file"
                                name="dokumentasi"
                                id="uploadFile"
                                class="hidden"
                                accept="image/*,.pdf"
                            >

                            <i class="fa fa-file text-2xl text-gray-500 mb-2"></i>

                            <span id="uploadText" class="text-gray-500 text-sm">
                                Upload file Anda di sini
                            </span>

                            <img id="previewImage" class="hidden h-24 rounded mt-2">

                        </label>

                        <p class="text-xs text-gray-400 mt-2">
                            * Maksimal ukuran foto 2MB <br>
                            * Maksimal ukuran file 10MB
                        </p>

                    </div>

                </div>


                {{-- BUTTON --}}
                <div>

                    <button
                        type="submit"
                        class="px-6 py-2 bg-teal-400 hover:bg-teal-500 text-white rounded shadow-sm transition">

                        Kirim

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- ================= FRONTEND LOGIC ================= --}}
<script>

const form = document.getElementById("logbookForm");
const fileInput = document.getElementById("uploadFile");
const preview = document.getElementById("previewImage");
const uploadText = document.getElementById("uploadText");
const uploadBox = document.getElementById("uploadBox");


// ================= PREVIEW FILE =================
fileInput.addEventListener("change", function(){

    const file = this.files[0];

    if(!file) return;

    uploadText.textContent = file.name;

    if(file.type.startsWith("image/")){

        const reader = new FileReader();

        reader.onload = function(e){

            preview.src = e.target.result;
            preview.classList.remove("hidden");

        };

        reader.readAsDataURL(file);

    }

});


// ================= VALIDASI FORM =================
form.addEventListener("submit", function(e){

    const deskripsi = form.querySelector("textarea").value.trim();
    const pendamping = form.querySelector("select").value;

    if(deskripsi === ""){
        alert("Deskripsi kegiatan harus diisi.");
        e.preventDefault();
        return;
    }

    if(pendamping === ""){
        alert("Silakan pilih nama pendamping.");
        e.preventDefault();
        return;
    }

});


// ================= DRAG & DROP STYLE =================
uploadBox.addEventListener("dragover", function(e){

    e.preventDefault();
    uploadBox.classList.add("border-teal-400");

});

uploadBox.addEventListener("dragleave", function(){

    uploadBox.classList.remove("border-teal-400");

});

</script>

@endsection