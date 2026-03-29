@extends('layouts.app')

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
            class="bg-gradient-to-r from-teal-500 to-teal-600 p-4 {{ count($students) > 0 ? 'rounded-t-xl rounded-b-none border-b border-teal-600/50' : 'rounded-xl mb-6 shadow-sm' }} text-white flex flex-col sm:flex-row justify-between items-center gap-4 transition-all">
            <h2 class="text-xl font-bold m-0 w-full sm:w-auto">Penilaian Siswa - {{ $school->name }}</h2>

            <!-- Search bar di Header -->
            <div class="relative w-full md:w-64 shrink-0">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                </span>
                <input x-model.debounce.500ms="search" type="text"
                    class="block w-full pl-11 pr-4 py-2 bg-white/95 border border-white/40 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-teal-300 sm:text-sm transition-colors"
                    placeholder="Cari nama siswa...">
            </div>
        </div>

        @if (count($students) > 0)
            <!-- Connected Data Container -->
            <div class="bg-white rounded-b-xl border border-gray-100 shadow-sm p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" x-ref="grid">
                    @forelse($students as $student)
                        <div x-show="search === '' || $el.innerText.toLowerCase().includes(search.toLowerCase())"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            class="student-card-data bg-white rounded-xl border border-gray-200 shadow-md hover:shadow-lg transition-shadow duration-200 p-6 relative flex flex-col justify-between h-full">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $student->user->name ?? '-' }}</h3>
                                <p class="text-sm text-gray-500 mb-4">{{ $school->name }}</p>

                                <div class="my-4">
                                    <span class="text-sm text-gray-500 block mb-1">Rata-rata Nilai</span>
                                    <span
                                        class="text-3xl font-black text-brand-primary">{{ number_format($student->grades->avg('score') ?? 0, 0) }}</span>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <a href="{{ route('grades.schools.edit', [$school->id, $student->id]) }}"
                                    class="block w-full text-center bg-brand-primary hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                    Kelola Nilai
                                </a>
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
            </div>
        @else
            <!-- Empty State Terpisah -->
            <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-dashed border-gray-200">
                <p class="text-gray-500">Tidak ada data siswa ditemukan untuk sekolah ini.</p>
            </div>
        @endif

        <!-- Navigation Kembali -->
        <a href="{{ route('grades.schools.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-all duration-200 text-sm mt-8">
            <x-heroicon-o-arrow-left class="w-4 h-4" /> Kembali
        </a>
    </div>
@endsection
