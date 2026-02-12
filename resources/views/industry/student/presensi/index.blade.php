@extends('layouts.student')

@section('header')
Daftar Kehadiran
@endsection

@section('content')

{{-- Container Daftar Hadir --}}
<div class="bg-white shadow rounded-lg p-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        @for ($i = 1; $i <= 8; $i++)
            <div class="border rounded-lg p-4 flex flex-col justify-between">

                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="font-semibold text-gray-800">
                            Jumat, 27-06-2025
                        </p>
                        <p class="text-sm text-gray-500">
                            08.20
                        </p>
                    </div>

                    <span class="bg-gray-200 text-gray-700 text-xs px-3 py-1 rounded-full">
                        Terlambat
                    </span>
                </div>

                <div>
                    <button
                        class="inline-flex items-center gap-2 text-sm border px-3 py-1.5 rounded hover:bg-gray-100 transition">
                        Bukti Presensi
                    </button>
                </div>

            </div>
        @endfor

    </div>
</div>

@endsection
