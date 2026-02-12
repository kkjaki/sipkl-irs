@extends('layouts.student')

@section('header')
Logbook Harian
@endsection

@section('content')

<div class="bg-white shadow rounded-lg p-8 w-full min-h-[80vh]">

    <form action="{{ route('student.logbook.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf

        {{-- Hari & Tanggal --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Hari, Tanggal
            </label>
            <input type="date"
                   name="tanggal"
                   class="border rounded-lg px-4 py-2 text-sm w-64 focus:ring-2 focus:ring-gray-300 focus:outline-none">
        </div>

        {{-- Deskripsi Kegiatan --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi Kegiatan
            </label>
            <textarea name="deskripsi"
                      rows="4"
                      class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-gray-300 focus:outline-none"
                      placeholder="Tuliskan kegiatan yang dilakukan hari ini..."></textarea>
        </div>

        {{-- Nama Pendamping --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nama Pendamping
            </label>
            <select name="pendamping"
                    class="border rounded-lg px-4 py-2 text-sm w-64 focus:ring-2 focus:ring-gray-300 focus:outline-none">
                <option value="">Pilih Pendamping</option>
                <option value="Pak Budi">Pak Budi</option>
                <option value="Bu Sari">Bu Sari</option>
            </select>
        </div>

        {{-- Dokumentasi --}}
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-3">
                Dokumentasi Kegiatan
            </label>

            <div class="border-2 border-dashed rounded-lg p-10 text-center text-gray-500 text-sm">
                <input type="file" 
                       name="dokumentasi" 
                       class="hidden" 
                       id="uploadFile">

                <label for="uploadFile" class="cursor-pointer">
                    <div class="flex flex-col items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="w-8 h-8 text-gray-400" 
                             fill="none" 
                             viewBox="0 0 24 24" 
                             stroke="currentColor">
                            <path stroke-linecap="round" 
                                  stroke-linejoin="round" 
                                  stroke-width="2" 
                                  d="M7 16V4m0 0L3 8m4-4l4 4m6 8v4m0 0l-4-4m4 4l4-4" />
                        </svg>
                        <p>Upload file Anda di sini</p>
                    </div>
                </label>
            </div>

            <p class="text-xs text-gray-400 mt-3">
                * Maksimal ukuran file 2MB <br>
                * Format file JPG, PNG, PDF
            </p>
        </div>

        {{-- Button --}}
        <div>
            <button type="submit"
                    class="px-6 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700 transition">
                Kirim
            </button>
        </div>

    </form>

</div>

@endsection
