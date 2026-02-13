@extends('layouts.student')

@section('header')
Profil Siswa
@endsection

@section('content')

<div class="bg-white rounded-2xl shadow-md p-8 w-full">

    {{-- Header --}}
    <div class="bg-gray-100 rounded-lg px-4 py-2 mb-8">
        <h3 class="text-sm font-semibold text-gray-700">
            Data Siswa
        </h3>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="mb-6 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM AKTIF --}}
    <form method="POST" action="{{ route('student.profil.update') }}" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- NIS --}}
        <div class="flex items-center">
            <label class="w-48 text-sm text-gray-600">NIS</label>
            <input type="text" name="nis"
                   value="76521"
                   class="flex-1 border rounded-lg px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-slate-300 focus:outline-none">
        </div>

        {{-- Nama --}}
        <div class="flex items-center">
            <label class="w-48 text-sm text-gray-600">Nama Lengkap</label>
            <input type="text" name="nama"
                   value="John Doe"
                   class="flex-1 border rounded-lg px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-slate-300 focus:outline-none">
        </div>

        {{-- Kelas --}}
        <div class="flex items-center">
            <label class="w-48 text-sm text-gray-600">Kelas</label>
            <input type="text" name="kelas"
                   value="12 RPL 2"
                   class="flex-1 border rounded-lg px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-slate-300 focus:outline-none">
        </div>

        {{-- Asal Sekolah --}}
        <div class="flex items-center">
            <label class="w-48 text-sm text-gray-600">Asal Sekolah</label>
            <select name="sekolah"
                class="flex-1 border rounded-lg px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-slate-300 focus:outline-none">
                <option>SMK IT (Informatika) AL-GPT</option>
            </select>
        </div>

        {{-- Alamat --}}
        <div class="flex items-start">
            <label class="w-48 text-sm text-gray-600 pt-2">Alamat</label>
            <textarea name="alamat" rows="3"
                      class="flex-1 border rounded-lg px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-slate-300 focus:outline-none">Jl Otto Iskandarinata Raya 125, Dki Jakarta, Jakarta, 13330</textarea>
        </div>

        {{-- Nomor HP --}}
        <div class="flex items-center">
            <label class="w-48 text-sm text-gray-600">Nomor HP / WA</label>
            <input type="text" name="hp"
                   value="08 berapa manis?"
                   class="flex-1 border rounded-lg px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-slate-300 focus:outline-none">
        </div>

        {{-- Hobi --}}
        <div class="flex items-center">
            <label class="w-48 text-sm text-gray-600">Hobi/Bakat/Talenta</label>
            <input type="text" name="hobi"
                   value="Ada pokoknya wes"
                   class="flex-1 border rounded-lg px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-slate-300 focus:outline-none">
        </div>

        {{-- Guru Pembimbing --}}
        <div class="flex items-center">
            <label class="w-48 text-sm text-gray-600">Guru Pembimbing</label>
            <select name="guru"
                class="flex-1 border rounded-lg px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-slate-300 focus:outline-none">
                <option>Lorem Ipsum S.Pd</option>
            </select>
        </div>

        {{-- Buttons --}}
        <div class="flex gap-3 pt-6 pl-48">
            <button type="submit"
                    class="px-6 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition">
                Simpan
            </button>

            <button type="button"
                    onclick="window.history.back()"
                    class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                Batal
            </button>
        </div>

    </form>

</div>

@endsection
