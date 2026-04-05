@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.tailwindcss.com"></script>

<main class="min-h-screen bg-[#f8fafc] px-10 pb-10 w-full font-sans">
    <header>
        <div class="py-8">
            <h2 class="font-black text-3xl text-gray-800 leading-tight">
                {{ __('Buat Sesi Presensi') }}
            </h2>
        </div>
    </header>

    <article class="w-full max-w-4xl bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        {{-- Header Card Teal --}}
        <div class="bg-gradient-to-r from-teal-400 to-teal-500 px-8 py-6">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/20 rounded-lg">
                    <x-heroicon-o-clock class="w-6 h-6 text-white" />
                </div>
                <h3 class="text-white font-bold text-xl m-0">Konfigurasi Waktu Sesi</h3>
            </div>
        </div>

        <form action="{{ route('attendance-sessions.store') }}" method="POST" class="p-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                {{-- Field 1 --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block ml-1">
                        Batas Tepat Waktu
                    </label>
                    <div class="group">
                        <input 
                            type="text" 
                            name="on_time_deadline" 
                            id="time-picker-1"
                            placeholder="Klik untuk pilih jam"
                            readonly
                            class="time-picker block w-full px-5 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50 text-gray-900 font-bold focus:bg-white focus:border-teal-400 focus:ring-4 focus:ring-teal-50 transition-all outline-none cursor-pointer shadow-sm"
                        >
                    </div>
                </div>

                {{-- Field 2 --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block ml-1">
                        Jam Tutup Sesi
                    </label>
                    <div class="group">
                        <input 
                            type="text" 
                            name="closed_at" 
                            id="time-picker-2"
                            placeholder="Klik untuk pilih jam"
                            readonly
                            class="time-picker block w-full px-5 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50 text-gray-900 font-bold focus:bg-white focus:border-teal-400 focus:ring-4 focus:ring-teal-50 transition-all outline-none cursor-pointer shadow-sm"
                        >
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-12 pt-8 border-t border-gray-50 flex items-center gap-4">
                <button type="submit" 
                    class="px-10 py-4 bg-teal-500 hover:bg-teal-600 text-white font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-teal-100 transition-all active:scale-95 text-sm flex items-center gap-2">
                    <span>Buka Sesi Sekarang</span>
                </button>
                
                <a href="{{ route('attendance-sessions.index') }}" 
                    class="px-10 py-4 bg-white border-2 border-gray-100 text-gray-400 font-black uppercase tracking-widest rounded-2xl hover:bg-gray-50 hover:text-gray-600 transition-all text-sm">
                    Batal
                </a>
            </div>
        </form>
    </article>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".time-picker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            disableMobile: "true" // Pakai picker custom di HP juga
        });
    });
</script>

<style>
    /* Styling khusus agar picker Flatpickr rapi */
    .flatpickr-calendar {
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1) !important;
        padding: 15px !important;
        margin-top: 10px !important;
    }
    .flatpickr-time input { font-weight: 800 !important; }
</style>
@endsection