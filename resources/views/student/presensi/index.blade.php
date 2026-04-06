<x-app-layout>
@section('title', 'Daftar Kehadiran')
    <div class="min-h-screen bg-brand-bg px-10">
        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-extrabold text-3xl text-gray-800 leading-tight">
                    {{ __('Daftar Kehadiran') }}
                </h2>
                <p class="text-gray-600 mt-2">
                    Riwayat presensi Anda
                </p>
            </div>
        </header>

<article class="w-full bg-white rounded-xl shadow-md border border-gray-200 mb-8 flex flex-col overflow-hidden relative">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex justify-between items-center text-white font-bold text-lg rounded-t-xl">

        Daftar Presensi

        <button id="filterBtn"
            class="bg-white hover:bg-teal-50 text-teal-700 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-all flex items-center gap-2">

            <i class="fa fa-sliders"></i>
            Filter

        </button>

    </div>


    {{-- POPUP FILTER --}}
    <div id="filterPopup"
        class="hidden absolute right-6 top-20 bg-white shadow-lg border rounded-lg w-72 p-4 z-20">

        <div class="flex justify-between items-center mb-3">

            <h4 class="font-semibold text-gray-700">
                Filter
            </h4>

            <button id="closeFilter" class="text-gray-400 hover:text-gray-600">
                ✕
            </button>

        </div>

        <p class="text-sm text-gray-500 mb-2">
            Kategori
        </p>

        <div class="flex flex-wrap gap-2 mb-4">

            <button class="filter-pill px-3 py-1 text-xs rounded-full bg-gray-200"
                data-filter="hadir">
                Hadir
            </button>

            <button class="filter-pill px-3 py-1 text-xs rounded-full bg-gray-200"
                data-filter="terlambat">
                Terlambat
            </button>

            <button class="filter-pill px-3 py-1 text-xs rounded-full bg-gray-200"
                data-filter="izin">
                Izin
            </button>

            <button class="filter-pill px-3 py-1 text-xs rounded-full bg-gray-200"
                data-filter="sakit">
                Sakit
            </button>

            <button class="filter-pill px-3 py-1 text-xs rounded-full bg-gray-200"
                data-filter="alpa">
                Alpa
            </button>

        </div>


        <div class="flex justify-between">

            <button id="resetFilter"
                class="text-sm text-gray-500 hover:underline">
                Hapus
            </button>

            <button id="applyFilter"
                class="bg-teal-400 text-white px-3 py-1 rounded text-sm">
                Simpan
            </button>

        </div>

    </div>



    {{-- LIST KEHADIRAN --}}
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

        @forelse($attendances as $attendance)

        <div class="kehadiran-card border rounded-lg p-4 flex flex-col justify-between"
            data-status="{{ $attendance->status }}">

            <div class="flex justify-between items-start mb-3">

                <div>
                    <p class="font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($attendance->check_in)->translatedFormat('l, d-m-Y') }}
                    </p>

                    <p class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}
                    </p>
                </div>

                {{-- STATUS BADGE --}}
                @if($attendance->status === 'hadir')
                    <span class="bg-green-200 text-green-700 text-xs px-3 py-1 rounded-full font-medium">
                        Hadir
                    </span>

                @elseif($attendance->status === 'terlambat')
                    <span class="bg-yellow-200 text-yellow-700 text-xs px-3 py-1 rounded-full font-medium">
                        Terlambat
                    </span>

                @elseif($attendance->status === 'izin')
                    <span class="bg-blue-200 text-blue-700 text-xs px-3 py-1 rounded-full font-medium">
                        Izin
                    </span>

                @elseif($attendance->status === 'sakit')
                    <span class="bg-purple-200 text-purple-700 text-xs px-3 py-1 rounded-full font-medium">
                        Sakit
                    </span>

                @else
                    <span class="bg-red-200 text-red-700 text-xs px-3 py-1 rounded-full font-medium">
                        Alpa
                    </span>
                @endif

            </div>

            {{-- BUKTI PRESENSI --}}
            @if($attendance->image)
                <a href="{{ asset('storage/' . $attendance->image) }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 text-sm border border-teal-400 text-teal-600 px-3 py-1.5 rounded hover:bg-teal-50 transition">
                    <i class="fa fa-image"></i>
                    Lihat Bukti Presensi
                </a>
            @else
                <span class="inline-flex items-center gap-2 text-sm border border-gray-200 text-gray-400 px-3 py-1.5 rounded cursor-not-allowed">
                    <i class="fa fa-image"></i>
                    Tidak Ada Bukti
                </span>
            @endif

        </div>

        @empty

        {{-- EMPTY STATE --}}
        <div class="col-span-1 md:col-span-2 flex flex-col items-center justify-center py-16 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fa fa-calendar-xmark text-3xl text-gray-300"></i>
            </div>
            <p class="text-gray-500 font-medium text-lg">Belum ada data kehadiran</p>
            <p class="text-gray-400 text-sm mt-1">Mulai lakukan presensi harian Anda di halaman Presensi Harian.</p>
        </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    @if($attendances->hasPages())
    <div class="px-6 pb-6 border-t border-gray-100 pt-4">
        {{ $attendances->links() }}
    </div>
    @endif

</article>



{{-- ================= FRONTEND LOGIC ================= --}}
<script>

const filterBtn = document.getElementById("filterBtn");
const popup = document.getElementById("filterPopup");
const closeBtn = document.getElementById("closeFilter");
const pills = document.querySelectorAll(".filter-pill");

let selectedFilter = null;


// buka popup
filterBtn.addEventListener("click", () => {
    popup.classList.toggle("hidden");
});


// close popup
closeBtn.addEventListener("click", () => {
    popup.classList.add("hidden");
});


// pilih kategori
pills.forEach(pill => {

    pill.addEventListener("click", () => {

        pills.forEach(p => p.classList.remove("bg-teal-400","text-white"));
        pill.classList.add("bg-teal-400","text-white");

        selectedFilter = pill.dataset.filter;

    });

});


// apply filter
document.getElementById("applyFilter").addEventListener("click", () => {

    const cards = document.querySelectorAll(".kehadiran-card");

    cards.forEach(card => {

        if(!selectedFilter){
            card.style.display = "block";
        }
        else if(card.dataset.status === selectedFilter){
            card.style.display = "block";
        }
        else{
            card.style.display = "none";
        }

    });

    popup.classList.add("hidden");

});


// reset filter
document.getElementById("resetFilter").addEventListener("click", () => {

    selectedFilter = null;

    pills.forEach(p => p.classList.remove("bg-teal-400","text-white"));

    document.querySelectorAll(".kehadiran-card").forEach(card => {
        card.style.display = "block";
    });

});

</script>

    </div>
</x-app-layout>