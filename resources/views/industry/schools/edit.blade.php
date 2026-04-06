@extends('layouts.app')
@section('title', 'Edit Sekolah')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">

        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Edit Sekolah') }}
                </h2>
            </div>
        </header>

        <article class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 flex flex-col">
            <section class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex items-center text-white font-bold text-lg">
                <x-heroicon-o-building-library class="w-6 h-6 mr-2.5 opacity-90" />
                Data Sekolah
            </section>

            <form action="{{ route('schools.update', $school->id) }}" method="POST" class="p-6 flex flex-col gap-6">
                @csrf
                @method('PUT')

                {{-- Baris 1: Nama Sekolah --}}
                <div class="flex items-center gap-4">
                    <label for="name" class="w-40 text-gray-700 font-medium text-lg">Nama Sekolah</label>
                    <input type="text" name="name" id="name"
                        value="{{ old('name', $school->name) }}"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent"
                        required>
                </div>

                {{-- Baris 2: Alamat Sekolah --}}
                <div class="flex items-center gap-4">
                    <label for="address" class="w-40 text-gray-700 font-medium text-lg">Alamat Sekolah</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $school->address) }}"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent"
                        required>
                </div>

                {{-- Baris 3: Kontak Sekolah --}}
                <div class="flex items-center gap-4">
                    <label for="phone" class="w-40 text-gray-700 font-medium text-lg">Kontak Sekolah</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $school->phone) }}"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent"
                        required>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-start gap-3 mt-4">
                    <button type="submit"
                        class="px-5 py-2 bg-brand-primary hover:bg-teal-500 text-white rounded-md font-medium text-lg transition-colors">
                        Simpan
                    </button>
                    <a href="{{ route('schools.index') }}"
                        class="px-5 py-2 bg-white border border-gray-300 text-gray-600 hover:bg-gray-50 rounded-md font-medium text-lg flex items-center transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </article>
    </main>
@endsection
