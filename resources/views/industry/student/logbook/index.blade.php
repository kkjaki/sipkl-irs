@extends('layouts.student')

@section('header')
Daftar Logbook
@endsection

@section('content')

<div class="bg-white shadow rounded-lg p-6">

    <div class="space-y-6">

        @for ($i = 1; $i <= 6; $i++)
            <div class="border rounded-lg p-5 shadow-sm hover:shadow-md transition">

                {{-- Header --}}
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="font-semibold text-gray-800">
                            Jumat, 27-06-2025
                        </p>
                    </div>

                    <span class="bg-gray-200 text-gray-700 text-xs px-3 py-1 rounded-full">
                        Disetujui
                    </span>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700 mb-1">
                        Deskripsi Kegiatan:
                    </p>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </p>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="flex gap-3">

                    {{-- EDIT --}}
                    <a href="{{ route('student.logbook.edit', $i) }}"
                       class="inline-flex items-center gap-2 text-sm border px-3 py-1.5 rounded hover:bg-gray-100 transition">
                        Edit
                    </a>

                    {{-- HAPUS --}}
                    <form action="{{ route('student.logbook.destroy', $i) }}" 
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 text-sm border px-3 py-1.5 rounded text-red-600 hover:bg-red-100 transition">
                            Hapus
                        </button>
                    </form>

                    {{-- LIHAT --}}
                    <a href="{{ route('student.logbook.show', $i) }}"
                       class="inline-flex items-center gap-2 text-sm border px-3 py-1.5 rounded hover:bg-gray-100 transition">
                        Lihat
                    </a>

                </div>

            </div>
        @endfor

    </div>

</div>

@endsection
