@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10 pb-10">

        {{-- Header Halaman --}}
        <header>
            <div class="py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Manajemen Sekolah') }}
                </h2>
            </div>
        </header>

        {{-- Container Utama --}}
        <article class="w-full bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">

            {{-- Header Card --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-5 flex justify-between items-center text-white">
                <div class="flex items-center gap-2.5">
                    <x-heroicon-o-building-library class="w-6 h-6" />
                    <h2 class="font-bold text-lg m-0">Data Sekolah</h2>
                </div>
               
            </div>

            {{-- Isi Konten --}}
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse ($schools as $school)
                        {{-- Card Data Sekolah --}}
                        <section
                            class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-5 flex flex-col h-full group">
                            <div class="flex items-start gap-3 mb-4">
                                <div class="p-2 bg-teal-50 rounded-lg group-hover:bg-teal-100 transition-colors">
                                    <x-heroicon-s-building-library class="w-6 h-6 text-teal-600 shrink-0" />
                                </div>
                                <h3 class="text-lg font-bold text-gray-800 leading-tight mt-1">{{ $school->name }}</h3>
                            </div>

                            <div class="flex flex-col gap-3 mb-6 flex-1">
                                <div class="flex items-start gap-3">
                                    <x-heroicon-o-map-pin class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" />
                                    <span
                                        class="text-sm text-gray-600 leading-relaxed">{{ $school->address ?: 'Alamat belum diatur' }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <x-heroicon-o-phone class="w-5 h-5 text-gray-400 shrink-0" />
                                    <span class="text-sm text-gray-600">{{ $school->phone ?: 'Nomor belum diatur' }}</span>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-auto pt-4 border-t border-gray-100 flex gap-3 w-full">
                                <a href="{{ route('schools.supervisors.index', $school->id) }}"
                                    class="flex-1 flex justify-center items-center gap-2 bg-teal-50 hover:bg-teal-600 hover:text-white text-teal-700 border border-teal-200 py-2.5 px-3 rounded-lg text-sm font-semibold transition-all">
                                    <x-heroicon-o-user-group class="w-4 h-4 shrink-0" />
                                    <span>Kelola Guru</span>
                                </a>
                                <a href="{{ route('schools.criteria.index', $school->id) }}"
                                    class="flex-1 flex justify-center items-center gap-2 bg-teal-50 hover:bg-teal-600 hover:text-white text-teal-700 border border-teal-200 py-2.5 px-3 rounded-lg text-sm font-semibold transition-all">
                                    <x-heroicon-o-clipboard-document-list class="w-4 h-4 shrink-0" />
                                    <span>Kelola Kriteria</span>
                                </a>
                            </div>
                        </section>
                    @empty
                        <div
                            class="col-span-full w-full text-center py-16 rounded-xl bg-gray-50 border border-dashed border-gray-300">
                            <x-heroicon-o-document-magnifying-glass class="w-12 h-12 text-gray-300 mx-auto mb-3" />
                            <p class="text-gray-500 font-medium">Tidak ada data sekolah ditemukan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </article>
    </main>
@endsection
