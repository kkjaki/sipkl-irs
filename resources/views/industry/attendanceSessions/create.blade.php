@extends('layouts.app')

@section('content')
<main class="min-h-screen bg-brand-bg px-10 py-8">
    
    {{-- Header --}}
    <div class="mb-6">
        <h2 class="font-extrabold text-3xl text-gray-800 leading-tight">
            Buat Sesi Presensi
        </h2>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif  

    {{-- Form Wrapper --}}
    <form action="{{ route('attendance-sessions.store') }}" method="POST">
        @csrf
        
        {{-- Card Form --}}
        <div class="w-full bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-brand-primary text-white px-6 py-4 font-semibold text-lg">
                Data Sesi Presensi
            </div>
            
            <div class="p-6">
                {{-- Input Fields (Layout Sejajar Horizontal) --}}
                <div class="flex flex-col md:flex-row md:items-center gap-8">
                    
                    {{-- Batas Tepat Waktu --}}
                    <div class="flex items-center gap-3">
                        <label for="on_time_deadline" class="font-medium text-gray-700 whitespace-nowrap">Batas Tepat Waktu</label>
                        <input type="time" name="on_time_deadline" id="on_time_deadline" required class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent text-gray-800">
                    </div>

                    {{-- Jam Tutup --}}
                    <div class="flex items-center gap-3">
                        <label for="closed_at" class="font-medium text-gray-700 whitespace-nowrap">Jam Tutup</label>
                        <input type="time" name="closed_at" id="closed_at" required class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent text-gray-800">
                    </div>

                </div>
            </div>
        </div>

        {{-- Grup Tombol --}}
        <div class="flex gap-4">
            <button type="submit" class="bg-brand-primary text-white font-semibold py-2 px-6 rounded-lg hover:bg-teal-600 transition shadow">
                Buka Sesi
            </button>
            <a href="{{ route('attendance-sessions.index') }}" class="bg-white text-gray-700 border border-gray-300 font-semibold py-2 px-6 rounded-lg hover:bg-gray-50 transition shadow-sm">
                Batal
            </a>
        </div>
    </form>

</main>
@endsection
