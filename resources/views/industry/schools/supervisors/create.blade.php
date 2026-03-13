@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">

        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Tambah Guru Pembimbing') }}
                </h2>
            </div>
        </header>

        {{-- Profil Siswa --}}
        <article
            class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 px-5 py-5 flex flex-col gap-4">
            <section class="bg-brand-primary text-white p-4 font-bold text-lg rounded-t-xl">
                Data Guru Pembimbing
            </section>
            <form action="{{ route('schools.supervisors.store', $school->id) }}" method="POST" class="w-full mx-auto space-y-5">
                @csrf
                {{-- Nama Guru Pembimbing --}}
                <section class="w-full flex items-center gap-2">
                    <label for="name" class="w-32 text-neutral-800 text-base">Nama Guru Pembimbing</label>
                    <input type="text" id="name" name="name" placeholder="Masukkan Nama Guru Pembimbing"
                        required
                        class="w-1/3 h-10 px-3.5 rounded-md border border-gray-400 text-neutral-800 text-base focus:outline-none focus:ring-2 focus:ring-brand-primary" />
                </section>

                {{-- Asal Sekolah --}}
                <section class="w-full flex items-center gap-2">
                    <label for="school" class="w-32 text-neutral-800 text-base">Asal Sekolah</label>
                    <input type="text" id="school" name="school" value="{{ $school->name }}" disabled required
                        class="w-1/3 h-10 px-3.5 rounded-md border border-gray-400 text-stone-700 text-base focus:outline-none focus:ring-2 focus:ring-brand-primary" />
                </section>

                {{-- Kontak Guru Pembimbing --}}
                <section class="w-full flex items-center gap-2">
                    <label for="phone" class="w-32 text-neutral-800 text-base">Kontak</label>
                    <input type="tel" id="phone" name="phone" placeholder="Masukkan Kontak Guru Pembimbing" required
                        class="w-1/3 h-10 px-3.5 rounded-md border border-gray-400 text-neutral-800 text-base focus:outline-none focus:ring-2 focus:ring-brand-primary" />
                </section>

                {{-- Button Grup --}}
                <section class="pt-5 flex items-center gap-3.5">
                    <button type="submit"
                        class="w-max px-5 py-2 bg-brand-primary hover:bg-teal-500 rounded-md inline-flex justify-center items-center gap-2.5">
                        <span class="justify-start text-white text-lg leading-snug">Simpan</span>
                    </button>
                    <a href="{{ route('schools.supervisors.index', $school->id) }}"
                        class="w-max px-5 py-2 border border-gray-400 text-gray-500 bg-white rounded-md inline-flex justify-center items-center gap-2.5 hover:bg-gray-400 hover:text-white hover:border-transparent transition">
                        <span class="text-lg leading-snug">Batal</span>
                    </a>
                </section>
            </form>
        </article>
    </main>
@endsection
