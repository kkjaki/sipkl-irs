@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">

        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Buat Program Baru') }}
                </h2>
            </div>
        </header>

        {{-- Profil Siswa --}}
        <article
            class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 px-5 py-5 flex flex-col gap-4">
            <section class="bg-gradient-to-r from-teal-500 to-teal-600 text-white p-4 font-bold text-lg rounded-t-xl">
                Data Program
            </section>
            <form method="POST" action="{{ route('internship-programs.store') }}" class="w-full mx-auto space-y-5">
                @csrf
                {{-- Nama Program --}}
                <section class="w-full flex items-center gap-6">
                    <label for="nama_program" class="w-40 text-neutral-800 text-base">Nama Program</label>
                    <input type="text" id="nama_program" name="name" placeholder="Masukkan nama program" required
                        class="w-1/3 h-10 px-3.5 rounded-md border border-gray-400 text-neutral-800 text-base focus:outline-none focus:ring-2 focus:ring-brand-primary" />
                </section>

                {{-- Tanggal Mulai --}}
                <section class="w-full flex items-center gap-6">
                    <label for="tanggal_mulai" class="w-40 text-neutral-800 text-base">Tanggal Mulai</label>
                    <input type="date" id="tanggal_mulai" name="start_date" required
                        class="w-64 h-10 px-3.5 rounded-md border border-gray-400 text-neutral-800 text-base focus:outline-none focus:ring-2 focus:ring-brand-primary" />
                </section>

                {{-- Tanggal Selesai --}}
                <section class="w-full flex items-center gap-6">
                    <label for="tanggal_selesai" class="w-40 text-neutral-800 text-base">Tanggal Selesai</label>
                    <input type="date" id="tanggal_selesai" name="end_date" required
                        class="w-64 h-10 px-3.5 rounded-md border border-gray-400 text-neutral-800 text-base focus:outline-none focus:ring-2 focus:ring-brand-primary" />
                </section>

                {{-- Button Grup --}}
                <section class="pt-5 flex items-center gap-3.5">
                    <button type="submit"
                        class="w-max px-5 py-2 bg-brand-primary hover:bg-teal-500 rounded-md inline-flex justify-center items-center gap-2.5">
                        <span class="justify-start text-white text-lg leading-snug">Simpan</span>
                    </button>
                    <a href="{{ route('internship-programs.index') }}"
                        class="w-max px-5 py-2 border border-gray-400 text-gray-500 bg-white rounded-md inline-flex justify-center items-center gap-2.5 hover:bg-gray-400 hover:text-white hover:border-transparent transition">
                        <span class="text-lg leading-snug">Batal</span>
                    </a>
                </section>
            </form>
        </article>
    </main>
@endsection
