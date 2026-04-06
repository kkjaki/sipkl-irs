@extends('layouts.app')
@section('title', 'Rekap Aktivitas Siswa')

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

        {{-- Header Halaman --}}
        <header>
            <div class="py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Rekap Aktivitas Siswa') }}
                </h2>
            </div>
        </header>

        {{-- Container Utama --}}
        <article class="w-full bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">

            <div
                class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-3 flex flex-col md:flex-row justify-between items-center text-white">
                <div class="flex items-center gap-2.5 text-white w-full md:w-auto">
                    <x-heroicon-o-chart-bar class="w-6 h-6 shrink-0" />
                    <h1 class="text-xl font-bold m-0 shrink-0">Data Rekapitulasi</h1>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                    <div class="relative w-full sm:w-64 shrink-0">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                            <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                        </span>
                        <input x-model.live.debounce.300ms="search" type="text"
                            class="block w-full pl-11 pr-4 py-1.5 bg-white border border-transparent rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-teal-300 sm:text-sm transition-all shadow-sm"
                            placeholder="Cari nama siswa...">
                    </div>

                    {{-- Dropdown Filter Sekolah --}}
                    <div x-data="{ openDropdown: false, selectedSchoolName: '{{ $schools->where('id', request('school_id'))->first()->name ?? 'Semua Sekolah' }}' }" class="relative w-full sm:w-auto">
                        <button type="button" @click="openDropdown = !openDropdown" @click.away="openDropdown = false"
                            class="bg-white/20 hover:bg-white/30 border border-white/20 rounded-xl px-4 py-1.5 text-sm font-bold flex items-center justify-between gap-2 transition-all w-full text-white">
                            <span x-text="selectedSchoolName"></span>
                            <x-heroicon-o-chevron-down class="w-4 h-4 transition-transform" ::class="openDropdown ? 'rotate-180' : ''" />
                        </button>

                        <div x-show="openDropdown" x-cloak x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 z-50 py-2 overflow-hidden">
                            <a href="{{ route('industry.recap.index') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors {{ request('school_id') ? '' : 'bg-teal-50 text-teal-700 font-bold' }}">
                                Semua Sekolah
                            </a>
                            <div class="border-t border-gray-50 my-1"></div>
                            @foreach ($schools as $school)
                                <a href="{{ route('industry.recap.index', ['school_id' => $school->id]) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors {{ request('school_id') == $school->id ? 'bg-teal-50 text-teal-700 font-bold' : '' }}">
                                    {{ $school->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Body Konten --}}
            <div class="p-6">
                @if (count($students) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-ref="grid">
                        @foreach ($students as $student)
                            <section x-show="search === '' || $el.innerText.toLowerCase().includes(search.toLowerCase())"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                class="student-card-data bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-6 flex flex-col justify-between group">

                                <div>
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="p-2.5 bg-teal-50 rounded-xl group-hover:bg-teal-100 transition-colors">
                                                <x-heroicon-s-user class="w-6 h-6 text-teal-600" />
                                            </div>
                                            <div>
                                                <h2
                                                    class="font-bold text-lg text-gray-800 leading-tight group-hover:text-teal-700 transition-colors">
                                                    {{ $student->user->name ?? '-' }}</h2>
                                                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-0.5">
                                                    {{ $student->school->name ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-4 mt-6">
                                        <div>
                                            <label
                                                class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-2">Ringkasan
                                                Presensi</label>
                                            <div class="flex flex-wrap gap-2">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-green-50 text-green-700 border border-green-100">Hadir:
                                                    {{ $student->hadir_count }}</span>
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">Izin:
                                                    {{ $student->izin_count }}</span>
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-100">Sakit:
                                                    {{ $student->sakit_count }}</span>
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-red-50 text-red-700 border border-red-100">Alpa:
                                                    {{ $student->alpa_count }}</span>
                                            </div>
                                        </div>

                                        <div>
                                            <label
                                                class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-2">Status
                                                Logbook</label>
                                            <div class="flex flex-wrap gap-2">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">Menunggu:
                                                    {{ $student->pending_count }}</span>
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-teal-50 text-teal-700 border border-teal-100">Disetujui:
                                                    {{ $student->approved_count }}</span>
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">Revisi:
                                                    {{ $student->rejected_count }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endforeach
                    </div>

                    {{-- Search Empty State --}}
                    <div x-show="!hasVisible" x-cloak
                        class="w-full text-center py-20 rounded-xl bg-gray-50 border border-dashed border-gray-300 mt-6">
                        <x-heroicon-o-magnifying-glass class="w-12 h-12 text-gray-300 mx-auto mb-3" />
                        <p class="text-gray-500 font-medium">Siswa dengan nama "<span x-text="search"
                                class="font-bold text-gray-700"></span>" tidak ditemukan.</p>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $students->links() }}
                    </div>
                @else
                    <div class="text-center py-20 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                        <x-heroicon-o-document-magnifying-glass class="w-12 h-12 text-gray-300 mx-auto mb-3" />
                        <p class="text-gray-500 font-bold text-lg">Tidak ada data rekap ditemukan.</p>
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
