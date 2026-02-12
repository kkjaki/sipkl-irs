@extends('layouts.student')

@section('content')
<main class="min-h-screen bg-brand-bg px-10">

    {{-- Header --}}
    <header>
        <div class="w-full py-6">
            <h2 class="font-black text-3xl text-gray-800 leading-tight">
                {{ __('Presensi Harian') }}
            </h2>
        </div>
    </header>

    {{-- Card Presensi --}}
    <article
        class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 px-5 py-5 flex flex-col gap-4">

        {{-- Title Card --}}
        <section class="bg-gray-200 text-gray-800 p-4 font-bold text-lg rounded-t-xl">
            Data Presensi
        </section>

        {{-- Form Presensi --}}
        <form action="#" method="POST" enctype="multipart/form-data" class="w-full mx-auto space-y-6">
            @csrf

            {{-- Hari & Tanggal --}}
            <section class="w-full flex items-center gap-4">
                <label class="w-40 text-neutral-800 text-base">
                    Hari, Tanggal
                </label>
                <input type="text"
                    value="{{ now()->translatedFormat('l, d-m-Y') }}"
                    readonly
                    class="w-1/3 h-10 px-3.5 rounded-md border border-gray-300 bg-gray-100 text-neutral-700 text-base focus:outline-none" />
            </section>

            {{-- Bukti Presensi --}}
            <section class="w-full flex items-start gap-4">
                <label class="w-40 text-neutral-800 text-base pt-2">
                    Bukti Presensi
                </label>

                <div
                    class="w-1/2 h-48 border-2 border-dashed border-gray-300 rounded-md flex flex-col items-center justify-center text-gray-500 cursor-pointer hover:border-brand-primary transition">
                    
                    <input type="file" name="bukti_presensi" class="hidden" id="bukti_presensi" />

                    <label for="bukti_presensi" class="flex flex-col items-center justify-center gap-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7h2l2-3h10l2 3h2v13H3V7z" />
                            <circle cx="12" cy="13" r="4" />
                        </svg>
                        <span class="text-sm text-gray-500">
                            Ambil gambar Anda di sini
                        </span>
                    </label>
                </div>
            </section>

            {{-- Button --}}
            <section class="pt-4 flex items-center gap-3">
                <button type="submit"
                    class="px-6 py-2 bg-brand-primary hover:bg-teal-500 rounded-md text-white text-lg transition">
                    Kirim
                </button>
            </section>
        </form>
    </article>
</main>
@endsection
