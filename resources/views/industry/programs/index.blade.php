@extends('layouts.app')
@section('title', 'Manajemen Program PKL')

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

        <!-- Container & Header Data -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div
                class="bg-gradient-to-r from-teal-500 to-teal-600 p-4 flex justify-between items-center relative rounded-t-xl text-white">
                <div class="flex items-center gap-2.5 text-white">
                    <x-heroicon-o-briefcase class="w-6 h-6" />
                    <h2 class="font-bold text-lg m-0">Data Program PKL</h2>
                </div>
                <a href="{{ route('internship-programs.create') }}"
                   class="bg-white hover:bg-teal-50 text-teal-700 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-all border border-transparent flex items-center gap-2">
                    <x-heroicon-o-plus class="w-4 h-4" /> Buat Program
                </a>
            </div>

            <!-- Grid Cards Container -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($internshipPrograms as $program)
                    <!-- Desain Card Program -->
                    <div x-data="{ open: false }"
                        class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-all flex flex-col">

                        <!-- Header Card -->
                        <div class="text-lg font-bold text-gray-800 p-4 border-b">
                            {{ $program->name }}
                        </div>

                        <!-- Body Card - Mentor Data -->
                        <div class="mx-4 mt-5 flex items-center gap-3">
                            <x-heroicon-o-user-circle class="w-9 h-9 text-gray-400" />
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-500">Pendamping:</span>
                                <span
                                    class="text-sm font-bold text-teal-600">{{ $program->mentor->user->name ?? 'Belum ada Pendamping' }}</span>
                            </div>
                        </div>

                        <!-- Body Card - Kode Undangan  -->
                        <div class="text-sm font-medium text-gray-500 mx-4 mt-5">Kode Undangan</div>

                        <div x-data="{ copied: false }"
                            class="bg-gray-50 rounded-md p-3 mx-4 mt-1.5 flex justify-between items-center border border-gray-200">
                            <span
                                class="font-mono text-xl font-black text-brand-primary tracking-widest">{{ $program->invitation_code }}</span>

                            <button
                                @click="navigator.clipboard.writeText('{{ $program->invitation_code }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="p-2 rounded-md hover:bg-gray-200 transition-colors text-gray-500">
                                <template x-if="!copied">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3">
                                        </path>
                                    </svg>
                                </template>
                                <template x-if="copied">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </template>
                            </button>
                        </div>

                        <!-- Body Card - PERIODE PROGRAM -->
                        <h4 class="text-sm font-medium text-gray-500 mx-4 mt-5">Periode Program</h4>
                        <div
                            class="mx-4 mt-1.5 mb-5 p-3 bg-slate-50 rounded-lg border border-slate-100 flex flex-col gap-2.5">
                            <div class="flex items-center justify-between gap-2">
                                <span class="flex items-center gap-1.5 text-sm text-slate-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Mulai
                                </span>
                                <span
                                    class="px-3 py-1 text-sm font-medium bg-emerald-50 text-emerald-700 rounded-full border border-emerald-100">{{ $program->start_date->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="flex items-center gap-1.5 text-sm text-slate-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Selesai
                                </span>
                                <span
                                    class="px-3 py-1 text-sm font-medium bg-rose-50 text-rose-700 rounded-full border border-rose-100">{{ $program->end_date->format('d M Y') }}</span>
                            </div>
                        </div>

                        <div class="mt-auto flex border-t divide-x divide-gray-100 bg-gray-50 rounded-b-lg"
                            x-data="{ openProgram: false }">
                           
                            {{-- Tombol Edit --}}
                            <a href="{{ route('internship-programs.edit', $program->id) }}"
                                class="w-1/2 flex justify-center items-center gap-2 py-3 text-blue-600 hover:bg-blue-100 transition-colors font-medium rounded-bl-lg">
                                Edit <x-heroicon-o-pencil-square class="w-5 h-5" />
                            </a>

                            <button @click="openProgram = true" type="button"
                                class="w-1/2 h-full flex justify-center items-center gap-2 py-3 text-red-600 hover:bg-red-100 transition-colors font-medium rounded-br-lg">
                                Hapus <x-lucide-trash class="w-5 h-5" />
                            </button>

                            <div x-show="openProgram" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 flex items-center justify-center bg-black/50 z-[9999] px-4"
                                    style="display: none;">
                                <div @click.away="openProgram = false"
                                    class="w-full max-w-md px-6 py-8 bg-white rounded-2xl shadow-2xl flex flex-col justify-center items-center gap-6">

                                    <div class="bg-amber-100 text-amber-600 p-4 rounded-full">
                                        <x-heroicon-o-trash class="w-10 h-10" />
                                    </div>

                                    <div class="text-center px-4">
                                        <h3 class="text-2xl font-black text-gray-900 mb-2">Hapus Program?</h3>
                                        <p class="text-gray-500 text-sm leading-relaxed">
                                            Data absensi dan jurnal di program <span
                                                class="font-bold text-red-600">"{{ $program->name }}"</span> akan ikut
                                            terhapus secara permanen.
                                        </p>
                                    </div>

                                    <div class="w-full flex flex-col gap-3 mt-2 px-4">
                                        <form action="{{ route('internship-programs.destroy', $program->id) }}"
                                            method="POST" class="w-full m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full px-4 py-3 rounded-xl text-white font-bold bg-red-600 hover:bg-red-700 shadow-lg shadow-red-200 transition-all">
                                                SAYA MENGERTI, HAPUS
                                            </button>
                                        </form>

                                        <button @click="openProgram = false" type="button"
                                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-gray-500 font-medium hover:bg-gray-50 transition-all">
                                            Batalkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full w-full text-center py-10 rounded-xl bg-gray-50 border border-gray-100 mt-4">
                        <p class="text-gray-500">Tidak ada data ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
@endsection
