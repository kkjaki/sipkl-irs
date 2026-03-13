@extends('layouts.student')

@section('header')
Profil Siswa
@endsection

@section('content')

<div class="w-full">

    {{-- CARD --}}
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-teal-400 px-6 py-3">
            <h3 class="text-white text-sm font-semibold">
                Data Siswa
            </h3>
        </div>

        {{-- CONTENT --}}
        <div class="p-8">

            {{-- NOTIFIKASI --}}
            @if(session('success'))
                <div class="mb-6 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('student.profil.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- NIS --}}
                <div class="grid grid-cols-[200px_1fr] items-center gap-4">
                    <label class="text-sm text-gray-600">NIS</label>
                    <input type="text"
                        name="nis"
                        value="{{ old('nis',$student->nis ?? '76521') }}"
                        class="w-full border rounded-md px-3 py-1.5 text-sm bg-gray-50 focus:ring-2 focus:ring-teal-200 focus:outline-none">
                </div>

                {{-- Nama --}}
                <div class="grid grid-cols-[200px_1fr] items-center gap-4">
                    <label class="text-sm text-gray-600">Nama Lengkap</label>
                    <input type="text"
                        name="nama"
                        value="{{ old('nama',$student->nama ?? 'John Doe') }}"
                        class="w-full border rounded-md px-3 py-1.5 text-sm bg-gray-50 focus:ring-2 focus:ring-teal-200 focus:outline-none">
                </div>

                {{-- Kelas --}}
                <div class="grid grid-cols-[200px_1fr] items-center gap-4">
                    <label class="text-sm text-gray-600">Kelas</label>
                    <input type="text"
                        name="kelas"
                        value="{{ old('kelas',$student->kelas ?? '12 RPL 2') }}"
                        class="w-full border rounded-md px-3 py-1.5 text-sm bg-gray-50 focus:ring-2 focus:ring-teal-200 focus:outline-none">
                </div>

                {{-- Sekolah --}}
                <div class="grid grid-cols-[200px_1fr] items-center gap-4">
                    <label class="text-sm text-gray-600">Asal Sekolah</label>
                    <select name="sekolah"
                        class="w-full border rounded-md px-3 py-1.5 text-sm bg-gray-50 focus:ring-2 focus:ring-teal-200 focus:outline-none">

                        <option>SMK IT (Informatika) AL-GPT</option>

                    </select>
                </div>

                {{-- Alamat --}}
                <div class="grid grid-cols-[200px_1fr] items-start gap-4">
                    <label class="text-sm text-gray-600 pt-2">Alamat</label>
                    <textarea name="alamat" rows="2"
                        class="w-full border rounded-md px-3 py-2 text-sm bg-gray-50 focus:ring-2 focus:ring-teal-200 focus:outline-none">{{ old('alamat',$student->alamat ?? 'Jl Otto Iskandarinata Raya 125, Dki Jakarta, Jakarta, 13330') }}</textarea>
                </div>

                {{-- Nomor HP --}}
                <div class="grid grid-cols-[200px_1fr] items-center gap-4">
                    <label class="text-sm text-gray-600">Nomor HP/WA</label>
                    <input type="text"
                        name="hp"
                        value="{{ old('hp',$student->hp ?? '08 berapa manis?') }}"
                        class="w-full border rounded-md px-3 py-1.5 text-sm bg-gray-50 focus:ring-2 focus:ring-teal-200 focus:outline-none">
                </div>

                {{-- Hobi --}}
                <div class="grid grid-cols-[200px_1fr] items-center gap-4">
                    <label class="text-sm text-gray-600">Hobi/Bakat/Talenta</label>
                    <input type="text"
                        name="hobi"
                        value="{{ old('hobi',$student->hobi ?? 'Ada pokoknya wes') }}"
                        class="w-full border rounded-md px-3 py-1.5 text-sm bg-gray-50 focus:ring-2 focus:ring-teal-200 focus:outline-none">
                </div>

                {{-- Guru --}}
                <div class="grid grid-cols-[200px_1fr] items-center gap-4">
                    <label class="text-sm text-gray-600">Guru Pembimbing</label>
                    <select name="guru"
                        class="w-full border rounded-md px-3 py-1.5 text-sm bg-gray-50 focus:ring-2 focus:ring-teal-200 focus:outline-none">

                        <option>Lorem Ipsum S.Pd</option>

                    </select>
                </div>

                {{-- BUTTON --}}
                <div class="flex gap-3 pt-6 pl-[200px]">

                    <button type="submit"
                        class="px-5 py-1.5 bg-teal-500 text-white text-sm rounded-md hover:bg-teal-600 transition">
                        Simpan
                    </button>

                    <button type="button"
                        onclick="window.history.back()"
                        class="px-5 py-1.5 bg-gray-200 text-gray-700 text-sm rounded-md hover:bg-gray-300 transition">
                        Batal
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection