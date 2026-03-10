@extends('layouts.student')

@section('header')
Daftar Logbook
@endsection

@section('content')

<div class="bg-white shadow-md rounded-xl overflow-hidden relative">

```
{{-- HEADER CARD --}}
<div class="bg-teal-400 text-white px-6 py-4 flex justify-between items-center">

    <h3 class="font-semibold text-lg">Daftar Logbook</h3>

    <div class="flex items-center gap-3">

        {{-- SORT --}}
        <button id="sortBtn" class="hover:opacity-80">
            <i class="fa fa-sort"></i>
        </button>

        {{-- FILTER --}}
        <button id="filterBtn"
            class="flex items-center gap-2 border border-white px-4 py-1 rounded hover:bg-white hover:text-teal-500 transition">
            <i class="fa fa-sliders"></i>
            Filter
        </button>

    </div>

</div>


{{-- FILTER POPUP --}}
<div id="filterPopup"
    class="hidden absolute right-6 top-20 bg-white shadow-lg border rounded-lg w-64 p-4 z-20">

    <div class="flex justify-between items-center mb-3">
        <h4 class="font-semibold text-gray-700">Filter</h4>
        <button id="closeFilter" class="text-gray-400 hover:text-gray-600">✕</button>
    </div>

    <p class="text-sm text-gray-500 mb-2">Status</p>

    <div class="flex flex-wrap gap-2 mb-4">

        <button class="filter-pill px-3 py-1 text-xs rounded-full bg-gray-200" data-filter="disetujui">
            Disetujui
        </button>

        <button class="filter-pill px-3 py-1 text-xs rounded-full bg-gray-200" data-filter="revisi">
            Revisi
        </button>

        <button class="filter-pill px-3 py-1 text-xs rounded-full bg-gray-200" data-filter="pending">
            Pending
        </button>

    </div>

    <div class="flex justify-between">
        <button id="resetFilter" class="text-sm text-gray-500 hover:underline">Hapus</button>
        <button id="applyFilter" class="bg-teal-400 text-white px-3 py-1 rounded text-sm">Simpan</button>
    </div>

</div>



{{-- LIST LOGBOOK --}}
<div id="logbookList" class="p-6 space-y-6">

    @php
        $data = [
            [
                'status'=>'disetujui',
                'tanggal'=>'Jumat, 27-06-2025',
                'desc'=>'Lorem ipsum dolor sit amet',
                'pendamping'=>'Pak Budi',
                'file'=>'namafile.jpg'
            ],
            [
                'status'=>'revisi',
                'tanggal'=>'Sabtu, 28-06-2025',
                'desc'=>'Sed do eiusmod tempor incididunt',
                'pendamping'=>'Bu Sari',
                'file'=>'foto.jpg'
            ],
            [
                'status'=>'pending',
                'tanggal'=>'Minggu, 29-06-2025',
                'desc'=>'Ut enim ad minim veniam',
                'pendamping'=>'Pak Andi',
                'file'=>'dokumen.pdf'
            ]
        ];
    @endphp

    @foreach ($data as $item)

    <div class="logbook-card border rounded-lg p-5 shadow-sm"
        data-status="{{ $item['status'] }}"
        data-tanggal="{{ $item['tanggal'] }}"
        data-desc="{{ $item['desc'] }}"
        data-pendamping="{{ $item['pendamping'] }}"
        data-file="{{ $item['file'] }}">

        {{-- HEADER --}}
        <div class="flex justify-between items-start mb-3">

            <p class="font-semibold text-gray-800">
                {{ $item['tanggal'] }}
            </p>

            @if($item['status']=='disetujui')
                <span class="statusBadge bg-green-200 text-green-700 text-xs px-3 py-1 rounded-full">
                    Disetujui
                </span>

            @elseif($item['status']=='revisi')
                <span class="statusBadge bg-yellow-200 text-yellow-700 text-xs px-3 py-1 rounded-full">
                    Revisi
                </span>

            @else
                <span class="statusBadge bg-blue-200 text-blue-700 text-xs px-3 py-1 rounded-full">
                    Pending
                </span>
            @endif

        </div>


        {{-- DESKRIPSI --}}
        <div class="mb-4">

            <p class="text-sm font-medium text-gray-700 mb-1">
                Deskripsi Kegiatan:
            </p>

            <p class="text-sm text-gray-600 leading-relaxed">
                {{ $item['desc'] }}
            </p>

        </div>


        {{-- ACTION --}}
        <div class="flex gap-3">

            {{-- EDIT --}}
            <a href="{{ route('student.logbook.edit', $loop->iteration) }}"
                class="flex items-center gap-2 bg-blue-500 text-white px-4 py-1.5 rounded text-sm hover:bg-blue-600 transition">
                <i class="fa fa-edit"></i> Edit
            </a>

            {{-- DELETE --}}
            <button
                class="deleteBtn flex items-center gap-2 bg-red-500 text-white px-4 py-1.5 rounded text-sm hover:bg-red-600 transition">
                <i class="fa fa-trash"></i> Hapus
            </button>

            {{-- VIEW --}}
            <button
                class="viewBtn flex items-center gap-2 bg-yellow-400 text-white px-4 py-1.5 rounded text-sm hover:bg-yellow-500 transition">
                <i class="fa fa-eye"></i> Lihat
            </button>

        </div>

    </div>

    @endforeach

</div>
```

</div>

{{-- ================= MODAL DETAIL ================= --}}

<div id="detailModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

