@extends('layouts.app')
@section('title', 'Kelola Sesi Presensi')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10 pb-10 w-full">
        {{-- Header Halaman --}}
        <header>
            <div class="py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Kelola Sesi Presensi') }}
                </h2>
            </div>
        </header>

        {{-- Container Utama --}}
        <article class="w-full bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden mb-8">

            {{-- Header Card Teal --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-3 flex justify-between items-center text-white">
                <div class="flex items-center gap-2.5">
                    <x-heroicon-o-clipboard-document-list class="w-6 h-6" />
                    <h2 class="font-bold text-lg m-0 leading-none">Riwayat Sesi Presensi</h2>
                </div>
                <a href="{{ route('attendance-sessions.create') }}"
                    class="bg-white hover:bg-teal-50 text-teal-700 px-4 py-1.5 rounded-lg text-sm font-bold flex items-center gap-2 transition-all shadow-sm">
                    <x-heroicon-o-plus class="w-4 h-4" /> Buka Sesi Baru
                </a>
            </div>

            <div class="p-8">
                @php $today = \Carbon\Carbon::today()->toDateString(); @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($attendanceSessions as $session)
                        @php
                            $isToday = $session->session_date === $today;
                            // Sesi dianggap 'arsip' jika tanggalnya sudah lewat
                            $isArchived = $session->session_date < $today;
                        @endphp

                        <section x-data="{ showStatusModal: false, showDeleteModal: false }"
                            class="bg-white border {{ $isToday ? 'border-teal-100 ring-1 ring-teal-50' : 'border-gray-200 opacity-80' }} rounded-2xl p-6 shadow-sm relative flex flex-col justify-between hover:shadow-md hover:opacity-100 transition-all duration-300 group">

                            {{-- Badge Status --}}
                            <div class="absolute top-6 right-6">
                                @if ($isToday && $session->is_open)
                                    <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 px-3 py-1 rounded-lg text-[10px] font-black tracking-widest border border-green-100 uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Hari Ini
                                    </span>
                                @elseif($isArchived)
                                    <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-500 px-3 py-1 rounded-lg text-[10px] font-black tracking-widest border border-gray-200 uppercase">
                                        Arsip
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-700 px-3 py-1 rounded-lg text-[10px] font-black tracking-widest border border-rose-100 uppercase">
                                        Tutup
                                    </span>
                                @endif
                            </div>

                            <div class="mb-6">
                                <div class="p-3 {{ $isToday ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-400' }} w-fit rounded-xl mb-4 shadow-sm">
                                    <x-heroicon-o-calendar class="w-6 h-6" />
                                </div>
                                <h3 class="font-black text-xl text-gray-800 mb-1 leading-tight">Presensi Harian</h3>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">
                                    {{ \Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y') }}
                                </p>

                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-[10px] bg-blue-50/50 text-blue-700 p-3 rounded-xl border border-blue-100">
                                        <span class="font-black uppercase tracking-widest">Batas Tepat Waktu:</span>
                                        <span class="font-black text-sm">{{ \Carbon\Carbon::parse($session->on_time_deadline)->format('H:i') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-[10px] bg-rose-50/50 text-rose-700 p-3 rounded-xl border border-rose-100">
                                        <span class="font-black uppercase tracking-widest">Jam Tutup Sesi:</span>
                                        <span class="font-black text-sm">{{ \Carbon\Carbon::parse($session->closed_at)->format('H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Action Bar --}}
                            <div class="mt-auto pt-5 border-t border-gray-100 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    {{-- Toggle Status --}}
                                    <button type="button" @click="{{ !$isArchived ? 'showStatusModal = true' : '' }}"
                                        class="{{ $session->is_open ? 'bg-teal-500' : 'bg-gray-300' }} relative inline-flex h-6 w-11 flex-shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $isArchived ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}">
                                        <span class="{{ $session->is_open ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow transition duration-200"></span>
                                    </button>
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</span>
                                </div>

                                <div class="flex items-center gap-1">
                                    {{-- Icon Mata: Lihat Data (Gunakan route show ke AttendanceController) --}}
                                    <a href="{{ route('attendance.validate.show', $session->id) }}"
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                        title="Lihat Detail Presensi">
                                        <x-heroicon-o-eye class="w-5 h-5" />
                                    </a>

                                    {{-- Icon Trash: Hapus Sesi --}}
                                    <button @click="showDeleteModal = true"
                                        class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all"
                                        title="Hapus Sesi">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
                                </div>
                            </div>

                            {{-- MODAL KONFIRMASI STATUS --}}
                            <div x-cloak x-show="showStatusModal" class="fixed inset-0 z-[9999] overflow-y-auto" style="display: none;">
                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showStatusModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"></div>
                                    <div class="bg-white rounded-2xl p-8 w-full max-w-md relative z-[10000] shadow-2xl text-center" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
                                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full {{ $session->is_open ? 'bg-rose-100 text-rose-600' : 'bg-teal-100 text-teal-600' }} mb-6">
                                            <x-heroicon-o-exclamation-triangle class="w-10 h-10" />
                                        </div>
                                        <h3 class="text-xl font-black text-gray-900 mb-2 uppercase tracking-tight">Konfirmasi Sesi</h3>
                                        <p class="text-sm text-gray-500 mb-8 font-medium">Apakah Anda ingin <strong>{{ $session->is_open ? 'MENUTUP' : 'MEMBUKA' }}</strong> sesi presensi ini?</p>
                                        <div class="flex gap-3">
                                            <button @click="showStatusModal = false" class="flex-1 px-4 py-3 text-xs font-black uppercase tracking-widest text-gray-500 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                                            <form method="POST" action="{{ $session->is_open ? route('attendance-sessions.close', $session->id) : route('attendance-sessions.update', $session->id) }}" class="flex-1">
                                                @csrf
                                                @if($session->is_open) @method('PATCH') @else @method('PUT') @endif
                                                {{-- Logic Reopen --}}
                                                @if(!$session->is_open)
                                                    <input type="hidden" name="session_date" value="{{ $session->session_date }}">
                                                    <input type="hidden" name="on_time_deadline" value="{{ \Carbon\Carbon::parse($session->on_time_deadline)->format('H:i') }}">
                                                    <input type="hidden" name="closed_at" value="{{ \Carbon\Carbon::parse($session->closed_at)->format('H:i') }}">
                                                    <input type="hidden" name="is_open" value="1">
                                                @endif
                                                <button type="submit" class="w-full px-4 py-3 text-xs font-black uppercase tracking-widest text-white {{ $session->is_open ? 'bg-rose-600' : 'bg-teal-600' }} rounded-xl shadow-lg transition-all">Konfirmasi</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- MODAL HAPUS --}}
                            <div x-cloak x-show="showDeleteModal" class="fixed inset-0 z-[9999] overflow-y-auto" style="display: none;">
                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showDeleteModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"></div>
                                    <div class="bg-white rounded-2xl p-8 w-full max-w-md relative z-[10000] shadow-2xl text-center" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
                                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-rose-100 text-rose-600 mb-6">
                                            <x-heroicon-o-trash class="w-10 h-10" />
                                        </div>
                                        <h3 class="text-xl font-black text-gray-900 mb-2 uppercase">Hapus Sesi?</h3>
                                        <p class="text-sm text-gray-500 mb-8 leading-relaxed">Menghapus sesi akan menghilangkan seluruh riwayat absen siswa pada hari ini. Tindakan ini tidak dapat dibatalkan.</p>
                                        <div class="flex gap-3">
                                            <button @click="showDeleteModal = false" class="flex-1 px-4 py-3 text-xs font-black uppercase tracking-widest text-gray-500 bg-gray-100 rounded-xl">Batal</button>
                                            <form method="POST" action="{{ route('attendance-sessions.destroy', $session->id) }}" class="flex-1">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="w-full px-4 py-3 text-xs font-black uppercase tracking-widest text-white bg-rose-600 rounded-xl shadow-lg shadow-rose-100 transition-all">Ya, Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section>
                    @empty
                        <div class="col-span-full py-24 text-center bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                             <x-heroicon-o-clock class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                             <p class="text-gray-500 font-black uppercase tracking-widest">Belum ada sesi presensi ditemukan</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-12">
                    {{ $attendanceSessions->links() }}
                </div>
            </div>
        </article>
    </main>

    <style> [x-cloak] { display: none !important; } </style>
@endsection