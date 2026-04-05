@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10 pb-10 w-full" x-data="{
        search: '',
        get hasVisible() {
            if (this.search === '') return true;
            const term = this.search.toLowerCase();
            return Array.from(this.$refs.grid.querySelectorAll('.student-card-data')).some(el =>
                el.innerText.toLowerCase().includes(term)
            );
        }
    }">

        <header>
            <div class="py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Penilaian Siswa') }}
                </h2>
            </div>
        </header>

        {{-- Wadah Card Utama --}}
        <article class="w-full bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">

            {{-- Header Card Teal: py-6 biar tingginya sama kayak modul Sesi Presensi --}}
            <div
                class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-4 text-white">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg">
                        <x-heroicon-o-academic-cap class="w-6 h-6 text-white" />
                    </div>
                    <h2 class="font-bold text-lg m-0 leading-none">Daftar Sekolah</h2>
                </div>

                {{-- Search Bar: Tanpa tag <form> & Live Search --}}
                {{-- Search Bar - Warna Putih Solid & High Contrast --}}
                <div class="relative w-full md:w-80 shrink-0">
                    {{-- Ikon Magnifying Glass Abu-abu --}}
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                        <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                    </span>

                    <input x-model.live.debounce.150ms="search" type="text" @keydown.enter.prevent {{-- Class bg-white buat warna putih solid, text-gray-900 buat teks gelap --}}
                        class="block w-full pl-11 pr-4 py-2.5 bg-white border border-transparent rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-teal-300 transition-all sm:text-sm shadow-sm"
                        placeholder="Cari nama siswa...">
                </div>
            </div>

            {{-- Grid Konten --}}
            <div class="p-6">
                @if (count($school) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-ref="grid">
                        @foreach ($school as $item)
                            <section x-show="search === '' || $el.innerText.toLowerCase().includes(search.toLowerCase())"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                class="student-card-data bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-5 flex flex-col h-full group">

                                {{-- Icon & Nama Sekolah --}}
                                <div class="flex items-start gap-3 mb-4">
                                    <div
                                        class="p-2.5 bg-teal-50 rounded-xl group-hover:bg-teal-100 transition-colors border border-teal-100">
                                        <x-heroicon-s-building-library class="w-6 h-6 text-teal-600 shrink-0" />
                                    </div>
                                    <h3
                                        class="text-lg font-bold text-gray-800 leading-tight mt-1 group-hover:text-teal-700 transition-colors">
                                        {{ $item->name }}
                                    </h3>
                                </div>

                                {{-- Info Alamat & Telp --}}
                                <div class="flex flex-col gap-3 mb-6 flex-1 text-gray-600">
                                    <div class="flex items-start gap-3">
                                        <x-heroicon-o-map-pin class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" />
                                        <span
                                            class="text-sm leading-relaxed">{{ $item->address ?: 'Alamat belum diatur' }}</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <x-heroicon-o-phone class="w-5 h-5 text-gray-400 shrink-0" />
                                        <span class="text-sm font-medium">{{ $item->phone ?: '-' }}</span>
                                    </div>
                                </div>

                                {{-- Footer Card & Button --}}
                                <div class="mt-auto pt-4 border-t border-gray-100">
                                    <a href="{{ route('grades.schools.show', $item->id) }}"
                                        class="flex justify-center items-center gap-2 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg transition-all shadow-md shadow-blue-100 active:scale-95">
                                        <x-heroicon-o-folder-open class="w-4 h-4" />
                                        <span>Buka Penilaian</span>
                                    </a>
                                </div>
                            </section>
                        @endforeach
                    </div>

                    {{-- Search Empty State --}}
                    <div x-show="!hasVisible" x-cloak
                        class="w-full text-center py-20 rounded-xl bg-gray-50 border border-dashed border-gray-300">
                        <x-heroicon-o-magnifying-glass class="w-12 h-12 text-gray-300 mx-auto mb-3" />
                        <p class="text-gray-500 font-medium text-lg italic tracking-tight">Sekolah dengan nama "<span
                                x-text="search" class="font-bold text-gray-700"></span>" tidak ditemukan.</p>
                    </div>
                @else
                    <div class="text-center py-20 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                        <x-heroicon-o-building-office-2 class="w-12 h-12 text-gray-300 mx-auto mb-3" />
                        <p class="text-gray-500 font-bold text-lg leading-tight">Tidak ada data sekolah ditemukan</p>
                    </div>
                @endif
            </div>
        </article>
    </main>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
