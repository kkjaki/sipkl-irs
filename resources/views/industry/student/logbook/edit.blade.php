@extends('layouts.student')

@section('header')
Edit Logbook
@endsection

@section('content')

<div class="bg-white shadow rounded-lg p-6 max-w-3xl">

    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Tanggal --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Tanggal
            </label>
            <input type="date"
                   name="tanggal"
                   value="2025-06-27"
                   class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gray-300 focus:outline-none">
        </div>

        {{-- Jam --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Jam
            </label>
            <input type="time"
                   name="jam"
                   value="08:00"
                   class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gray-300 focus:outline-none">
        </div>

        {{-- Deskripsi Kegiatan --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Deskripsi Kegiatan
            </label>
            <textarea name="deskripsi"
                      rows="4"
                      class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gray-300 focus:outline-none"
                      placeholder="Masukkan deskripsi kegiatan...">Membuat laporan kegiatan harian dan melakukan diskusi dengan pembimbing lapangan.</textarea>
        </div>

        {{-- Upload Dokumentasi --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Upload Dokumentasi
            </label>
            <input type="file"
                   name="dokumentasi"
                   class="w-full text-sm border rounded-lg px-3 py-2">
        </div>

        {{-- Buttons --}}
        <div class="flex gap-3">
            <button type="submit"
                    class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700 transition">
                Simpan
            </button>

            <a href="{{ route('student.logbook.index') }}"
               class="px-4 py-2 border text-sm rounded-lg hover:bg-gray-100 transition">
                Batal
            </a>
        </div>

    </form>

</div>

@endsection
