@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">

        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Guru Pembimbing') }}
                </h2>
            </div>
        </header>

        <article
            class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 px-5 py-5 flex flex-col gap-4">

            {{-- Nama Sekolah --}}
            <section class="flex items-center gap-6">
                <label for="nama_program" class="w-fit text-neutral-800 text-base">Nama Sekolah</label>
                <input type="text" id="nama_program" name="nama_program" value="SMK IT (Informatika) AL-GPT" disabled
                    class="w-1/4 h-10 px-3.5 rounded-md border border-gray-400 text-gray-500 text-base focus:outline-none focus:ring-2 focus:ring-brand-primary" />
            </section>

            <button onclick="window.location.href='{{ route('industry.supervisors.create') }}'"
                class="w-max px-5 py-2 bg-brand-primary hover:bg-teal-500 rounded-md inline-flex justify-center items-center gap-2.5">
                <span class="justify-start text-white text-lg font-bold leading-snug">Tambah Guru Pembimbing</span>
                <x-heroicon-o-plus class="w-6 h-6 text-white" stroke-width="3" />
            </button>

            <section class="bg-brand-primary text-white p-4 font-bold text-lg rounded-t-xl">
                Data Guru Pembimbing
            </section>
            <article class="w-full mx-auto">

                {{-- Cards --}}
                <article class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Card Guru Pembimbing --}}
                    <section
                        class="w-full p-5 bg-white rounded-xl shadow-md outline outline-1 outline-offset-1 outline-neutral-300 inline-flex flex-col justify-center items-start gap-2.5">
                        <h1 class="w-full justify-start text-black text-lg font-bold leading-snug">Joe Nathaniel, S.Pd.</h1>
                        <span
                            class="self-stretch justify-start text-black text-lg font-normal leading-snug">0850000000</span>
                        <article class="w-96 inline-flex justify-start items-center gap-2.5">
                            <button
                                onclick="window.location.href='{{ route('industry.supervisors.edit', ['supervisor' => 1]) }}'"
                                class="flex-1 px-2.5 py-1.5 bg-blue-500 hover:bg-blue-600 rounded-sm flex justify-center items-center gap-2.5">
                                <div class="justify-start text-white text-base leading-tight">Edit</div>
                                <x-heroicon-o-pencil-square class="w-6 h-6 text-white" stroke-width="2" />
                            </button>
                            <section x-data="{ open: false }" class="flex-1">
                                {{-- Tombol Hapus --}}
                                <button @click="open = true"
                                    class="w-full px-2.5 py-1.5 bg-red-500 hover:bg-red-600 rounded-sm flex justify-center items-center gap-2.5">
                                    <span class="text-white text-base">Hapus</span>
                                    <x-lucide-trash class="w-6 h-6 text-white" stroke-width="2" />
                                </button>

                                {{-- Modal --}}
                                <template x-if="open">
                                    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                        <div
                                            class="w-fit px-32 py-7 bg-white rounded-[10px] flex flex-col justify-center items-center gap-8">
                                            <section class="flex flex-col">
                                                <span class="text-center text-neutral-800 text-xl">
                                                    Apakah Anda yakin ingin menghapus
                                                </span>
                                                <span class="text-center text-neutral-800 text-xl">
                                                    Guru Pembimbing?
                                                </span>
                                            </section>
                                            <div class="inline-flex justify-between items-center gap-36">
                                                {{-- Tombol Tidak --}}
                                                <button @click="open = false"
                                                    class="px-5 py-2 rounded-md outline outline-1 outline-stone-300 hover:bg-gray-400 hover:text-white hover:outline-none text-lg">
                                                    Tidak
                                                </button>

                                                {{-- Tombol Ya --}}
                                                <button @click="open = false"
                                                    class="px-7 py-2 rounded-md text-white bg-brand-primary hover:bg-teal-500 hover:text-white">
                                                    Ya
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </section>
                        </article>
                    </section>
                </article>
            </article>
        </article>
    </main>
@endsection
