@extends('layouts.student')

@section('header')
Edit Logbook
@endsection

@section('content')

<div class="bg-white shadow-md rounded-xl overflow-hidden">

    {{-- HEADER --}}
    <div class="bg-teal-400 text-white px-6 py-4">
        <h3 class="font-semibold text-lg">
            Detail Logbook
        </h3>
    </div>

    <div class="p-4 md:p-6">

        <form id="logbookForm" action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- HARI TANGGAL --}}
            <div class="grid grid-cols-1 md:grid-cols-[180px_1fr] gap-3 items-center">

                <label class="text-gray-700 text-sm">
                    Hari, Tanggal
                </label>

                <input type="text"
                       value="Kamis, 26-06-2025"
                       readonly
                       class="w-full md:w-72 border rounded-md px-3 py-2 text-sm bg-gray-100">

            </div>


            {{-- DESKRIPSI --}}
            <div class="grid grid-cols-1 md:grid-cols-[180px_1fr] gap-3">

                <label class="text-gray-700 text-sm pt-1">
                    Deskripsi Kegiatan
                </label>

                <div>

                    <textarea
                        id="deskripsi"
                        rows="4"
                        class="w-full border rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-gray-300 focus:outline-none">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</textarea>

                    <p id="descError" class="text-red-500 text-xs mt-1 hidden">
                        Deskripsi kegiatan wajib diisi
                    </p>

                </div>

            </div>


            {{-- PENDAMPING --}}
            <div class="grid grid-cols-1 md:grid-cols-[180px_1fr] gap-3 items-center">

                <label class="text-gray-700 text-sm">
                    Nama Pendamping
                </label>

                <select
                    class="w-full md:w-72 border rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-gray-300">

                    <option>Lorem Ipsum, S. Pd.</option>
                    <option>Pak Budi</option>
                    <option>Bu Sari</option>

                </select>

            </div>


            {{-- DOKUMENTASI --}}
            <div class="grid grid-cols-1 md:grid-cols-[180px_1fr] gap-3">

                <label class="text-gray-700 text-sm pt-2">
                    Dokumentasi Kegiatan
                </label>

                <div>

                    <div class="border border-gray-300 rounded-md p-4">

                        <div
                            class="border-2 border-dashed border-gray-300 rounded-md h-32 flex flex-col items-center justify-center text-gray-500">

                            <input type="file" id="uploadFile" class="hidden">

                            <label for="uploadFile" class="cursor-pointer flex flex-col items-center gap-2">

                                <i class="fa fa-file text-gray-400 text-lg"></i>

                                <span id="fileName" class="text-sm">
                                    namafile.pdf
                                </span>

                            </label>

                        </div>

                    </div>

                    <p id="fileError" class="text-red-500 text-xs mt-1 hidden">
                        Ukuran file maksimal 10MB
                    </p>

                    <p class="text-xs text-gray-400 mt-2">
                        *Maksimal ukuran foto 2MB<br>
                        *Maksimal ukuran file 10MB
                    </p>

                </div>

            </div>


            {{-- BUTTON --}}
            <div class="flex flex-col sm:flex-row gap-3">

                <button type="submit"
                    class="bg-teal-400 hover:bg-teal-500 text-white px-5 py-2 rounded text-sm w-full sm:w-auto">

                    Simpan

                </button>

                <a href="{{ route('student.logbook.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded text-sm text-center w-full sm:w-auto">

                    Batal

                </a>

            </div>

        </form>

    </div>

</div>



{{-- ================= FRONTEND LOGIC ================= --}}
<script>

const form = document.getElementById('logbookForm');
const desc = document.getElementById('deskripsi');
const descError = document.getElementById('descError');

const upload = document.getElementById('uploadFile');
const fileName = document.getElementById('fileName');
const fileError = document.getElementById('fileError');


// PREVIEW FILE
upload.addEventListener('change', function(){

    const file = this.files[0];

    if(!file) return;

    fileName.textContent = file.name;

    if(file.size > 10000000){

        fileError.classList.remove('hidden');
        this.value = "";

    }else{

        fileError.classList.add('hidden');

    }

});


// VALIDASI FORM
form.addEventListener('submit', function(e){

    let valid = true;

    if(desc.value.trim() === ""){

        descError.classList.remove('hidden');
        desc.classList.add('border-red-500');
        desc.focus();

        valid = false;

    }else{

        descError.classList.add('hidden');
        desc.classList.remove('border-red-500');

    }

    if(!valid){
        e.preventDefault();
        return;
    }

    if(!confirm("Simpan perubahan logbook ini?")){
        e.preventDefault();
    }

});


// HAPUS ERROR SAAT MENGETIK
desc.addEventListener('input', function(){

    descError.classList.add('hidden');
    desc.classList.remove('border-red-500');

});

</script>

@endsection