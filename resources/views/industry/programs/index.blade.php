@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">

        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Manajemen Program PKL') }}
                </h2>
            </div>
        </header>

        <article
            class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 px-5 py-5 flex flex-col gap-4">
            <a href="{{ route('internship-programs.create') }}"
                class="w-max px-5 py-2 bg-brand-primary hover:bg-teal-500 rounded-md inline-flex justify-center items-center gap-2.5">
                <span class="justify-start text-white text-lg leading-snug">Buat Program Baru</span>
                <x-heroicon-o-plus class="w-6 h-6 text-white" stroke-width="3" />
            </a>

            <section class="bg-brand-primary text-white p-4 font-bold text-lg rounded-t-xl">
                Data Program PKL
            </section>
            <article class="w-full mx-auto">

                {{-- Cards --}}
                <article class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($programs as $program)
                    {{-- Card Jumlah Siswa --}}
                    <section
                        class="w-full p-5 bg-white rounded-xl shadow-md outline outline-1 outline-offset-1 outline-neutral-300 inline-flex flex-col justify-center items-start gap-2.5">
                        <h1 class="w-full justify-start text-black text-lg font-bold leading-snug">PKL SMK IT (Informatika)
                            AL-GPT</h1>
                        <span class="self-stretch justify-start text-black text-lg font-normal leading-snug">Periode
                            Program:</span>
                        <article class="w-96 inline-flex justify-start items-start gap-2.5">
                            <section class="flex-1 flex justify-start items-center gap-2.5">
                                <span class="justify-start text-black text-lg font-normal leading-snug">Mulai :</span>
                                <section
                                    class="p-1.5 rounded-md outline outline-1 outline-offset-1 outline-emerald-500 flex justify-center items-center gap-2.5">
                                    <span
                                        class="justify-start text-emerald-500 text-lg font-normal leading-snug">14-07-2025</span>
                                </section>
                            </section>
                            <section class="flex-1 flex justify-start items-center gap-2.5">
                                <div class="justify-start text-black text-lg font-normal leading-snug">Selesai :</div>
                                <div
                                    class="p-1.5 rounded-md outline outline-1 outline-offset-1 outline-red-600 flex justify-center items-center gap-2.5">
                                    <div class="justify-start text-red-600 text-lg font-normal leading-snug">12-09-2025
                                    </div>
                                </div>
                            </section>
                        </article>
                        <article class="w-96 pt-2.5 inline-flex justify-start items-center gap-2.5">
                            <button
                                class="flex-1 px-2.5 py-1.5 bg-blue-500 hover:bg-blue-600 rounded-sm flex justify-center items-center gap-2.5">
                                <div class="justify-start text-white text-base leading-tight">Edit</div>
                                <x-heroicon-o-pencil-square class="w-6 h-6 text-white" stroke-width="2" />
                            </button>
                            <button
                                class="flex-1 px-2.5 py-1.5 bg-red-400 hover:bg-red-500 rounded-sm flex justify-center items-center gap-2.5">
                                <div class="justify-start text-white text-base leading-tight">Hapus</div>
                                <x-lucide-trash class="w-6 h-6 text-white" stroke-width="2" />
                            </button>
                        </article>
                    </section>
                </article>
            </article>
        </article>
    </main>
@endsection
