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
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-4 flex justify-between items-center relative rounded-t-xl text-white">
                <div class="flex items-center gap-2.5 text-white">
                    <x-heroicon-o-building-library class="w-6 h-6"/>
                    <h2 class="font-bold text-lg m-0">Data Sekolah</h2>
                </div>
            </div>
            <article class="w-full mx-auto">

                {{-- Data Card --}}
                <article class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Card Data Sekolah --}}
                    @forelse ($schools as $school)
                    <section class="bg-white rounded-xl border border-gray-200 shadow-md hover:shadow-lg transition-shadow duration-200 p-5 flex flex-col h-full">
                        <div class="flex items-start gap-3 mb-4">
                            <x-heroicon-s-building-library class="w-6 h-6 text-teal-600 shrink-0 mt-0.5" />
                            <h3 class="text-lg font-bold text-gray-800 leading-tight">{{ $school->name }}</h3>
                        </div>
                        
                        <div class="flex flex-col gap-3 mb-6 flex-1">
                            <div class="flex items-start gap-3">
                                <x-heroicon-o-map-pin class="w-5 h-5 text-gray-400 shrink-0" />
                                <span class="text-sm text-gray-600">{{ $school->address ?: 'Alamat belum diatur' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <x-heroicon-o-phone class="w-5 h-5 text-gray-400 shrink-0" />
                                <span class="text-sm text-gray-600">{{ $school->phone ?: 'Nomor belum diatur' }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-auto pt-4 border-t border-gray-100 flex gap-2 w-full">
                            <button onclick="window.location.href='{{ route('schools.supervisors.index', $school->id)}}'"
                                class="flex-1 flex justify-center items-center gap-2 bg-teal-50 hover:bg-teal-100 text-teal-700 border border-teal-200 py-2 px-3 rounded-lg text-sm font-medium transition-colors">
                                <x-heroicon-o-user-group class="w-4 h-4 shrink-0" />
                                <span class="truncate">Kelola Guru</span>
                            </button>
                            <button onclick="window.location.href='{{ route('schools.criteria.index', $school->id)}}'"
                                class="flex-1 flex justify-center items-center gap-2 bg-teal-50 hover:bg-teal-100 text-teal-700 border border-teal-200 py-2 px-3 rounded-lg text-sm font-medium transition-colors">
                                <x-heroicon-o-clipboard-document-list class="w-4 h-4 shrink-0" />
                                <span class="truncate">Kelola Kriteria</span>
                            </button>
                        </div>
                    </section>
                    @empty
                        <div class="col-span-full w-full text-center py-10 rounded-xl bg-gray-50 border border-gray-100 mt-4"><p class="text-gray-500">Tidak ada data ditemukan.</p></div>
                    @endforelse
                </article>
            </article>
        </article>
    </main>
@endsection