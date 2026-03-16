@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-400 to-teal-600 rounded-xl p-4 mb-6 shadow-sm flex items-center h-16">
        <h1 class="text-white font-semibold text-lg m-0 leading-none">Pilih Sekolah untuk Validasi Presensi</h1>
    </div>

    <!-- Grid Layout foreach School -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($schools as $school)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex flex-col justify-between">
                <div>
                    <!-- Nama Sekolah -->
                    <h2 class="text-xl font-bold text-gray-800 mb-3">{{ $school->name }}</h2>
                    
                    <!-- Info Sekolah -->
                    <div class="text-sm text-gray-600 space-y-2 mb-4">
                        <p class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>{{ $school->phone ?? '-' }}</span>
                        </p>
                        <p class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="line-clamp-2">{{ $school->address ?? '-' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Tombol Validasi Presensi -->
                <div class="mt-auto pt-4 border-t border-gray-100">
                    <a href="{{ route('attendance.validate.schools.show', $school->id) }}" 
                       class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-2.5 px-4 rounded-lg transition-colors duration-200">
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
