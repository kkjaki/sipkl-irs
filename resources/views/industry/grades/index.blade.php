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
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-4 {{ count($school) > 0 ? 'rounded-t-xl rounded-b-none border-b border-teal-600/50' : 'rounded-xl mb-6 shadow-sm' }} flex flex-col sm:flex-row justify-between items-center text-white gap-4 transition-all">
        <div class="flex items-center gap-2.5 text-white w-full sm:w-auto">
            <x-heroicon-o-academic-cap class="w-6 h-6"/>
            <h2 class="text-xl font-bold m-0 shrink-0">Penilaian Siswa</h2>
        </div>
        
        <!-- High-Contrast Search bar di Header -->
        <div class="relative w-full md:w-64 shrink-0">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </span>
            <input x-model.debounce.500ms="search" type="text" 
                class="block w-full pl-11 pr-4 py-2 bg-white/95 border border-white/40 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-teal-300 sm:text-sm transition-colors" 
                placeholder="Cari nama sekolah...">
        </div>
    </div>

    @if(count($school) > 0)
    <!-- Connected Data Container -->
    <div class="bg-white rounded-b-xl border border-gray-100 shadow-sm p-6 mb-6">
        <!-- Grid Card -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" x-ref="grid">
            @forelse($school as $item)
                <div x-show="search === '' || $el.innerText.toLowerCase().includes(search.toLowerCase())"
                     x-transition:enter="transition ease-out duration-200" 
                     x-transition:enter-start="opacity-0 transform scale-95"
                     class="student-card-data bg-white rounded-xl border border-gray-200 shadow-md hover:shadow-lg transition-shadow duration-200 p-5 flex flex-col h-full">
                    <div class="flex items-start gap-3 mb-4">
                        <x-heroicon-s-building-library class="w-6 h-6 text-teal-600 shrink-0 mt-0.5" />
                        <h3 class="text-lg font-bold text-gray-800 leading-tight">{{ $item->name }}</h3>
                    </div>
                    <div class="flex flex-col gap-3 mb-6 flex-1">
                        <div class="flex items-start gap-3">
                            <x-heroicon-o-map-pin class="w-5 h-5 text-gray-400 shrink-0" />
                            <span class="text-sm text-gray-600">{{ $item->address ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-phone class="w-5 h-5 text-gray-400 shrink-0" />
                            <span class="text-sm text-gray-600">{{ $item->phone ?? '-' }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-auto pt-4 border-t border-gray-100 flex gap-2">
                        <a href="{{ route('grades.schools.show', $item->id) }}" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm text-center">
                            Buka Penilaian
                        </a>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
        
        <!-- Search Empty State -->
        <div x-show="!hasVisible" style="display: none;" class="col-span-full w-full text-center py-12 rounded-xl bg-gray-50 border border-dashed border-gray-200 mt-4">
            <p class="text-gray-500">Sekolah dengan nama tersebut tidak ditemukan.</p>
        </div>
    </div>
    @else
    <!-- Empty State Terpisah -->
    <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-dashed border-gray-200">
        <p class="text-gray-500">Tidak ada data sekolah ditemukan.</p>
    </div>
    @endif
</div>
@endsection
