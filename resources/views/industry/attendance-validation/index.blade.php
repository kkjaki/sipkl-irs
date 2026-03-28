@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 rounded-xl p-4 mb-6 shadow-sm flex items-center h-16 justify-between text-white">
        <div class="flex items-center gap-2.5 text-white">
            <x-heroicon-o-clipboard-document-check class="w-6 h-6"/>
            <h2 class="text-white font-bold text-lg m-0 leading-none">Pilih Sekolah untuk Validasi Presensi</h2>
        </div>
    </div>

    <!-- Grid Layout foreach School -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($schools as $school)
            <div class="bg-white rounded-xl border border-gray-200 shadow-md hover:shadow-lg transition-shadow duration-200 p-5 flex flex-col h-full">
                <div class="flex items-start gap-3 mb-4">
                    <x-heroicon-s-building-library class="w-6 h-6 text-teal-600 shrink-0 mt-0.5" />
                    <h3 class="text-lg font-bold text-gray-800 leading-tight">{{ $school->name }}</h3>
                </div>
                <div class="flex flex-col gap-3 mb-6 flex-1">
                    <div class="flex items-start gap-3">
                        <x-heroicon-o-map-pin class="w-5 h-5 text-gray-400 shrink-0" />
                        <span class="text-sm text-gray-600">{{ $school->address ?? '-' }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <x-heroicon-o-phone class="w-5 h-5 text-gray-400 shrink-0" />
                        <span class="text-sm text-gray-600">{{ $school->phone ?? '-' }}</span>
                    </div>
                </div>
                <div class="mt-auto pt-4 border-t border-gray-100 flex gap-2">
                    <a href="{{ route('attendance.validate.schools.show', $school->id) }}" 
                       class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm text-center">
                        Validasi Presensi
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center p-8 bg-white rounded-xl shadow-sm border border-gray-100 text-center">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <p class="text-gray-500 text-lg">Belum ada data sekolah yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
