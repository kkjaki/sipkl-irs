@extends('layouts.app')
@section('title', 'Daftar Sekolah')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10 pb-10">

        {{-- Header Halaman --}}
        <header>
            <div class="py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Daftar Sekolah') }}
                </h2>
            </div>
        </header>

        {{-- Container Utama --}}
        <article class="w-full bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            
            {{-- Header Card Teal --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex justify-between items-center text-white">
                <div class="flex items-center gap-2.5">
                    <x-heroicon-o-building-library class="w-6 h-6" />
                    <h2 class="font-bold text-lg m-0">Data Sekolah</h2>
                </div>
                <a href="{{ route('schools.create') }}"
                    class="bg-white hover:bg-teal-50 text-teal-700 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-all border border-transparent flex items-center gap-2">
                    <x-heroicon-o-plus class="w-4 h-4" /> Tambah Sekolah
                </a>
            </div>

            {{-- Grid Konten --}}
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse ($schools as $school)
                        <section class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-5 flex flex-col h-full group">
                            
                            <div class="flex items-start gap-3 mb-4">
                                <div class="p-2 bg-teal-50 rounded-lg group-hover:bg-teal-100 transition-colors">
                                    <x-heroicon-s-building-library class="w-6 h-6 text-teal-600 shrink-0" />
                                </div>
                                <h3 class="text-lg font-bold text-gray-800 leading-tight mt-1">{{ $school->name }}</h3>
                            </div>

                            <div class="flex flex-col gap-3 mb-6 flex-1">
                                <div class="flex items-start gap-3">
                                    <x-heroicon-o-map-pin class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" />
                                    <span class="text-sm text-gray-600 leading-relaxed">{{ $school->address ?: 'Alamat belum diatur' }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <x-heroicon-o-phone class="w-5 h-5 text-gray-400 shrink-0" />
                                    <span class="text-sm text-gray-600">{{ $school->phone ?: 'Nomor belum diatur' }}</span>
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="mt-auto pt-4 border-t border-gray-100 flex gap-3" x-data="{ openSchool: false }">
                                <a href="{{ route('schools.edit', $school->id) }}"
                                    class="flex-1 flex justify-center items-center gap-2 bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-600 border border-blue-200 py-2.5 px-3 rounded-lg text-sm font-semibold transition-all">
                                    <x-heroicon-o-pencil class="w-4 h-4" /> Edit
                                </a>

                                <button type="button" @click="openSchool = true"
                                    class="flex-1 flex justify-center items-center gap-2 bg-red-50 hover:bg-red-600 hover:text-white text-red-600 border border-red-200 py-2.5 px-3 rounded-lg text-sm font-semibold transition-all">
                                    <x-heroicon-o-trash class="w-4 h-4" /> Hapus
                                </button>

                                {{-- Modal Hapus --}}
                                <div x-show="openSchool" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 flex items-center justify-center bg-black/50 z-[9999] px-4"
                                    style="display: none;">

                                    <div @click.away="openSchool = false"
                                        class="w-full max-w-md px-6 py-8 bg-white rounded-xl shadow-2xl flex flex-col justify-center items-center gap-6">

                                        <div class="bg-amber-100 text-amber-600 p-4 rounded-full shadow-inner">
                                            <x-heroicon-o-exclamation-triangle class="w-10 h-10" />
                                        </div>

                                        <div class="text-center px-4">
                                            <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Sekolah?</h3>
                                            <p class="text-gray-500 text-sm leading-relaxed">
                                                Anda akan menghapus <span class="font-bold text-gray-800">{{ $school->name }}</span> secara permanen dari sistem.
                                            </p>
                                        </div>

                                        <div class="w-full flex justify-center items-center gap-4 mt-2 px-4">
                                            <button @click="openSchool = false" type="button"
                                                class="flex-1 px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all">
                                                Batal
                                            </button>

                                            <form action="{{ route('schools.destroy', $school->id) }}" method="POST" class="flex-1 m-0">
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
                            <x-heroicon-o-document-magnifying-glass class="w-12 h-12 text-gray-300 mx-auto mb-3" />
                            <p class="text-gray-500 font-medium">Tidak ada data sekolah ditemukan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </article>
    </main>
@endsection