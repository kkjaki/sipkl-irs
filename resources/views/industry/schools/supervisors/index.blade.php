@extends('layouts.app')

@section('content')
<main class="min-h-screen bg-slate-50 px-4 md:px-10 py-6">

    {{-- Header Halaman --}}
    <header class="mb-6">
        <h2 class="font-black text-3xl text-gray-800 leading-tight">
            {{ __('Manajemen Pendamping PKL') }}
        </h2>
    </header>

    {{-- Top Section (Filter/Info) --}}
    <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8 transition-all duration-200 hover:shadow-md">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    Data Sekolah
                </h3>
            </div>
            <div class="p-6">
                <div class="max-w-md">
                    <label for="nama_sekolah" class="block text-sm font-medium text-gray-700 mb-2">Nama Sekolah</label>
                    <div class="relative">
                        <input type="text" id="nama_sekolah" readonly
                            value="{{ $school->nama_sekolah ?? $school->name }}"
                            class="block w-full rounded-lg border-gray-300 bg-gray-50 text-gray-700 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm py-2.5 px-3 cursor-not-allowed">
                    </div>
                </div>
            </div>
        </div>

    {{-- Data Section --}}
    <div>
        <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 rounded-t-xl text-white font-bold text-lg">
            Data Guru Pendamping
        </div>

        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 bg-white border border-t-0 border-gray-100 rounded-b-xl shadow-sm">
            
            {{-- Tombol Tambahkan Pendamping (Element Pertama di Grid) --}}
            <a href="{{ route('schools.supervisors.create', $school->id) }}" class="bg-white border-2 border-dashed border-teal-200 rounded-xl p-6 flex flex-col items-center justify-center gap-4 hover:bg-teal-50 hover:border-teal-300 transition-all shadow-sm group min-h-[220px]">
                <x-heroicon-o-plus-circle class="w-16 h-16 text-teal-400 group-hover:text-teal-500 transition-colors" stroke-width="1.5" />
                <span class="text-xl font-semibold text-teal-500 group-hover:text-teal-600 transition-colors text-center">Tambahkan Pendamping</span>
            </a>

            @foreach ($supervisors as $supervisor)
                <div x-data="{ open: false }" class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col min-h-[220px]">
                    
                    {{-- Header Profil --}}
                    <div class="flex items-center gap-4">
                        <div class="bg-slate-100 rounded-full text-gray-500 w-16 h-16 flex items-center justify-center shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col overflow-hidden">
                            <h3 class="text-lg font-bold text-gray-800 truncate" title="{{ $supervisor->name }}">{{ $supervisor->name }}</h3>
                            <span class="text-xs text-gray-500 mt-0.5">Guru Pendamping</span>
                        </div>
                    </div>

                    {{-- Body Info Kontak --}}
                    <div class="mt-5 flex flex-col gap-3">
                        {{-- Baris Telepon --}}
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-slate-600 font-medium truncate">{{ $supervisor->phone }}</span>
                        </div>

                        {{-- Baris Email --}}
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-slate-600 font-medium truncate text-sm italic">{{ $supervisor->email ?? 'Belum ada email' }}</span>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-auto pt-5 grid grid-cols-2 gap-3">
                        <a href="{{ route('supervisors.edit', $supervisor->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white rounded-lg py-2 flex justify-center items-center gap-2 text-sm font-medium transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Edit
                        </a>
                        
                        <button @click="open = true" class="bg-rose-500 hover:bg-rose-600 text-white rounded-lg py-2 flex justify-center items-center gap-2 text-sm font-medium transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>
                    </div>

                    {{-- Modal Hapus --}}
                    <template x-if="open">
                        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 px-4">
                            <div @click.away="open = false" class="w-full max-w-md px-6 py-8 bg-white rounded-xl shadow-xl flex flex-col justify-center items-center gap-6">
                                <div class="bg-rose-100 text-rose-600 p-3 rounded-full mt-2">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Pendamping?</h3>
                                    <p class="text-gray-500 text-sm">Tindakan ini akan menghapus permanen data <span class="font-semibold text-gray-800">{{ $supervisor->name }}</span>. Proses ini tidak dapat dibatalkan.</p>
                                </div>
                                
                                <div class="w-full flex justify-between items-center gap-4 mt-2">
                                    <button @click="open = false" class="flex-1 px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                                        Batal
                                    </button>

                                    <form action="{{ route('supervisors.destroy', $supervisor->id) }}" method="POST" class="flex-1 m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-4 py-2.5 rounded-lg text-white font-medium bg-rose-600 hover:bg-rose-700 transition-colors">
                                            Ya, Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            @endforeach
        </div>
    </div>
</main>
@endsection
