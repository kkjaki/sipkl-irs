@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">

        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Manajemen Sekolah') }}
                </h2>
            </div>
        </header>

        {{-- Profil Siswa --}}
        <article
            class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 px-5 py-5 flex flex-col gap-4">
            <section class="bg-brand-primary text-white p-4 font-bold text-lg rounded-t-xl">
                Data Sekolah
            </section>
            <article class="w-full mx-auto">

                {{-- Data Card --}}
                <article class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Card Data Sekolah --}}
                    <section
                        class="w-full p-5 bg-white rounded-xl shadow-md outline outline-1 outline-offset-1 outline-neutral-300 inline-flex flex-col justify-center items-start gap-2.5">
                        <h1 class="w-full justify-start text-black text-lg font-bold leading-snug">SMK IT (Informatika)
                            AL-GPT</h1>
                        <h2 class="self-stretch justify-start text-black text-lg font-normal leading-snug">Jl Otto
                            Iskandardinata Raya 125, Dki Jakarta, Jakarta, 13330</h2>
                        <span
                            class="self-stretch justify-start text-black text-lg font-normal leading-snug">0850000000</span>
                        <article class="w-full pt-2.5 inline-flex justify-start items-center gap-2.5">
                            <button onclick="window.location.href='{{ route('industry.supervisors.index')}}'"
                                class="w-full flex-1 px-2.5 py-1.5 bg-brand-primary hover:bg-teal-500 rounded-sm flex justify-center items-center gap-2.5">
                                <span class="justify-start text-white text-lg leading-tight">Kelola Guru Pembimbing</span>
                                <i class="fas fa-user-graduate text-white text-lg"></i>
                            </button>
                            <button
                                class="w-full flex-1 px-2.5 py-2 bg-brand-primary hover:bg-teal-500 rounded-sm flex justify-center items-center gap-2.5">
                                <span class="justify-start text-white text-lg leading-tight">Kelola Kriteria Penilaian</span>
                                <x-heroicon-s-academic-cap class="w-6 h-6 text-white" />
                            </button>
                        </article>
                    </section>
                </article>
            </article>
        </article>
    </main>
@endsection