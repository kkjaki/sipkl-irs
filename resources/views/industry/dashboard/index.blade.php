@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <main class="w-full overflow-x-hidden h-auto bg-brand-bg px-4 sm:px-6 lg:px-8 py-6">
        {{-- Header --}}
        <header>
            <div class="w-full pb-4">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </div>
        </header>

        <div class="w-full mx-auto">
            <div class="overflow-hidden">
                <div class="text-gray-900 dark:text-gray-100">

                    {{-- Profil Siswa --}}
                    <div class="w-full bg-white rounded-xl shadow-sm border border-gray-100 px-0 py-0 mb-6">
                        <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white px-6 py-4 font-semibold text-lg rounded-t-xl">
                            Profil Industri
                        </div>
                        <div class="p-6 overflow-x-auto">
                            <div class="space-y-0 sm:space-y-2">
                                <div class="flex flex-col sm:flex-row border-b py-3 border-gray-100">
                                    <span class="w-full sm:w-40 font-medium text-gray-700 mb-1 sm:mb-0">Nama Industri</span>
                                    <span class="hidden sm:inline mx-2">:</span>
                                    <span class="flex-1 text-gray-900 break-words whitespace-normal">{{ $industry->name ?? 'Belum Diatur' }}</span>
                                </div>
                                <div class="flex flex-col sm:flex-row border-b py-3 border-gray-100">
                                    <span class="w-full sm:w-40 font-medium text-gray-700 mb-1 sm:mb-0">Alamat Industri</span>
                                    <span class="hidden sm:inline mx-2">:</span>
                                    <span class="flex-1 text-gray-900 break-words whitespace-normal">{{ $industry->address ?? '-' }}</span>
                                </div>
                                <div class="flex flex-col sm:flex-row border-b py-3 border-gray-100">
                                    <span class="w-full sm:w-40 font-medium text-gray-700 mb-1 sm:mb-0">Kontak Industri</span>
                                    <span class="hidden sm:inline mx-2">:</span>
                                    <span class="flex-1 text-gray-900 break-words whitespace-normal">{{ $industry->phone ?? '-' }}</span>
                                </div>
                                <div class="flex flex-col sm:flex-row border-b py-3 border-gray-100">
                                    <span class="w-full sm:w-40 font-medium text-gray-700 mb-1 sm:mb-0">Pemilik Industri</span>
                                    <span class="hidden sm:inline mx-2">:</span>
                                    <span class="flex-1 text-gray-900 break-words whitespace-normal">{{ $industry->user->name ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Dashboard Content --}}
                    <div class="py-0">
                        <div class="w-full">

                            {{-- Cards --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6 mt-4">

                                {{-- Card Jumlah Siswa --}}
                                <div class="bg-white p-6 sm:px-6 sm:py-8 h-auto md:min-h-[120px] rounded-xl border border-gray-100 shadow-sm flex items-center justify-between transition-all hover:shadow-md">
                                    <div>
                                        <div class="text-base font-bold text-gray-500 uppercase tracking-tight">Jumlah Siswa</div>
                                        <div class="text-2xl sm:text-4xl font-black text-teal-600 mt-1">{{ $jumlahSiswa ?? 0 }}</div>
                                    </div>
                                    <x-heroicon-s-user-group class="text-teal-500 opacity-20 w-10 h-10 sm:w-14 sm:h-14 shrink-0" />
                                </div>

                                {{-- Card Jumlah Sekolah --}}
                                <div class="bg-white p-6 sm:px-6 sm:py-8 h-auto md:min-h-[120px] rounded-xl border border-gray-100 shadow-sm flex items-center justify-between transition-all hover:shadow-md">
                                    <div>
                                        <div class="text-base font-bold text-gray-500 uppercase tracking-tight">Jumlah Sekolah</div>
                                        <div class="text-2xl sm:text-4xl font-black text-teal-600 mt-1">{{ $jumlahSekolah ?? 0 }}</div>
                                    </div>
                                    <i class="fas fa-school text-teal-500 opacity-20 w-10 h-10 sm:w-14 sm:h-14 shrink-0 text-4xl sm:text-5xl flex items-center justify-center"></i>
                                </div>

                                {{-- Card Pendamping Industri --}}
                                <div class="bg-white p-6 sm:px-6 sm:py-8 h-auto md:min-h-[120px] rounded-xl border border-gray-100 shadow-sm flex items-center justify-between transition-all hover:shadow-md">
                                    <div>
                                        <div class="text-base font-bold text-gray-500 uppercase tracking-tight">Pendamping Industri</div>
                                        <div class="text-2xl sm:text-4xl font-black text-teal-600 mt-1">{{ $jumlahMentor ?? 0 }}</div>
                                    </div>
                                    <i class="fas fa-user-tie text-teal-500 opacity-20 w-10 h-10 sm:w-14 sm:h-14 shrink-0 text-4xl sm:text-5xl flex items-center justify-center"></i>
                                </div>

                                {{-- Card Guru Pembimbing --}}
                                <div class="bg-white p-6 sm:px-6 sm:py-8 h-auto md:min-h-[120px] rounded-xl border border-gray-100 shadow-sm flex items-center justify-between transition-all hover:shadow-md">
                                    <div>
                                        <div class="text-base font-bold text-gray-500 uppercase tracking-tight">Guru Pembimbing</div>
                                        <div class="text-2xl sm:text-4xl font-black text-teal-600 mt-1">{{ $jumlahGuru ?? 0 }}</div>
                                    </div>
                                    <i class="fas fa-user-graduate text-teal-500 opacity-20 w-10 h-10 sm:w-14 sm:h-14 shrink-0 text-4xl sm:text-5xl flex items-center justify-center"></i>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection