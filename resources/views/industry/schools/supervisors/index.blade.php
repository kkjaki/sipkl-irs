@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">

        {{-- Header Halaman --}}
        <header class="w-full py-6">
            <h2 class="font-black text-3xl text-gray-800 leading-tight">
                {{ __('Manajemen Pendamping PKL') }}
            </h2>
        </header>

        {{-- Top Section (Filter/Info) --}}
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex justify-between items-center text-white">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    Data Sekolah
                </h3>
            </div>
            <div class="p-6">
                <div class="max-w-md">
                    <label for="nama_sekolah" class="block text-sm font-medium text-gray-700 mb-2">Nama Sekolah</label>
                    <div class="relative">
                        <input type="text" id="nama_sekolah" readonly
                            value="{{ $school->nama_sekolah ?? $school->name }}"
                            class="block w-full rounded-lg border-gray-300 bg-gray-50 text-gray-700 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5 px-3 cursor-not-allowed">
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div
                class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex justify-between items-center text-white">
                <div class="flex items-center gap-2.5">
                    <x-heroicon-o-user-group class="w-6 h-6" />
                    <h2 class="font-bold text-lg m-0">Data Guru Pendamping</h2>
                </div>
                <a href="{{ route('schools.supervisors.create', $school->id) }}"
                    class="bg-white text-teal-600 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-semibold flex items-center gap-2 transition-colors shadow-sm">
                    <x-heroicon-o-plus class="w-4 h-4" /> Tambah Pendamping
                </a>
            </div>

            <div
                class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 bg-white border border-t-0 border-gray-100 rounded-b-xl shadow-sm">

                @forelse ($supervisors as $supervisor)
                    <div x-data="{ open: false }"
                        class="bg-white rounded-xl border border-gray-200 shadow-md hover:shadow-lg transition-shadow duration-200 p-5 flex flex-col h-full">

                        {{-- Header Profil --}}
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-700 font-bold shrink-0">
                                    {{ strtoupper(substr($supervisor->name, 0, 1)) }}
                                </div>
                                <h3 class="text-lg font-bold text-gray-800" title="{{ $supervisor->name }}">
                                    {{ $supervisor->name }}</h3>
                            </div>
                            <span
                                class="bg-teal-50 text-teal-600 px-3 py-1 rounded-full text-xs font-semibold border border-teal-100">Guru</span>
                        </div>

                        {{-- Body Info Kontak --}}
                        <div class="flex flex-col gap-3 mb-6 flex-1">
                            <div class="flex items-center gap-3">
                                <x-heroicon-o-phone class="w-5 h-5 text-gray-400 shrink-0" />
                                <span class="text-sm text-gray-600">{{ $supervisor->phone }}</span>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        {{-- PEMBUNGKUS UTAMA --}}
                        <div x-data="{ open: false }">

                            {{-- Footer Tombol --}}
                            <div class="mt-auto pt-4 border-t border-gray-100 flex gap-2">
                                <a href="{{ route('supervisors.edit', $supervisor->id) }}"
                                    class="flex-1 flex justify-center items-center gap-2 bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 py-2 px-3 rounded-lg text-sm font-medium transition-colors">
                                    <x-heroicon-o-pencil class="w-4 h-4" /> Edit
                                </a>

                                {{-- Tombol Hapus (Pemicu Modal) --}}
                                <button type="button" @click="open = true"
                                    class="flex-1 flex justify-center items-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 py-2 px-3 rounded-lg text-sm font-medium transition-colors">
                                    <x-heroicon-o-trash class="w-4 h-4" /> Hapus
                                </button>
                            </div>

                            {{-- MODAL DESAIN KECE (Pake x-show + transition) --}}
                            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="fixed inset-0 flex items-center justify-center bg-black/50 z-[9999] px-4"
                                style="display: none;">

                                {{-- Konten Modal --}}
                                <div @click.away="open = false"
                                    class="w-full max-w-md px-6 py-8 bg-white rounded-xl shadow-xl flex flex-col justify-center items-center gap-6">

                                    <div class="bg-rose-100 text-rose-600 p-3 rounded-full mt-2">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                    </div>

                                    <div class="text-center">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Pendamping?</h3>
                                        <p class="text-gray-500 text-sm">Tindakan ini akan menghapus permanen data <span
                                                class="font-semibold text-gray-800">{{ $supervisor->name }}</span>.</p>
                                    </div>

                                    <div class="w-full flex justify-between items-center gap-4 mt-2">
                                        <button @click="open = false" type="button"
                                            class="flex-1 px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                                            Batal
                                        </button>

                                        <form action="{{ route('supervisors.destroy', $supervisor->id) }}" method="POST"
                                            class="flex-1 m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full px-4 py-2.5 rounded-lg text-white font-medium bg-rose-600 hover:bg-rose-700 transition-colors">
                                                Ya, Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full w-full text-center py-12 rounded-xl bg-gray-50 border border-dashed border-gray-200">
                        <p class="text-gray-500">Belum ada data guru pendamping untuk sekolah ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
@endsection
