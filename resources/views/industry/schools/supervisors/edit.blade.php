@extends('layouts.app')
@section('title', 'Edit Guru Pembimbing')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">

        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Edit Guru Pembimbing') }}
                </h2>
            </div>
        </header>

        {{-- Profil Siswa --}}
        <article class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 flex flex-col mb-8">
            <section class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex items-center text-white font-bold text-lg">
                <x-heroicon-o-pencil-square class="w-6 h-6 mr-2.5 opacity-90" />
                Edit Guru Pembimbing
            </section>
            <form action="{{ route('supervisors.update', $supervisor->id) }}" method="POST" class="p-6 flex flex-col gap-6">
                @csrf
                @method('PUT')
                {{-- Nama Guru Pembimbing --}}
                <div class="flex items-center gap-4">
                    <label for="name" class="w-40 text-gray-700 font-medium text-lg shrink-0">Nama Guru Pembimbing</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $supervisor->name) }}" 
                        required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                </div>

                {{-- Asal Sekolah --}}
                <div class="flex items-center gap-4">
                    <label for="school" class="w-40 text-gray-700 font-medium text-lg shrink-0">Asal Sekolah</label>
                    <input type="text" id="school" name="school" value="{{ $supervisor->school->name }}" disabled required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-gray-500 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                </div>

                {{-- Kontak Guru Pembimbing --}}
                <div class="flex items-center gap-4">
                    <label for="phone" class="w-40 text-gray-700 font-medium text-lg shrink-0">Kontak</label>
                    <input type="tel" id="phone" name="phone" pattern="}"
                        value="{{ old('phone', $supervisor->phone) }}" required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                </div>

                {{-- Button Grup --}}
                <div class="flex justify-start gap-3 mt-4">
                    <button type="submit"
                        class="bg-teal-500 hover:bg-teal-600 text-white px-5 py-2 rounded-md font-medium text-lg">
                        Simpan
                    </button>
                    <a href="{{ route('schools.supervisors.index', $supervisor->school) }}"
                        class="bg-white border border-gray-300 text-gray-600 hover:bg-gray-50 px-5 py-2 rounded-md font-medium text-lg">
                        Batal
                    </a>
                </div>
            </form>
        </article>
    </main>
@endsection
