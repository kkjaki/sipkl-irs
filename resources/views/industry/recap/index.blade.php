@extends('layouts.app')
@section('title', 'Rekap Aktivitas Siswa')

@section('content')
    <div class="container mx-auto px-4 py-8" x-data="{
        search: '',
        get hasVisible() {
            if (this.search === '') return true;
            const term = this.search.toLowerCase();
            return Array.from(this.$refs.grid.querySelectorAll('.student-card-data')).some(el => el.innerText.toLowerCase().includes(term));
        }
    }">
        <!-- Header Wadah -->
        <div
            class="bg-gradient-to-r from-teal-500 to-teal-600 p-4 {{ count($students) > 0 ? 'rounded-t-xl rounded-b-none border-b border-teal-600/50' : 'rounded-xl mb-6 shadow-sm' }} flex flex-col md:flex-row justify-between items-center text-white gap-4 transition-all">
            <div class="flex items-center gap-2.5 text-white w-full md:w-auto">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                <h1 class="text-xl font-bold m-0 shrink-0">Rekap Aktivitas Siswa</h1>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto justify-end">
                <!-- High-Contrast Search bar di Header -->
                <div class="relative w-full sm:w-64 shrink-0">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                        <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                    </span>
                    <input x-model.debounce.500ms="search" type="text"
                        class="block w-full pl-11 pr-4 py-2 bg-white/95 border border-white/40 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-teal-300 sm:text-sm transition-colors"
                        placeholder="Cari nama siswa...">
                </div>

                <form method="GET" action="{{ route('industry.recap.index') }}" class="m-0 shrink-0 w-full sm:w-auto">
                    <div x-data="{ openDropdown: false, selectedSchoolName: '{{ $schools->where('id', request('school_id'))->first()->name ?? 'Semua Sekolah' }}' }" class="relative">
                        <button type="button" @click="openDropdown = !openDropdown" @click.away="openDropdown = false"
                            class="bg-white/10 hover:bg-white/20 border border-white/20 rounded-lg px-4 py-2 text-sm font-medium flex items-center justify-between gap-2 transition-colors w-full">
                            <span x-text="selectedSchoolName"></span>
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <div x-show="openDropdown" style="display: none;"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 z-50 py-2">
                            <a href="{{ route('industry.recap.index') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors {{ request('school_id') ? '' : 'bg-teal-50 text-teal-700 font-semibold' }}">
                                Semua Sekolah
                            </a>
                            @foreach ($schools as $school)
                                <a href="{{ route('industry.recap.index', ['school_id' => $school->id]) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors {{ request('school_id') == $school->id ? 'bg-teal-50 text-teal-700 font-semibold' : '' }}">
                                    {{ $school->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (count($students) > 0)
            <!-- Connected Data Container -->
            <div class="bg-white rounded-b-xl border border-gray-100 shadow-sm p-6 mb-6">
                <!-- Body / Grid Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4" x-ref="grid">
                    @forelse($students as $student)
                        <div x-show="search === '' || $el.innerText.toLowerCase().includes(search.toLowerCase())"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            class="student-card-data bg-white rounded-xl border border-gray-200 shadow-md hover:shadow-lg transition-shadow duration-200 p-5 relative flex flex-col justify-between h-full">
                            <div>
                                <h2 class="font-bold text-lg text-gray-800">{{ $student->user->name ?? '-' }}</h2>
                                <p class="text-gray-500 text-sm mb-4">{{ $student->school->name ?? '-' }}</p>

                                <!-- Statistik Presensi -->
                                <div class="flex items-center flex-wrap gap-2 mt-4">
                                    <span class="text-sm font-semibold text-gray-600 mr-2">Presensi :</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        Hadir: {{ $student->hadir_count }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                        Izin: {{ $student->izin_count }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                        Sakit: {{ $student->sakit_count }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        Alpa: {{ $student->alpa_count }}
                                    </span>
                                </div>

                                <!-- Statistik Logbook -->
                                <div class="flex items-center flex-wrap gap-2 mt-3">
                                    <span class="text-sm font-semibold text-gray-600 mr-2">Logbook :</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                        Menunggu: {{ $student->pending_count }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        Disetujui: {{ $student->approved_count }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        Ditolak/Revisi: {{ $student->rejected_count }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>

                <!-- Search Empty State -->
                <div x-show="!hasVisible" style="display: none;"
                    class="col-span-full w-full text-center py-12 rounded-xl bg-gray-50 border border-dashed border-gray-200 mt-4">
                    <p class="text-gray-500">Siswa dengan nama tersebut tidak ditemukan.</p>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $students->links() }}
                </div>
            </div>
        @else
            <!-- Empty State Terpisah -->
            <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-dashed border-gray-200">
                <p class="text-gray-500">Tidak ada data rekap siswa ditemukan.</p>
            </div>
        @endif
    </div>
@endsection
