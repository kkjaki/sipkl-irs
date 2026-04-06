@extends('layouts.app')
@section('title', 'Pendamping Industri')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10 pb-10">
        {{-- Header Halaman --}}
        <header>
            <div class="py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Pendamping Industri') }}
                </h2>
            </div>
        </header>

        {{-- Container Utama --}}
        <article class="w-full bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            
            {{-- Header Data --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-3 flex justify-between items-center text-white rounded-t-xl">
                <div class="flex items-center gap-2.5">
                    <x-heroicon-o-users class="w-6 h-6" />
                    <h2 class="font-bold text-lg m-0">Data Pendamping</h2>
                </div>
                <a href="{{ route('mentors.create') }}"
                    class="bg-white hover:bg-teal-50 text-teal-700 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-all border border-transparent leading-none flex items-center gap-2">
                    <x-heroicon-o-plus class="w-4 h-4" /> Tambah Pendamping
                </a>
            </div>

            {{-- Grid Konten --}}
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse ($mentors as $mentor)
                        <section class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-5 flex flex-col h-full group">
                            
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-teal-50 flex items-center justify-center text-teal-700 font-bold border border-teal-100 group-hover:bg-teal-100 transition-colors shadow-sm">
                                        {{ strtoupper(substr($mentor->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <h3 class="text-lg font-bold text-gray-800 leading-tight">{{ $mentor->user->name }}</h3>
                                        <span class="text-xs text-teal-600 font-semibold uppercase tracking-wider">{{ $mentor->position }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 mb-6 flex-1">
                                <div class="p-2 bg-gray-50 rounded-lg">
                                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-400 shrink-0" />
                                </div>
                                <span class="text-sm text-gray-600 font-medium">{{ $mentor->user->email }}</span>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="mt-auto pt-4 border-t border-gray-100 flex gap-3" x-data="{ openDelete: false }">
                                <a href="{{ route('mentors.edit', ['mentor' => $mentor->id]) }}"
                                    class="flex-1 flex justify-center items-center gap-2 bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-600 border border-blue-200 py-2.5 px-3 rounded-lg text-sm font-semibold transition-all">
                                    <x-heroicon-o-pencil class="w-4 h-4" /> Edit
                                </a>

                                <button type="button" @click="openDelete = true"
                                    class="flex-1 flex justify-center items-center gap-2 bg-red-50 hover:bg-red-600 hover:text-white text-red-600 border border-red-200 py-2.5 px-3 rounded-lg text-sm font-semibold transition-all">
                                    <x-heroicon-o-trash class="w-4 h-4" /> Hapus
                                </button>

                                {{-- Modal Hapus --}}
                                <div x-show="openDelete" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 flex items-center justify-center bg-black/50 z-[9999] px-4"
                                    style="display: none;">

                                    <div @click.away="openDelete = false"
                                        class="w-full max-w-md px-6 py-8 bg-white rounded-xl shadow-2xl flex flex-col justify-center items-center gap-6">

                                        <div class="bg-red-100 text-red-600 p-4 rounded-full">
                                            <x-heroicon-o-exclamation-triangle class="w-10 h-10" />
                                        </div>

                                        <div class="text-center px-4">
                                            <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Mentor?</h3>
                                            <p class="text-gray-500 text-sm leading-relaxed">
                                                Aksi ini akan menghapus permanen data <span class="font-bold text-gray-800">{{ $mentor->user->name }}</span>. Akses mentor tersebut ke sistem akan dicabut.
                                            </p>
                                        </div>

                                        <div class="w-full flex justify-center items-center gap-4 mt-2 px-4">
                                            <button @click="openDelete = false" type="button"
                                                class="flex-1 px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all">
                                                Batal
                                            </button>

                                            <form action="{{ route('mentors.destroy', $mentor->id) }}" method="POST" class="flex-1 m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-full px-4 py-2.5 rounded-lg text-white font-semibold bg-red-600 hover:bg-red-700 shadow-md shadow-red-200 transition-all">
                                                    Ya, Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @empty
                        <div class="col-span-full w-full text-center py-16 rounded-xl bg-gray-50 border border-dashed border-gray-300">
                            <x-heroicon-o-user-minus class="w-12 h-12 text-gray-300 mx-auto mb-3" />
                            <p class="text-gray-500 font-medium">Tidak ada data pendamping industri ditemukan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </article>
    </main>
@endsection