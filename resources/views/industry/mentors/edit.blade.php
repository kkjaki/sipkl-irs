@extends('layouts.app')
@section('title', 'Edit Pendamping Industri')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">

        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Edit Pendamping Industri') }}
                </h2>
            </div>
        </header>

        {{-- Profil Siswa --}}
        <article class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 flex flex-col mb-8">
            <section class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex items-center text-white font-bold text-lg">
                <x-heroicon-o-pencil-square class="w-6 h-6 mr-2.5 opacity-90" />
                Edit Pendamping Industri
            </section>
            
            <form method="POST" action="{{ route('mentors.update', $mentor->id) }}" class="p-6 flex flex-col gap-6">
                @method('PUT')
                @csrf
                
                {{-- Nama Guru Pembimbing --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <label for="name" class="w-full sm:w-40 text-gray-700 font-medium text-lg shrink-0">Nama Pendamping</label>
                    <input type="text" id="name" name="name" value="{{ $mentor->user->name }}" placeholder="Masukkan Nama Pendamping"
                        required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                </div>

                {{-- Email --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <label for="email" class="w-full sm:w-40 text-gray-700 font-medium text-lg shrink-0">Email</label>
                    <input type="email" id="email" name="email" value="{{ $mentor->user->email }}" placeholder="Masukkan Email" required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                </div>

                {{-- Kata Sandi --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <label for="password" class="w-full sm:w-40 text-gray-700 font-medium text-lg shrink-0">Kata Sandi</label>
                    <input type="password" id="password" name="password"  placeholder="Ubah kata sandi melalui profil!" required disabled
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-gray-500 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                </div>

                {{-- Jabatan --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <label for="position" class="w-full sm:w-40 text-gray-700 font-medium text-lg shrink-0">Jabatan</label>
                    <input type="text" id="position" name="position" value="{{ $mentor->position }}" placeholder="Masukkan Jabatan" required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                </div>

                {{-- Button Grup --}}
                <div class="flex justify-start gap-3 mt-4">
                    <button type="submit"
                        class="bg-teal-500 hover:bg-teal-600 text-white px-5 py-2 rounded-md font-medium text-lg">
                        Simpan
                    </button>
                    <a href="{{ route('mentors.index') }}"
                        class="bg-white border border-gray-300 text-gray-600 hover:bg-gray-50 px-5 py-2 rounded-md font-medium text-lg">
                        Batal
                    </a>
                </div>
            </form>
        </article>
    </main>
@endsection