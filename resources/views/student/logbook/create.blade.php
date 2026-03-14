@extends('layouts.student')

@section('header')
Logbook Harian
@endsection

@section('content')

<div class="w-full">

    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">

        {{-- ================= TITLE ================= --}}
        <div class="bg-teal-400 text-white px-4 py-2 rounded-md text-sm font-semibold">
            Logbook Harian
        </div>


        {{-- ================= FORM CONTAINER ================= --}}
        <div class="bg-gray-100 rounded-md p-8 mt-4">

            <form id="logbookForm"
                  action="{{ route('student.logbook.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-6">

                @csrf


                {{-- ================= TANGGAL ================= --}}
                <div class="grid md:grid-cols-[180px_1fr] gap-4 items-center">

                    <label class="text-sm text-gray-700">
                        Hari, Tanggal
                    </label>

                    <div class="relative w-full max-w-sm">

                        <input
                            type="text"
                            value="{{ now()->translatedFormat('l, d-m-Y') }}"
                            readonly
                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-white">

                        <i class="fa fa-calendar absolute right-3 top-3 text-gray-400 text-sm"></i>

                    </div>

                    <input
                        type="hidden"
                        name="tanggal"
                        value="{{ now()->format('Y-m-d') }}">

                </div>



                {{-- ================= DESKRIPSI ================= --}}
                <div class="grid md:grid-cols-[180px_1fr] gap-4">

                    <label class="text-sm text-gray-700 pt-2">
                        Deskripsi Kegiatan
                    </label>

                    <textarea
                        name="deskripsi"
                        rows="4"
                        placeholder="Tuliskan kegiatan yang dilakukan hari ini..."
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-teal-300 focus:outline-none"></textarea>

                </div>



                {{-- ================= PENDAMPING ================= --}}
                <div class="grid md:grid-cols-[180px_1fr] gap-4 items-center">

                    <label class="text-sm text-gray-700">
                        Nama Pendamping
                    </label>

                    <select
                        name="pendamping"
                        class="w-full max-w-sm border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-teal-300 focus:outline-none">

                        <option value="">Pilih Pendamping</option>
                        <option value="Pak Budi">Pak Budi</option>
                        <option value="Bu Sari">Bu Sari</option>

                    </select>

                </div>



                {{-- ================= UPLOAD FILE ================= --}}
                <div class="grid md:grid-cols-[180px_1fr] gap-4">

                    <label class="text-sm text-gray-700 pt-2">
                        Dokumentasi Kegiatan
                    </label>

                    <div class="w-full border border-gray-300 rounded p-4 bg-white">

                        <div class="flex flex-wrap items-center gap-4">

                            <input
                                type="file"
                                name="dokumentasi"
                                id="uploadFile"
                                accept="image/png,image/jpeg,image/jpg,application/pdf"
                                class="border border-gray-300 rounded px-3 py-2 text-sm w-full max-w-sm">

                            <span id="fileName" class="text-gray-600 text-sm">
                                Belum ada file dipilih
                            </span>

                        </div>

                        {{-- Preview Image --}}
                        <img id="previewImage"
                             class="hidden h-20 rounded mt-3">

                    </div>

                </div>



                {{-- ================= NOTE ================= --}}
                <div class="md:ml-[180px] text-xs text-gray-400">
                    *Maksimal ukuran foto 2MB <br>
                    *Maksimal ukuran file 10MB
                </div>



                {{-- ================= BUTTON ================= --}}
                <div class="md:ml-[180px]">

                    <button
                        id="submitBtn"
                        type="submit"
                        class="px-6 py-2 bg-teal-400 hover:bg-teal-500 text-white text-sm rounded transition">

                        Kirim

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- ================= SCRIPT ================= --}}
<script>

const fileInput  = document.getElementById("uploadFile");
const fileName   = document.getElementById("fileName");
const preview    = document.getElementById("previewImage");
const form       = document.getElementById("logbookForm");
const submitBtn  = document.getElementById("submitBtn");


// ================= TAMPILKAN NAMA FILE =================
fileInput.addEventListener("change", function(){

    const file = this.files[0];

    if(!file){
        fileName.textContent = "Belum ada file dipilih";
        preview.classList.add("hidden");
        return;
    }

    // validasi ukuran (10MB)
    if(file.size > 10 * 1024 * 1024){

        alert("Ukuran file maksimal 10MB");

        fileInput.value = "";
        fileName.textContent = "Belum ada file dipilih";
        preview.classList.add("hidden");

        return;
    }

    fileName.textContent = file.name;


    // preview jika gambar
    if(file.type.startsWith("image/")){

        const reader = new FileReader();

        reader.onload = function(e){
            preview.src = e.target.result;
            preview.classList.remove("hidden");
        };

        reader.readAsDataURL(file);

    }else{

        preview.classList.add("hidden");

    }

});


// ================= VALIDASI FORM =================
form.addEventListener("submit", function(e){

    if(fileInput.files.length === 0){

        alert("Silakan upload dokumentasi kegiatan terlebih dahulu.");
        e.preventDefault();
        return;

    }

    // loading button
    submitBtn.textContent = "Mengirim...";
    submitBtn.disabled = true;

});

</script>

@endsection