<div class="bg-white w-[720px] rounded-xl p-10 relative shadow-lg">

    {{-- tombol close --}}
    <button id="closeModal" class="absolute right-6 top-5 text-2xl text-gray-600 hover:text-black">
        ✕
    </button>

    {{-- title --}}
    <h2 class="text-center text-xl font-bold mb-10 tracking-wide">
        DETAIL LOGBOOK
    </h2>


    {{-- content --}}
    <div class="grid grid-cols-[180px_1fr] gap-y-6 text-sm text-gray-700">

        {{-- tanggal --}}
        <div class="font-medium">Hari, Tanggal:</div>
        <div id="modalTanggal">Kamis, 26-06-2025</div>


        {{-- deskripsi --}}
        <div class="font-medium">Deskripsi Kegiatan:</div>
        <div id="modalDesc" class="leading-relaxed">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </div>


        {{-- pendamping --}}
        <div class="font-medium">Nama Pendamping:</div>
        <div id="modalPendamping">
            Lorem Ipsum, S.Pd.
        </div>


        {{-- dokumentasi --}}
        <div class="font-medium">Dokumentasi Kegiatan:</div>
        <div class="flex items-center gap-3">

            <i class="fa-solid fa-file text-gray-600"></i>

            <span id="modalFile">
                namafile.jpg
            </span>

        </div>


        {{-- status --}}
        <div class="font-medium">Status:</div>

        <div>
            <select id="modalStatus"
                class="border-2 border-blue-500 bg-yellow-100 text-yellow-700
                    px-6 py-1 rounded-full text-sm font-semibold
                    outline-none appearance-none cursor-pointer">

                <option value="pending">Pending</option>
                <option value="revisi">Revisi</option>
                <option value="disetujui">Disetujui</option>

            </select>
        </div>


        {{-- keterangan --}}
        <div class="font-medium">Keterangan:</div>
        <div id="modalKet" class="leading-relaxed">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </div>

    </div>

</div>
</div>
```

</div>

{{-- ================= FRONTEND LOGIC ================= --}}

<script>

// ================= FILTER =================

const filterBtn = document.getElementById("filterBtn");
const popup = document.getElementById("filterPopup");
const closeFilter = document.getElementById("closeFilter");
const pills = document.querySelectorAll(".filter-pill");
const cards = document.querySelectorAll(".logbook-card");
const resetBtn = document.getElementById("resetFilter");
const applyBtn = document.getElementById("applyFilter");

let selectedFilter = null;


// buka popup
filterBtn.onclick = () => {
    popup.classList.toggle("hidden");
};


// close popup
closeFilter.onclick = () => {
    popup.classList.add("hidden");
};


// pilih filter
pills.forEach(p => {

    p.onclick = () => {

        pills.forEach(x => x.classList.remove("bg-teal-400","text-white"));

        p.classList.add("bg-teal-400","text-white");

        selectedFilter = p.dataset.filter;

    };

});


// apply filter
applyBtn.onclick = () => {

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

};


// reset filter
resetBtn.onclick = () => {

    selectedFilter = null;

    pills.forEach(x => x.classList.remove("bg-teal-400","text-white"));

    cards.forEach(card => card.style.display = "block");

};



// ================= SORT =================

document.getElementById("sortBtn").onclick = () => {

    const list = document.getElementById("logbookList");
    const items = Array.from(list.children);

    items.reverse().forEach(el => list.appendChild(el));

};



// ================= DELETE =================

document.querySelectorAll(".deleteBtn").forEach(btn => {

    btn.onclick = () => {

        if(confirm("Yakin ingin menghapus logbook ini?")){
            btn.closest(".logbook-card").remove();
        }

    };

});



// ================= MODAL DETAIL =================

const modal = document.getElementById("detailModal");
const closeModal = document.getElementById("closeModal");
const cancelModal = document.getElementById("cancelModal");

const tanggal = document.getElementById("modalTanggal");
const desc = document.getElementById("modalDesc");
const pendamping = document.getElementById("modalPendamping");
const file = document.getElementById("modalFile");
const status = document.getElementById("modalStatus");

let activeCard = null;


// buka modal
document.querySelectorAll(".viewBtn").forEach(btn => {

    btn.onclick = () => {

        const card = btn.closest(".logbook-card");

        activeCard = card;

        tanggal.innerText = card.dataset.tanggal;
        desc.innerText = card.dataset.desc;
        pendamping.innerText = card.dataset.pendamping;
        file.innerText = card.dataset.file;
        status.value = card.dataset.status;

        modal.classList.remove("hidden");
        modal.classList.add("flex");

    };

});


// tutup modal
closeModal.onclick = () => modal.classList.add("hidden");

cancelModal.onclick = () => modal.classList.add("hidden");


// klik luar modal
modal.addEventListener("click", e => {

    if(e.target === modal){
        modal.classList.add("hidden");
    }

});



// ================= UPDATE STATUS =================

document.getElementById("saveStatus").onclick = () => {

    if(!activeCard) return;

    const newStatus = status.value;

    activeCard.dataset.status = newStatus;

    const badge = activeCard.querySelector(".statusBadge");

    badge.innerText = newStatus;

    badge.className = "statusBadge text-xs px-3 py-1 rounded-full";

    if(newStatus === "disetujui"){
        badge.classList.add("bg-green-200","text-green-700");
    }
    else if(newStatus === "revisi"){
        badge.classList.add("bg-yellow-200","text-yellow-700");
    }
    else{
        badge.classList.add("bg-blue-200","text-blue-700");
    }

    modal.classList.add("hidden");

};

</script>

@endsection
