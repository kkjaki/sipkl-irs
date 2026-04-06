@extends('layouts.app')
@section('title', 'Buat Sesi Presensi')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.tailwindcss.com"></script>

<main class="min-h-screen bg-[#f8fafc] px-10 pb-10 w-full font-sans">
    <article class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 flex flex-col mb-8">
        <section class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex items-center text-white font-bold text-lg">
            <x-heroicon-o-clock class="w-6 h-6 mr-2.5 opacity-90" />
            Buat Sesi Presensi
        </section>

        <form action="{{ route('attendance-sessions.store') }}" method="POST" class="p-6 flex flex-col gap-6">
            @csrf
            
            <div class="flex items-center gap-4">
                <label for="time-picker-1" class="w-40 text-gray-700 font-medium text-lg shrink-0">Batas Tepat Waktu</label>
                <input 
                    type="text" 
                    name="on_time_deadline" 
                    id="time-picker-1"
                    placeholder="Klik untuk pilih jam"
                    readonly
                    class="time-picker flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent cursor-pointer bg-white"
                >
            </div>

            <div class="flex items-center gap-4">
                <label for="time-picker-2" class="w-40 text-gray-700 font-medium text-lg shrink-0">Jam Tutup Sesi</label>
                <input 
                    type="text" 
                    name="closed_at" 
                    id="time-picker-2"
                    placeholder="Klik untuk pilih jam"
                    readonly
                    class="time-picker flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent cursor-pointer bg-white"
                >
            </div>

            <div class="flex justify-start gap-3 mt-4">
                <button type="submit"
                    class="bg-teal-500 hover:bg-teal-600 text-white px-5 py-2 rounded-md font-medium text-lg">
                    Buat Sesi
                </button>
                <a href="{{ route('attendance-sessions.index') }}"
                    class="bg-white border border-gray-300 text-gray-600 hover:bg-gray-50 px-5 py-2 rounded-md font-medium text-lg">
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