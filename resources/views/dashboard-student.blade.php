@extends('layouts.student')

@section('header')
Dashboard
@endsection

@section('content')

{{-- PROFIL SISWA --}}
<div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 animate-card">

    <div class="bg-teal-400 text-white px-4 py-2 font-semibold">
        Profil Siswa
    </div>

    <div class="p-4 overflow-x-auto">

        <table class="w-full text-sm border border-gray-200 min-w-[500px]">

            <tr class="border-b">
                <td class="w-40 px-3 py-2">NIS</td>
                <td class="px-3 py-2">: 76521</td>
            </tr>

            <tr class="border-b">
                <td class="px-3 py-2">Nama</td>
                <td class="px-3 py-2">: John Doe</td>
            </tr>

            <tr class="border-b">
                <td class="px-3 py-2">Kelas</td>
                <td class="px-3 py-2">: XII RPL 2</td>
            </tr>

            <tr class="border-b">
                <td class="px-3 py-2">Guru Pembimbing</td>
                <td class="px-3 py-2">: Lorem Ipsum, S.Pd</td>
            </tr>

            <tr>
                <td class="px-3 py-2">Sekolah</td>
                <td class="px-3 py-2">: SMK IT Informatika AL-GPT</td>
            </tr>

        </table>

    </div>

</div>



{{-- RINGKASAN PRESENSI --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    <div class="stat-card bg-white rounded-lg shadow-md p-4 cursor-pointer transition">

        <p class="text-sm text-gray-600">Jumlah Hadir</p>
        <p class="text-2xl font-semibold mt-1">1</p>

    </div>

    <div class="stat-card bg-white rounded-lg shadow-md p-4 cursor-pointer transition">

        <p class="text-sm text-gray-600">Izin / Sakit</p>
        <p class="text-2xl font-semibold mt-1">1</p>

    </div>

    <div class="stat-card bg-white rounded-lg shadow-md p-4 cursor-pointer transition">

        <p class="text-sm text-gray-600">Terlambat</p>
        <p class="text-2xl font-semibold mt-1">1</p>

    </div>

    <div class="stat-card bg-white rounded-lg shadow-md p-4 cursor-pointer transition">

        <p class="text-sm text-gray-600">Jumlah Tidak Hadir</p>
        <p class="text-2xl font-semibold mt-1">1</p>

    </div>

</div>



{{-- LOGBOOK --}}
<div class="bg-white rounded-xl shadow-md overflow-hidden animate-card">

    <div class="bg-teal-400 text-white px-4 py-2 font-semibold">
        Daftar Logbook
    </div>

    <div class="p-4">

        <div class="border rounded-lg p-4 bg-gray-50 logbook-card">

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-2 gap-2">

                <h4 class="font-semibold text-sm">
                    Jumat, 27-06-2025
                </h4>

                <span class="text-xs bg-green-100 text-green-600 px-3 py-1 rounded-full w-fit">
                    Disetujui
                </span>

            </div>

            <p class="text-sm text-gray-700 mb-3 logbook-desc line-clamp-2">

                <strong>Deskripsi Kegiatan:</strong><br>

                Lorem ipsum dolor sit amet, consectetur adipiscing elit.

            </p>

            <button onclick="toggleLogbook(this)"
                class="inline-flex items-center gap-2 bg-teal-400 text-white text-sm px-3 py-1 rounded hover:bg-teal-500">

                Lihat Selengkapnya
                <i class="fa fa-eye text-xs"></i>

            </button>

        </div>

    </div>

</div>



{{-- FRONTEND LOGIC --}}
<script>

// Hover effect statistik
document.querySelectorAll('.stat-card').forEach(card => {

    card.addEventListener('mouseenter', () => {
        card.classList.add('scale-105');
    });

    card.addEventListener('mouseleave', () => {
        card.classList.remove('scale-105');
    });

    card.addEventListener('click', () => {
        card.classList.toggle('bg-teal-50');
    });

});


// Toggle logbook detail
function toggleLogbook(btn){

    const card = btn.closest('.logbook-card');
    const desc = card.querySelector('.logbook-desc');

    if(desc.classList.contains('line-clamp-2')){
        desc.classList.remove('line-clamp-2');
        btn.innerHTML = 'Sembunyikan <i class="fa fa-eye-slash text-xs"></i>';
    }else{
        desc.classList.add('line-clamp-2');
        btn.innerHTML = 'Lihat Selengkapnya <i class="fa fa-eye text-xs"></i>';
    }

}


// Animasi card saat halaman dimuat
window.addEventListener('load', () => {

    document.querySelectorAll('.animate-card').forEach((el,i)=>{

        el.style.opacity = 0;
        el.style.transform = "translateY(20px)";

        setTimeout(()=>{

            el.style.transition = "all 0.4s ease";
            el.style.opacity = 1;
            el.style.transform = "translateY(0)";

        }, i*150);

    });

});

</script>

@endsection