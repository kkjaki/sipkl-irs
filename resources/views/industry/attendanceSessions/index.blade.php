@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Header Luar -->
    <h1 class="font-bold text-3xl mb-6 text-gray-800">Kelola Sesi Presensi</h1>

    <!-- Wadah Utama -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
        
        <!-- Header Wadah -->
        <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex justify-between items-center text-white">
            <div class="flex items-center gap-2.5 text-white">
                <x-heroicon-o-clipboard-document-list class="w-6 h-6"/>
                <h2 class="font-bold text-lg m-0">Data Sesi Presensi</h2>
            </div>
            <a href="{{ route('attendance-sessions.create') }}" class="bg-white text-teal-600 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-semibold flex items-center gap-2 transition-colors shadow-sm">
                <x-heroicon-o-plus class="w-4 h-4"/> Buka Sesi Baru
            </a>
        </div>

        <!-- Body Wadah (Grid Card Sesi) -->
        <div class="p-6">
            @php $now = \Carbon\Carbon::now(); @endphp

            @if($attendanceSessions->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    @forelse($attendanceSessions as $session)
                        @php
                            $isExpired = $now->greaterThan($session->closed_at);
                            $isActive = $session->is_open && !$isExpired;
                        @endphp

                        <div x-data="{ showModal: false }" class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm relative flex flex-col justify-between hover:shadow-md transition duration-200">
                            
                            <!-- Badge Status -->
                            <div class="absolute top-4 right-4">
                                @if($isActive)
                                    <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-semibold border border-green-200">
                                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Aktif
                                    </span>
                                @elseif($isExpired)
                                    <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 px-2.5 py-1 rounded-full text-xs font-semibold border border-red-200">
                                        <span class="w-2 h-2 rounded-full bg-red-500"></span> Waktu Habis
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full text-xs font-semibold border border-gray-200">
                                        <span class="w-2 h-2 rounded-full bg-gray-400"></span> Nonaktif (Manual)
                                    </span>
                                @endif
                            </div>

                            <!-- Konten Atas -->
                            <div class="mb-4 pr-32">
                                <h3 class="font-bold text-xl text-gray-800 mb-1">Sesi Presensi Harian</h3>
                                
                                <!-- Data Tanggal -->
                                <div class="flex items-center text-sm text-gray-600 mb-5 font-medium">
                                    <svg class="w-4 h-4 mr-2 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y') }}
                                </div>

                                <!-- Data Waktu -->
                                <div class="space-y-3">
                                    <div class="flex items-center text-sm text-gray-800 bg-blue-50/50 p-2 rounded-lg border border-blue-100/50">
                                        <svg class="w-4 h-4 mr-2.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-semibold text-xs text-blue-700/80 mr-auto">BATAS TEPAT WAKTU:</span> 
                                        <span class="font-bold text-blue-900">{{ \Carbon\Carbon::parse($session->on_time_deadline)->format('H:i') }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-800 bg-red-50/50 p-2 rounded-lg border border-red-100/50">
                                        <svg class="w-4 h-4 mr-2.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-semibold text-xs text-red-700/80 mr-auto">JAM TUTUP:</span> 
                                        <span class="font-bold text-red-900">{{ \Carbon\Carbon::parse($session->closed_at)->format('H:i') }}</span>
                                    </div>
                                </div>

                                @if($isExpired)
                                    <p class="text-xs text-red-500 mt-4 font-medium flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Sesi otomatis berakhir
                                    </p>
                                @endif
                            </div>

                            <!-- Bagian Aksi -->
                            <div class="mt-auto">
                                <hr class="border-gray-100 mb-4 mt-2">
                                <div class="flex justify-between items-center">
                                    
                                    @php
                                        // Condition for toggle to be disabled: Either time is up, or it was manually closed.
                                        $isDisabled = $isExpired || !$session->is_open;
                                    @endphp

                                    <!-- Toggle Switch -->
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-semibold text-gray-700">Status Sesi</span>
                                        <button 
                                            type="button" 
                                            @click="{{ !$isDisabled ? 'showModal = true' : '' }}"
                                            class="{{ $isActive ? 'bg-brand-primary cursor-pointer hover:opacity-90' : 'bg-gray-200 opacity-50 cursor-not-allowed' }} relative inline-flex h-6 w-11 flex-shrink-0 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-brand-primary focus:ring-offset-2 rounded-full border-2"
                                            {{ $isDisabled ? 'disabled' : '' }}
                                        >
                                            <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $isActive ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                        </button>
                                    </div>

                                    <!-- Ikon Navigasi (Mata) -->
                                    <a href="{{ route('attendance.validate.show', $session->id) }}" class="p-2 text-gray-500 hover:text-brand-primary hover:bg-teal-50 bg-gray-50 border border-gray-200 transition-all rounded-lg" title="Lihat/Validasi Sesi">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Modal Konfirmasi Alpine.js -->
                            <div x-cloak x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <!-- Background overlay -->
                                    <div x-show="showModal" 
                                         x-transition:enter="ease-out duration-300" 
                                         x-transition:enter-start="opacity-0" 
                                         x-transition:enter-end="opacity-100" 
                                         x-transition:leave="ease-in duration-200" 
                                         x-transition:leave-start="opacity-100" 
                                         x-transition:leave-end="opacity-0" 
                                         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" 
                                         @click="showModal = false" aria-hidden="true"></div>

                                    <!-- Center modal trigger -->
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                    <!-- Modal panel -->
                                    <div x-show="showModal" 
                                         x-transition:enter="ease-out duration-300" 
                                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                                         x-transition:leave="ease-in duration-200" 
                                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                         class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full {{ $isActive ? 'bg-red-50 text-red-600' : 'bg-teal-50 text-brand-primary' }} sm:mx-0 sm:h-10 sm:w-10">
                                                    @if($isActive)
                                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                    <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                                        Konfirmasi Ubah Status
                                                    </h3>
                                                    <div class="mt-2 text-sm text-gray-500">
                                                        @if($isActive)
                                                            <p>Apakah Anda yakin ingin <strong class="text-red-600">menutup</strong> sesi presensi ini secara manual? Peserta tidak akan bisa absen lagi setelah sesi ditutup.</p>
                                                        @else
                                                            <p>Apakah Anda yakin ingin <strong class="text-brand-primary">membuka kembali</strong> sesi presensi ini?</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            @if($isActive)
                                                <form method="POST" action="{{ route('attendance-sessions.close', $session->id) }}" class="inline-block w-full sm:w-auto">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                                        Ya, Tutup Sesi
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('attendance-sessions.update', $session->id) }}" class="inline-block w-full sm:w-auto">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="session_date" value="{{ $session->session_date }}">
                                                    <input type="hidden" name="on_time_deadline" value="{{ \Carbon\Carbon::parse($session->on_time_deadline)->format('H:i') }}">
                                                    <input type="hidden" name="closed_at" value="{{ \Carbon\Carbon::parse($session->closed_at)->format('H:i') }}">
                                                    <input type="hidden" name="is_open" value="1">
                                                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-brand-primary text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                                        Ya, Buka Sesi
                                                    </button>
                                                </form>
                                            @endif
                                            <button @click="showModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 flex flex-col items-center justify-center text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                            <div class="w-16 h-16 mb-4 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-100">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <p class="text-xl font-bold text-gray-700">Belum ada sesi presensi</p>
                            <p class="text-sm mt-2 text-gray-500">Silakan buka sesi baru untuk mulai mencatat presensi harian.</p>
                            <a href="{{ route('attendance-sessions.create') }}" class="mt-5 px-5 py-2.5 bg-brand-primary text-white text-sm font-bold rounded-lg hover:bg-teal-700 transition shadow-sm">
                                + Buat Sesi Pertama
                            </a>
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-6">
                    {{ $attendanceSessions->links() }}
                </div>
            @else
                <div class="py-16 flex flex-col items-center justify-center text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    <div class="w-16 h-16 mb-4 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-100">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <p class="text-xl font-bold text-gray-700">Belum ada sesi presensi</p>
                    <p class="text-sm mt-2 text-gray-500">Silakan buka sesi baru untuk mulai mencatat presensi harian.</p>
                    <a href="{{ route('attendance-sessions.create') }}" class="mt-5 px-5 py-2.5 bg-brand-primary text-white text-sm font-bold rounded-lg hover:bg-teal-700 transition shadow-sm">
                        + Buat Sesi Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Prevent Alpine template flash */
    [x-cloak] { display: none !important; }
</style>
@endsection
