@extends('layouts.student')

@section('header')
    Nilai
@endsection

@section('content')

<div class="bg-white shadow-lg rounded-xl p-4 md:p-6">

    {{-- ================= BUTTON CETAK ================= --}}
    <div class="mb-5">
        <a href="{{ route('student.nilai.print') }}"
           target="_blank"
           class="inline-flex items-center gap-2 bg-teal-400 text-white px-4 py-2 rounded hover:bg-teal-500 transition text-sm">
            CETAK
            <i class="fa fa-print"></i>
        </a>
    </div>


    {{-- ================= PROFIL SISWA ================= --}}
    <div class="border rounded-lg mb-6 overflow-hidden">

        <div class="bg-teal-400 text-white px-4 py-2 font-semibold text-sm">
            Profil Siswa
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border">
                <tbody>

                    <tr>
                        <td class="border px-3 py-2 w-44">NIS</td>
                        <td class="border px-3 py-2 w-4">:</td>
                        <td class="border px-3 py-2">76521</td>
                    </tr>

                    <tr>
                        <td class="border px-3 py-2">Nama</td>
                        <td class="border px-3 py-2">:</td>
                        <td class="border px-3 py-2">John Doe</td>
                    </tr>

                    <tr>
                        <td class="border px-3 py-2">Kelas</td>
                        <td class="border px-3 py-2">:</td>
                        <td class="border px-3 py-2">XII RPL 2</td>
                    </tr>

                    <tr>
                        <td class="border px-3 py-2">Guru Pembimbing</td>
                        <td class="border px-3 py-2">:</td>
                        <td class="border px-3 py-2">Lorem Ipsum, S.Pd.</td>
                    </tr>

                    <tr>
                        <td class="border px-3 py-2">Sekolah</td>
                        <td class="border px-3 py-2">:</td>
                        <td class="border px-3 py-2">SMK IT Informatika AL-GPT</td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>


    {{-- ================= DAFTAR NILAI ================= --}}
    <div class="border rounded-lg overflow-hidden">

        <div class="bg-teal-400 text-white px-4 py-2 font-semibold text-sm">
            Daftar Nilai
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2 w-16 text-center">No</th>
                        <th class="border px-3 py-2 text-left">Kriteria</th>
                        <th class="border px-3 py-2 text-center w-24">Skor</th>
                    </tr>
                </thead>

                <tbody id="nilaiTable">

                    <tr>
                        <td class="border px-3 py-2 text-center">1</td>
                        <td class="border px-3 py-2">Kriteria A</td>
                        <td class="border px-3 py-2 text-center score">80</td>
                    </tr>

                    <tr>
                        <td class="border px-3 py-2 text-center">2</td>
                        <td class="border px-3 py-2">Kriteria B</td>
                        <td class="border px-3 py-2 text-center score">85</td>
                    </tr>

                    <tr>
                        <td class="border px-3 py-2 text-center">3</td>
                        <td class="border px-3 py-2">Kriteria C</td>
                        <td class="border px-3 py-2 text-center score">90</td>
                    </tr>

                    {{-- NILAI AKHIR --}}
                    <tr class="bg-gray-50 font-semibold">
                        <td colspan="2" class="border px-3 py-2 text-right">
                            NILAI AKHIR
                        </td>
                        <td id="nilaiAkhir" class="border px-3 py-2 text-center text-teal-600">
                            0
                        </td>
                    </tr>

                </tbody>

            </table>
        </div>

        <p class="text-xs text-gray-500 px-4 py-3">
            * Sesuaikan nilai akhir dengan kategori dan batas KKM (Kriteria Ketuntasan Minimal) untuk tiap sekolah.
        </p>

    </div>

</div>



{{-- ================= FRONTEND LOGIC ================= --}}
<script>

function hitungNilai() {

    const scores = document.querySelectorAll(".score");

    let total = 0;
    let jumlah = 0;

    scores.forEach(el => {

        const nilai = parseFloat(el.innerText);

        if (!isNaN(nilai)) {
            total += nilai;
            jumlah++;
        }

    });

    const rata = jumlah ? Math.round(total / jumlah) : 0;

    document.getElementById("nilaiAkhir").innerText = rata;
}


// Hitung saat halaman dibuka
window.addEventListener("load", hitungNilai);

</script>

@endsection