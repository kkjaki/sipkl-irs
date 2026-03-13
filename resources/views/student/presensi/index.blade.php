@extends('layouts.student')

@section('header')
Daftar Kehadiran
@endsection

@section('content')

<div class="bg-white shadow-md rounded-xl overflow-hidden relative">

    {{-- HEADER --}}
    <div class="bg-teal-400 text-white px-6 py-4 flex justify-between items-center">

        <h3 class="font-semibold text-lg">
            Daftar Hadir
        </h3>

        <button id="filterBtn"
            class="flex items-center gap-2 border border-white px-4 py-1 rounded hover:bg-white hover:text-teal-500 transition">

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
                Izin/Sakit
            </button>

            <button class="filter-pill px-3 py-1 text-xs rounded-full bg-gray-200"
                data-filter="tidak">
                Tidak Hadir
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

        @php
            $status = ['terlambat','hadir','izin','tidak','hadir','hadir'];
        @endphp

        @foreach($status as $item)

        <div class="kehadiran-card border rounded-lg p-4 flex flex-col justify-between"
            data-status="{{ $item }}">

            <div class="flex justify-between items-start mb-3">

                <div>
                    <p class="font-semibold text-gray-800">
                        Jumat, 27-06-2025
                    </p>

                    <p class="text-sm text-gray-500">
                        08.20
                    </p>
                </div>

                {{-- STATUS --}}
                @if($item == 'hadir')
                    <span class="bg-green-200 text-green-700 text-xs px-3 py-1 rounded-full">
                        Hadir
                    </span>

                @elseif($item == 'terlambat')
                    <span class="bg-yellow-200 text-yellow-700 text-xs px-3 py-1 rounded-full">
                        Terlambat
                    </span>

                @elseif($item == 'izin')
                    <span class="bg-blue-200 text-blue-700 text-xs px-3 py-1 rounded-full">
                        Izin/Sakit
                    </span>

                @else
                    <span class="bg-red-200 text-red-700 text-xs px-3 py-1 rounded-full">
                        Tidak Hadir
                    </span>
                @endif

            </div>

            <button
                class="inline-flex items-center gap-2 text-sm border px-3 py-1.5 rounded hover:bg-gray-100 transition">

                <i class="fa fa-image"></i>
                Bukti Presensi

            </button>

        </div>

        @endforeach

    </div>

</div>



{{-- ================= FRONTEND LOGIC ================= --}}
<script>

const filterBtn = document.getElementById("filterBtn");
const popup = document.getElementById("filterPopup");
const closeBtn = document.getElementById("closeFilter");
const pills = document.querySelectorAll(".filter-pill");
const cards = document.querySelectorAll(".kehadiran-card");

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

    cards.forEach(card => {
        card.style.display = "block";
    });

});

</script>

@endsection