@extends('layouts.app')

@section('content')

    <main class="min-h-screen bg-brand-bg px-10 pb-10">
        
        {{-- Header Luar --}}
        <header>
            <div class="py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Validasi Sesi Presensi') }}
                </h2>
            </div>
        </header>

        {{-- Container Utama --}}

        <article class="w-full bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden mb-8">
            
            {{-- Header Card Teal (Sekarang Mentok & Sinkron) --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex justify-between items-center text-white">
                <div class="flex items-center gap-2.5">
                    <x-heroicon-o-clipboard-document-check class="w-6 h-6" />
                    <h2 class="text-white font-bold text-lg m-0 leading-none">Pilih Sekolah untuk Validasi Presensi</h2>
                </div>
            </div>

            {{-- Grid Konten --}}
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($schools as $school)
                        <section class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-5 flex flex-col h-full group">
                            
                            <div class="flex items-start gap-3 mb-4">
                                <div class="p-2 bg-teal-50 rounded-lg group-hover:bg-teal-100 transition-colors">
                                    <x-heroicon-s-building-library class="w-6 h-6 text-teal-600 shrink-0" />
                                </div>
                                <h3 class="text-lg font-bold text-gray-800 leading-tight mt-1">{{ $school->name }}</h3>
                            </div>

                            <div class="flex flex-col gap-3 mb-6 flex-1 text-gray-600">
                                <div class="flex items-start gap-3">
                                    <x-heroicon-o-map-pin class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" />
                                    <span class="text-sm leading-relaxed">{{ $school->address ?: 'Alamat belum diatur' }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <x-heroicon-o-phone class="w-5 h-5 text-gray-400 shrink-0" />
                                    <span class="text-sm">{{ $school->phone ?: 'Nomor belum diatur' }}</span>
                                </div>
                            </div>

                            {{-- Action Button --}}
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <a href="{{ route('attendance.validate.schools.show', $school->id) }}"
                                    class="w-full flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg transition-all shadow-md shadow-blue-100 active:scale-95">
                                    <x-heroicon-o-check-badge class="w-5 h-5" />
                                    <span>Pilih Sekolah</span>
                                </a>
                            </div>
                        </section>
                    @empty
                        <div class="col-span-full w-full text-center py-20 rounded-xl bg-gray-50 border border-dashed border-gray-300">
                             <x-heroicon-o-building-office-2 class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                             <p class="text-gray-500 font-bold text-lg">Belum ada data sekolah yang tersedia.</p>
                             <p class="text-sm text-gray-400 mt-1">Pastikan Anda sudah menambahkan sekolah di Manajemen Sekolah.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </article>
    </main>
@endsection