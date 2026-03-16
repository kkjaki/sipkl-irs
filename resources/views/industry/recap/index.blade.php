@extends('layouts.app')
@section('title', 'Rekap Aktivitas Siswa')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Wadah Utama -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <!-- Header Wadah -->
        <div class="bg-brand-primary p-4 flex justify-between items-center relative rounded-t-xl text-white">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <h1 class="text-xl font-bold m-0">Rekap Aktivitas Siswa</h1>
            </div>
            
            <form method="GET" action="{{ route('industry.recap.index') }}" class="m-0">
                <div x-data="{ openDropdown: false, selectedSchoolName: '{{ $schools->where('id', request('school_id'))->first()->name ?? 'Semua Sekolah' }}' }" class="relative">
                    <button type="button" @click="openDropdown = !openDropdown" @click.away="openDropdown = false" class="bg-white/10 hover:bg-white/20 border border-white/20 rounded-full px-4 py-2 text-sm font-medium flex items-center gap-2 transition-colors">
                        <span x-text="selectedSchoolName"></span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="openDropdown" style="display: none;"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 z-50 py-2">
                        <a href="{{ route('industry.recap.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors {{ request('school_id') ? '' : 'bg-teal-50 text-teal-700 font-semibold' }}">
                            Semua Sekolah
                        </a>
                        @foreach($schools as $school)
                            <a href="{{ route('industry.recap.index', ['school_id' => $school->id]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors {{ request('school_id') == $school->id ? 'bg-teal-50 text-teal-700 font-semibold' : '' }}">
                                {{ $school->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>

        <div class="p-6">
            <!-- Body / Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                @forelse($students as $student)
                    <div class="bg-white border border-gray-100 shadow-sm rounded-lg p-5 hover:shadow-md transition-shadow duration-200">
                        <h2 class="font-bold text-lg text-gray-800">{{ $student->user->name ?? '-' }}</h2>
                        <p class="text-gray-500 text-sm mb-4">{{ $student->school->name ?? '-' }}</p>

                        <!-- Statistik Presensi -->
                        <div class="flex items-center flex-wrap gap-2 mt-4">
                            <span class="text-sm font-semibold text-gray-600 mr-2">Presensi :</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                Hadir: {{ $student->hadir_count }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                Izin: {{ $student->izin_count }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                Sakit: {{ $student->sakit_count }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                Alpa: {{ $student->alpa_count }}
                            </span>
                        </div>

                        <!-- Statistik Logbook -->
                        <div class="flex items-center flex-wrap gap-2 mt-3">
                            <span class="text-sm font-semibold text-gray-600 mr-2">Logbook :</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                Menunggu: {{ $student->pending_count }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                Disetujui: {{ $student->approved_count }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                Ditolak/Revisi: {{ $student->rejected_count }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 text-center py-10 rounded-xl bg-gray-50">
                        <p class="text-gray-500">Tidak ada data siswa ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
