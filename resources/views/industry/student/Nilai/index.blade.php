@extends('layouts.student')

@section('header')
Nilai
@endsection

@section('content')

<div class="bg-white shadow rounded-lg p-6">

    {{-- Button Cetak --}}
    <div class="mb-4">
        <button onclick="window.print()"
            class="px-4 py-2 border rounded hover:bg-gray-100 text-sm">
            CETAK
        </button>
    </div>

    {{-- Profil Siswa --}}
    <div class="border rounded mb-6">
        <div class="bg-gray-100 px-4 py-2 font-semibold">
            Profil Siswa
        </div>

        <div class="p-4 text-sm space-y-2">
            <div><strong>NIS :</strong> 76521</div>
            <div><strong>Nama :</strong> John Doe</div>
            <div><strong>Kelas :</strong> 12 RPL 2</div>
            <div><strong>Guru Pembimbing :</strong> Lorem Ipsum, S.Pd.</div>
            <div><strong>Sekolah :</strong> SMK IT (Informatika) AL-GPT</div>
        </div>
    </div>

    {{-- Daftar Nilai --}}
    <div class="border rounded">
        <div class="bg-gray-100 px-4 py-2 font-semibold">
            Daftar Nilai
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="border px-4 py-2 text-left">No</th>
                        <th class="border px-4 py-2 text-left">Kriteria</th>
                        <th class="border px-4 py-2 text-center">Skor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border px-4 py-2">1</td>
                        <td class="border px-4 py-2">Kriteria A</td>
                        <td class="border px-4 py-2 text-center">80</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2">2</td>
                        <td class="border px-4 py-2">Kriteria B</td>
                        <td class="border px-4 py-2 text-center">85</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2">3</td>
                        <td class="border px-4 py-2">Kriteria C</td>
                        <td class="border px-4 py-2 text-center">90</td>
                    </tr>

                    <tr class="font-semibold bg-gray-50">
                        <td colspan="2" class="border px-4 py-2 text-right">
                            NILAI AKHIR
                        </td>
                        <td class="border px-4 py-2 text-center">
                            85
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
