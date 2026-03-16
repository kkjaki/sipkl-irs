@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Wadah -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-4 rounded-t-xl shadow-sm text-white mb-6">
        <h2 class="text-xl font-bold m-0">Penilaian Siswa</h2>
    </div>

    <!-- Grid Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($school as $item)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between h-full">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $item->name }}</h3>
                </div>
                
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="{{ route('grades.schools.show', $item->id) }}" class="block w-full text-center bg-brand-primary hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        Tambah Penilaian
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10 bg-white rounded-xl shadow-sm border border-gray-100">
                <p class="text-gray-500">Tidak ada data sekolah ditemukan.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
