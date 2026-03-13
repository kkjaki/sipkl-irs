@extends('layouts.student')

@section('header')
Presensi Harian
@endsection

@section('content')

<div class="bg-white rounded-xl shadow-md border border-gray-200 p-4">

<div class="bg-teal-400 text-white px-4 py-2 rounded-md text-sm font-semibold">
    Data Presensi
</div>

<div class="p-6">

    <form id="presensiForm"
          method="POST"
          action="{{ route('student.presensi.store') }}"
          enctype="multipart/form-data"
          class="space-y-6">

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

            <input
                type="hidden"
                name="tanggal"
                value="{{ now()->format('Y-m-d') }}"
            >

        </div>


        {{-- BUKTI PRESENSI --}}
        <div class="flex items-center gap-6">

            <label class="w-40 text-gray-700">
                Bukti Presensi
            </label>

            <div class="flex items-center gap-4">

                <input
                    type="file"
                    name="bukti_presensi"
                    id="bukti_presensi"
                    accept="image/png,image/jpeg,image/jpg"
                    class="border border-gray-300 rounded px-3 py-2 text-sm w-72"
                >

                <span id="fileName" class="text-gray-600 text-sm">
                    Belum ada file dipilih
                </span>

            </div>

        </div>

        <p class="text-xs text-gray-400 ml-40">
            Maksimal ukuran gambar 2MB
        </p>


        {{-- BUTTON --}}
        <div class="pt-2">

            <button
                id="submitBtn"
                type="submit"
                class="bg-teal-400 hover:bg-teal-500 text-white px-6 py-2 rounded shadow-sm transition">

                Kirim

            </button>

        </div>

    </form>

</div>

</div>

<script>

const fileInput = document.getElementById('bukti_presensi');
const fileName = document.getElementById('fileName');
const form = document.getElementById('presensiForm');
const submitBtn = document.getElementById('submitBtn');


// ================= TAMPILKAN NAMA FILE =================
fileInput.addEventListener('change', function(){

    const file = this.files[0];

    if(!file){
        fileName.textContent = "Belum ada file dipilih";
        return;
    }

    const allowedTypes = ['image/jpeg','image/png','image/jpg'];

    // validasi tipe file
    if(!allowedTypes.includes(file.type)){
        alert("File harus berupa gambar (jpg, jpeg, png)");
        fileInput.value="";
        fileName.textContent = "Belum ada file dipilih";
        return;
    }

    // validasi ukuran file
    if(file.size > 2 * 1024 * 1024){
        alert("Ukuran gambar maksimal 2MB");
        fileInput.value="";
        fileName.textContent = "Belum ada file dipilih";
        return;
    }

    fileName.textContent = file.name;

});


// ================= VALIDASI FORM =================
form.addEventListener('submit', function(e){

    if(fileInput.files.length === 0){

        alert("Silakan upload bukti presensi terlebih dahulu.");
        e.preventDefault();
        return;

    }

    // efek loading tombol
    submitBtn.textContent = "Mengirim...";
    submitBtn.disabled = true;

});

</script>

@endsection
