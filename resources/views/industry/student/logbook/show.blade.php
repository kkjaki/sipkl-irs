@extends('layouts.student')

@section('header')
Daftar Logbook
@endsection

@section('content')

<div class="bg-white shadow rounded-lg p-6">

    {{-- Background Overlay --}}
    <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">

        {{-- Modal Box --}}
        <div class="bg-white w-full max-w-3xl rounded-lg shadow-lg p-8 relative">

            {{-- Close Button --}}
            <a href="{{ route('student.logbook.index') }}"
               class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-lg">
                ✕
            </a>

            {{-- Title --}}
            <h2 class="text-center text-xl font-bold mb-6">
                DETAIL LOGBOOK
            </h2>

            {{-- Content --}}
            <div class="space-y-4 text-sm text-gray-700">

                <div class="grid grid-cols-3 gap-4">
                    <div class="font-semibold">Hari, Tanggal</div>
                    <div class="col-span-2">
                        : Kamis, 26-06-2025
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="font-semibold">Deskripsi Kegiatan</div>
                    <div class="col-span-2">
                        : Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="font-semibold">Nama Pendamping</div>
                    <div class="col-span-2">
                        : Lorem Ipsum, S.Pd.
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="font-semibold">Dokumentasi Kegiatan</div>
                    <div class="col-span-2 flex items-center gap-2">
                        :
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="w-5 h-5 text-gray-600" 
                             fill="none" 
                             viewBox="0 0 24 24" 
                             stroke="currentColor">
                            <path stroke-linecap="round" 
                                  stroke-linejoin="round" 
                                  stroke-width="2" 
                                  d="M7 16V4m0 0L3 8m4-4l4 4m6 8v4m0 0l-4-4m4 4l4-4" />
                        </svg>
                        <a href="#" class="text-blue-600 hover:underline">
                            namafile.jpg
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection
