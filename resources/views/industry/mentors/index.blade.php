@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">
        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Pendamping Industri') }}
                </h2>
            </div>
        </header>

        <div class="w-full mx-auto">
            <div
                class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 px-5 py-5 flex flex-col gap-4">

                <!-- Tombol Tambah Pendamping (di kiri atas) -->
                <a href="{{ route('mentors.create') }}"
                    class="w-max px-5 py-2 bg-brand-primary hover:bg-teal-500 rounded-md inline-flex justify-center items-center gap-2.5">
                    <span class="justify-start text-white text-lg leading-snug">Tambah Pendamping Industri</span>
                    <x-heroicon-o-plus class="w-6 h-6 text-white" stroke-width="3" />
                </a>

                <!-- Label Data Pendamping -->
                <div class="bg-brand-primary text-white font-semibold px-4 py-2 rounded-t-lg">
                    Data Pendamping
                </div>

                <!-- Grid Data Pendamping -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t-0 rounded-b-lg">
                    @foreach ($mentors as $mentor)
                        <div
                            class="w-full p-5 bg-white/80 rounded-md outline outline-1 outline-offset-[-1px] outline-neutral-400 inline-flex flex-col justify-center items-start gap-3.5">
                            <div class="self-stretch inline-flex justify-between items-start">
                                <div class="justify-start text-neutral-800 text-lg font-bold leading-snug">{{ $mentor->user->name }}</div>
                                <div
                                    class="w-24 px-3.5 py-[5px] bg-teal-300/20 rounded-md flex justify-center items-center gap-2.5">
                                    <div class="flex-1 text-center justify-start text-teal-500 text-base leading-tight">
                                        {{ $mentor->position }}</div>
                                </div>
                            </div>
                            <div class="self-stretch justify-start text-neutral-800 text-lg font-normal leading-snug">
                                {{ $mentor->user->email }}
                            </div>
                            <div class="w-1/2 inline-flex justify-start items-center gap-2.5">
                                <a href="{{ route('mentors.edit', ['mentor' => $mentor->id]) }}"
                                    class="flex-1 px-2.5 py-[5px] bg-blue-500 hover:bg-blue-600 rounded-sm flex justify-center items-center gap-2.5">
                                    <div class="justify-start text-white text-base leading-tight">Edit</div>
                                    <x-heroicon-o-pencil-square class="w-6 h-6 text-white" stroke-width="2" />
                                </a>
                                <section x-data="{ open: false }" class="flex-1">
                                    {{-- Tombol Hapus --}}
                                    <button @click="open = true"
                                        class="w-full px-2.5 py-1.5 bg-red-500 hover:bg-red-600 rounded-sm flex justify-center items-center gap-2.5">
                                        <span class="text-white text-base">Nonaktif</span>
                                        <x-heroicon-o-x-mark class="w-6 h-6 text-white" stroke-width="2" />
                                    </button>

                                    {{-- Modal --}}
                                    <template x-if="open">
                                        <div
                                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                            <div
                                                class="w-fit px-32 py-7 bg-white rounded-md flex flex-col justify-center items-center gap-8">
                                                <section class="flex flex-col">
                                                    <span class="text-center text-neutral-800 text-xl">
                                                        Apakah Anda yakin ingin menonaktifkan
                                                    </span>
                                                    <span class="text-center text-neutral-800 text-xl">
                                                        Pendamping ini?
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
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection