@extends('layouts.app')
@section('title', 'Buat Sesi Presensi')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.tailwindcss.com"></script>

<main class="min-h-screen bg-[#f8fafc] px-10 pb-10 w-full font-sans">
    <article class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 flex flex-col mb-8 relative">
        <section class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex items-center text-white font-bold text-lg">
            <x-heroicon-o-clock class="w-6 h-6 mr-2.5 opacity-90" />
            Buat Sesi Presensi
        </section>

        <div class="p-6">
            {{-- ALERT CUSTOM (Tersembunyi secara default) --}}
            <div id="errorAlert" class="hidden mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-sm transition-all duration-300">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-rose-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-rose-700 font-bold text-sm">Batas tepat waktu dan jam tutup sesi wajib diisi!.</p>
                </div>
            </div>

            {{-- Tambahin ID "sessionForm" di form lo --}}
            <form id="sessionForm" action="{{ route('attendance-sessions.store') }}" method="POST" class="flex flex-col gap-6">
                @csrf
                
                <div class="flex items-center gap-4">
                    <label for="time-picker-1" class="w-40 text-gray-700 font-medium text-lg shrink-0">Batas Tepat Waktu</label>
                    <input 
                        type="text" 
                        name="on_time_deadline" 
                        id="time-picker-1"
                        placeholder="Klik untuk pilih jam"
                        readonly
                        class="time-picker flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent cursor-pointer bg-white transition-all"
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
                        class="time-picker flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent cursor-pointer bg-white transition-all"
                    >
                </div>

                <div class="flex justify-start gap-3 mt-4">
                    <button type="submit"
                        class="bg-teal-500 hover:bg-teal-600 active:scale-95 transition-all text-white px-5 py-2 rounded-md font-medium text-lg">
                        Buat Sesi
                    </button>
                    <a href="{{ route('attendance-sessions.index') }}"
                        class="bg-white border border-gray-300 text-gray-600 hover:bg-gray-50 px-5 py-2 rounded-md font-medium text-lg transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </article>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Flatpickr
        flatpickr(".time-picker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            disableMobile: "true" 
        });

        // Validasi Submit Form
        document.getElementById('sessionForm').addEventListener('submit', function(e) {
            const time1 = document.getElementById('time-picker-1').value;
            const time2 = document.getElementById('time-picker-2').value;
            const alertBox = document.getElementById('errorAlert');

            // Cek kalau ada yang kosong
            if (!time1 || !time2) {
                e.preventDefault(); // Cegah form dikirim ke server

                // Tampilkan alert box
                alertBox.classList.remove('hidden');
                
                // Tambahkan efek getar ke input biar mentor ngeh
                if(!time1) document.getElementById('time-picker-1').classList.add('border-rose-500', 'ring-2', 'ring-rose-200');
                if(!time2) document.getElementById('time-picker-2').classList.add('border-rose-500', 'ring-2', 'ring-rose-200');

                // Otomatis hilangkan alert setelah 4 detik
                setTimeout(() => {
                    alertBox.classList.add('hidden');
                    document.getElementById('time-picker-1').classList.remove('border-rose-500', 'ring-2', 'ring-rose-200');
                    document.getElementById('time-picker-2').classList.remove('border-rose-500', 'ring-2', 'ring-rose-200');
                }, 4000);
            }
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