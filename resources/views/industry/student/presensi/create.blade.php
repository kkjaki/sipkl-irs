@extends('layouts.student')

@section('header')
Presensi Harian
@endsection

@section('content')

<div class="max-w-6xl">

    {{-- CARD --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">

        {{-- HEADER CARD --}}
        <div class="bg-teal-400 text-white px-6 py-3 font-semibold">
            Data Presensi
        </div>

        {{-- BODY --}}
        <div class="p-6">

            <form id="presensiForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- HARI & TANGGAL --}}
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

                {{-- BUKTI PRESENSI --}}
                <div class="flex gap-6">

                    <label class="w-40 text-gray-700 pt-3">
                        Bukti Presensi
                    </label>

                    <div class="flex-1">

                        <label id="uploadBox"
                            for="bukti_presensi"
                            class="w-full h-40 border-2 border-dashed border-gray-300 rounded-lg
                            flex flex-col items-center justify-center cursor-pointer
                            hover:border-teal-400 transition">

                            <input
                                type="file"
                                name="bukti_presensi"
                                id="bukti_presensi"
                                class="hidden"
                                accept="image/*"
                            >

                            <i class="fa fa-camera text-2xl text-gray-500 mb-2"></i>

                            <span id="uploadText" class="text-gray-500 text-sm">
                                Ambil gambar Anda di sini
                            </span>

                            <img id="previewImage" class="hidden h-32 rounded mt-2">

                        </label>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="pt-2">

                    <button
                        type="submit"
                        class="bg-teal-400 hover:bg-teal-500 text-white px-6 py-2 rounded shadow-sm transition">
                        Kirim
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- ================= FRONTEND LOGIC ================= --}}
<script>

const fileInput = document.getElementById('bukti_presensi');
const preview = document.getElementById('previewImage');
const uploadText = document.getElementById('uploadText');
const uploadBox = document.getElementById('uploadBox');
const form = document.getElementById('presensiForm');


// ================= PREVIEW GAMBAR =================
fileInput.addEventListener('change', function(){

    const file = this.files[0];

    if(!file) return;

    const reader = new FileReader();

    reader.onload = function(e){

        preview.src = e.target.result;
        preview.classList.remove('hidden');

        uploadText.textContent = file.name;

    };

    reader.readAsDataURL(file);

});


// ================= VALIDASI FORM =================
form.addEventListener('submit', function(e){

    if(fileInput.files.length === 0){

        alert("Silakan upload bukti presensi terlebih dahulu.");
        e.preventDefault();

    }

});


// ================= DRAG & DROP STYLE =================
uploadBox.addEventListener('dragover', function(e){

    e.preventDefault();
    uploadBox.classList.add('border-teal-400');

});

uploadBox.addEventListener('dragleave', function(){

    uploadBox.classList.remove('border-teal-400');

});

</script>

@endsection