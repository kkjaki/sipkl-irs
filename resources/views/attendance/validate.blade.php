@extends('layouts.app')

@section('content')
<main class="min-h-screen bg-brand-bg px-10 py-8 font-sans" x-data="{ showFilter: false, showStatusModal: false, selectedStudent: null, currentStatus: '' }">
    
    {{-- Header & Filter --}}
    <div class="flex justify-between items-center mb-6 relative">
        <h2 class="font-extrabold text-3xl text-gray-800 leading-tight">
            Validasi Presensi
        </h2>
        
        <button @click="showFilter = !showFilter" class="bg-white border border-gray-300 text-gray-700 font-semibold px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 transition flex items-center gap-2">
            <i class="fas fa-filter"></i> Filter
        </button>

        {{-- Dropdown Filter --}}
        <div x-show="showFilter" @click.away="showFilter = false" style="display: none;" class="absolute right-0 top-12 mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-200 z-40 p-4">
            <h3 class="font-bold text-gray-800 mb-3 border-b pb-2">Filter Status</h3>
            <div class="space-y-2 mb-4">
                <label class="flex items-center gap-2 cursor-pointer text-gray-700 hover:bg-gray-50 p-1 rounded">
                    <input type="checkbox" class="form-checkbox text-brand-primary rounded">
                    <span>Hadir</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-gray-700 hover:bg-gray-50 p-1 rounded">
                    <input type="checkbox" class="form-checkbox text-brand-primary rounded">
                    <span>Terlambat</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-gray-700 hover:bg-gray-50 p-1 rounded">
                    <input type="checkbox" class="form-checkbox text-brand-primary rounded">
                    <span>Izin/Sakit</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-gray-700 hover:bg-gray-50 p-1 rounded">
                    <input type="checkbox" class="form-checkbox text-brand-primary rounded">
                    <span>Tidak Hadir</span>
                </label>
            </div>
            <div class="flex justify-between gap-2 border-t pt-3">
                <button @click="showFilter = false" class="text-gray-500 font-semibold text-sm hover:text-gray-700 w-1/2">
                    Hapus
                </button>
                <button @click="showFilter = false" class="bg-brand-primary text-white font-semibold text-sm px-3 py-1.5 rounded-lg w-1/2 hover:bg-teal-600 transition">
                    Simpan
                </button>
            </div>
        </div>
    </div>

    {{-- Grid Card Siswa --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Card 1: Hadir --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <div class="text-sm font-medium text-gray-500 flex flex-col">
                        <span>12 Mar 2026</span>
                        <span class="text-gray-800 font-semibold mt-0.5">07:15 WIB</span>
                    </div>
                    <button @click="showStatusModal = true; selectedStudent = 'Ahmad Budi'; currentStatus = 'Hadir'" class="bg-teal-100 text-teal-600 px-3 py-1 rounded-full text-xs font-bold hover:bg-teal-200 transition">
                        Hadir
                    </button>
                </div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-12 h-12 rounded-full bg-gray-200 border border-gray-300"></div>
                    <div>
                        <h4 class="font-bold text-gray-800">Ahmad Budi</h4>
                        <p class="text-xs text-gray-500">SMK Negeri 1 Jakarta</p>
                    </div>
                </div>
            </div>
            <button class="w-full flex justify-center items-center gap-2 border border-gray-300 text-gray-700 font-semibold py-2 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-camera"></i> Bukti Presensi
            </button>
        </div>

        {{-- Card 2: Terlambat --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <div class="text-sm font-medium text-gray-500 flex flex-col">
                        <span>12 Mar 2026</span>
                        <span class="text-gray-800 font-semibold mt-0.5">08:30 WIB</span>
                    </div>
                    <button @click="showStatusModal = true; selectedStudent = 'Budi Santoso'; currentStatus = 'Terlambat'" class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs font-bold hover:bg-yellow-200 transition">
                        Terlambat
                    </button>
                </div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-12 h-12 rounded-full bg-gray-200 border border-gray-300"></div>
                    <div>
                        <h4 class="font-bold text-gray-800">Budi Santoso</h4>
                        <p class="text-xs text-gray-500">SMK Negeri 2 Bandung</p>
                    </div>
                </div>
            </div>
            <button class="w-full flex justify-center items-center gap-2 border border-gray-300 text-gray-700 font-semibold py-2 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-camera"></i> Bukti Presensi
            </button>
        </div>

        {{-- Card 3: Izin/Sakit --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <div class="text-sm font-medium text-gray-500 flex flex-col">
                        <span>12 Mar 2026</span>
                        <span class="text-gray-800 font-semibold mt-0.5">-</span>
                    </div>
                    <button @click="showStatusModal = true; selectedStudent = 'Citra Dewi'; currentStatus = 'Izin'" class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-bold hover:bg-blue-200 transition">
                        Izin
                    </button>
                </div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-12 h-12 rounded-full bg-gray-200 border border-gray-300"></div>
                    <div>
                        <h4 class="font-bold text-gray-800">Citra Dewi</h4>
                        <p class="text-xs text-gray-500">SMK Telkom Malang</p>
                    </div>
                </div>
            </div>
            <button class="w-full flex justify-center items-center gap-2 border border-gray-300 text-gray-700 font-semibold py-2 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-file-alt"></i> Lihat Surat
            </button>
        </div>

        {{-- Card 4: Tidak Hadir --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <div class="text-sm font-medium text-gray-500 flex flex-col">
                        <span>12 Mar 2026</span>
                        <span class="text-gray-800 font-semibold mt-0.5">-</span>
                    </div>
                    <button @click="showStatusModal = true; selectedStudent = 'Doni Kusuma'; currentStatus = 'Alpa'" class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold hover:bg-red-200 transition">
                        Tidak Hadir
                    </button>
                </div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-12 h-12 rounded-full bg-gray-200 border border-gray-300"></div>
                    <div>
                        <h4 class="font-bold text-gray-800">Doni Kusuma</h4>
                        <p class="text-xs text-gray-500">SMKN 1 Surabaya</p>
                    </div>
                </div>
            </div>
            {{-- Tombol invisible untuk menjaga tinggi card tetap sama persis --}}
            <button class="w-full flex justify-center items-center gap-2 border border-transparent text-transparent font-semibold py-2 rounded-lg invisible cursor-default">
                <i class="fas fa-camera"></i> Bukti Presensi
            </button>
        </div>

    </div>

    {{-- Modal Ubah Status --}}
    <div x-show="showStatusModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="showStatusModal = false" class="bg-white rounded-xl shadow-xl w-full max-w-lg p-7">
            
            <div class="mb-6 border-b pb-4">
                <h3 class="text-2xl font-extrabold text-gray-800 text-center">Ubah Status Presensi</h3>
                <p class="text-center text-gray-500 mt-2">Siswa: <span class="font-bold text-gray-800 text-lg" x-text="selectedStudent"></span></p>
            </div>

            <div class="flex flex-wrap gap-3 justify-center mb-8">
                {{-- Pilihan Status --}}
                <button type="button" @click="currentStatus = 'Hadir'" 
                    :class="currentStatus === 'Hadir' ? 'ring-2 ring-offset-2 ring-teal-500 font-extrabold' : 'hover:opacity-80'" 
                    class="bg-teal-100 text-teal-700 px-5 py-2.5 rounded-full text-sm font-bold transition">
                    Hadir
                </button>
                <button type="button" @click="currentStatus = 'Terlambat'" 
                    :class="currentStatus === 'Terlambat' ? 'ring-2 ring-offset-2 ring-yellow-500 font-extrabold' : 'hover:opacity-80'" 
                    class="bg-yellow-100 text-yellow-700 px-5 py-2.5 rounded-full text-sm font-bold transition">
                    Terlambat
                </button>
                <button type="button" @click="currentStatus = 'Izin'" 
                    :class="currentStatus === 'Izin' ? 'ring-2 ring-offset-2 ring-blue-500 font-extrabold' : 'hover:opacity-80'" 
                    class="bg-blue-100 text-blue-700 px-5 py-2.5 rounded-full text-sm font-bold transition">
                    Izin
                </button>
                <button type="button" @click="currentStatus = 'Sakit'" 
                    :class="currentStatus === 'Sakit' ? 'ring-2 ring-offset-2 ring-sky-500 font-extrabold' : 'hover:opacity-80'" 
                    class="bg-sky-100 text-sky-700 px-5 py-2.5 rounded-full text-sm font-bold transition">
                    Sakit
                </button>
                <button type="button" @click="currentStatus = 'Alpa'" 
                    :class="currentStatus === 'Alpa' ? 'ring-2 ring-offset-2 ring-red-500 font-extrabold' : 'hover:opacity-80'" 
                    class="bg-red-100 text-red-700 px-5 py-2.5 rounded-full text-sm font-bold transition">
                    Alpa
                </button>
            </div>

            <form action="#" method="POST">
                @csrf
                @method('PUT')
                
                {{-- Input Hidden --}}
                <input type="hidden" name="student_id" x-bind:value="selectedStudent">
                <input type="hidden" name="status" x-bind:value="currentStatus">

                <div class="flex justify-end gap-3 pt-5 border-t">
                    <button type="button" @click="showStatusModal = false" class="px-6 py-2.5 rounded-lg font-semibold text-gray-600 border border-gray-300 hover:bg-gray-50 transition flex-1">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-lg font-semibold text-white bg-brand-primary hover:bg-teal-600 transition shadow flex-1">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>

</main>
@endsection
