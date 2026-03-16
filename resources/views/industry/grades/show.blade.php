@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Wadah -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-4 rounded-t-xl shadow-sm text-white mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold m-0">Penilaian Siswa - {{ $school->name }}</h2>
        <a href="{{ route('grades.schools.index') }}" class="text-white hover:text-teal-200 text-sm font-medium transition-colors">
            &larr; Kembali
        </a>
    </div>

    <!-- Grid Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($students as $student)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative flex flex-col justify-between h-full">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $student->user->name ?? '-' }}</h3>
                    <p class="text-sm text-gray-500 mb-4">{{ $school->name }}</p>

                    <div class="my-4">
                        <span class="text-sm text-gray-500 block mb-1">Rata-rata Nilai</span>
                        <span class="text-3xl font-black text-brand-primary">{{ number_format($student->grades->avg('score') ?? 0, 0) }}</span>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('grades.schools.edit', [$school->id, $student->id]) }}" class="block w-full text-center bg-brand-primary hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        Kelola Nilai
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10 bg-white rounded-xl shadow-sm border border-gray-100">
                <p class="text-gray-500">Tidak ada data siswa ditemukan untuk sekolah ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
