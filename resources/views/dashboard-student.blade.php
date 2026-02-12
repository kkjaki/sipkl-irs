@extends('layouts.student')

@section('header')
Dashboard
@endsection

@section('content')

{{-- PROFIL SISWA --}}
<div class="bg-white shadow rounded p-4 mb-6">
    <h3 class="font-semibold mb-3">Profil Siswa</h3>
    <table class="text-sm w-full">
        <tr><td>Nama</td><td>: John Doe</td></tr>
        <tr><td>Kelas</td><td>: XII RPL 2</td></tr>
        <tr><td>Guru Pembimbing</td><td>: Lorem Ipsum, S.Pd</td></tr>
        <tr><td>Sekolah</td><td>: SMK IT Informatika AL-GPT</td></tr>
    </table>
</div>

{{-- RINGKASAN PRESENSI --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white shadow p-4 rounded">Jumlah Hadir<br><b>1</b></div>
    <div class="bg-white shadow p-4 rounded">Izin / Sakit<br><b>1</b></div>
    <div class="bg-white shadow p-4 rounded">Terlambat<br><b>1</b></div>
    <div class="bg-white shadow p-4 rounded">Tidak Hadir<br><b>1</b></div>
</div>

{{-- LOGBOOK --}}
<div class="bg-white shadow rounded p-4">
    <h3 class="font-semibold mb-3">Daftar Logbook</h3>
    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th>No</th>
                <th>Hari, Tanggal</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-t">
                <td>1</td>
                <td>Jumat, 27-06-2025</td>
                <td>Lorem ipsum dolor sit amet...</td>
                <td>
                    <a href="#" class="text-blue-600">Lihat Selengkapnya</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
