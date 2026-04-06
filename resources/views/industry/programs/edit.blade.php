@extends('layouts.app')
@section('title', 'Edit Program')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">

        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Edit Program') }}
                </h2>
            </div>
        </header>

        {{-- Profil Siswa --}}
        <article class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 flex flex-col mb-8">
            <section class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex items-center text-white font-bold text-lg">
                <x-heroicon-o-pencil-square class="w-6 h-6 mr-2.5 opacity-90" />
                Edit Program
            </section>
            
            <form method="POST" action="{{ route('internship-programs.update', $internshipProgram->id) }}" class="p-6 flex flex-col gap-6">
                @method('PUT')
                @csrf
                
                {{-- Nama Program --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <label for="nama_program" class="w-full sm:w-40 text-gray-700 font-medium text-lg shrink-0">Nama Program</label>
                    <input type="text" id="nama_program" name="name" value="{{ $internshipProgram->name }}"
                        placeholder="Masukkan nama program" required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                </div>

                {{-- Pilih Mentor --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <label for="mentor_id" class="w-full sm:w-40 text-gray-700 font-medium text-lg shrink-0">Pilih Pendamping</label>
                    <select name="mentor_id" id="mentor_id"
                        class="form-select flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <option value="">-- Pilih Pendamping (Opsional/Wajib) --</option>
                        @foreach ($mentors as $mentor)
                            <option value="{{ $mentor->id }}" {{ $internshipProgram->mentor_id == $mentor->id ? 'selected' : '' }}>{{ $mentor->user->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal Mulai --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <label for="tanggal_mulai" class="w-full sm:w-40 text-gray-700 font-medium text-lg shrink-0">Tanggal Mulai</label>
                    <input type="date" id="tanggal_mulai" name="start_date"
                        value="{{ date('Y-m-d', strtotime($internshipProgram->start_date)) }}" required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                </div>

                {{-- Tanggal Selesai --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <label for="tanggal_selesai" class="w-full sm:w-40 text-gray-700 font-medium text-lg shrink-0">Tanggal Selesai</label>
                    <input type="date" id="tanggal_selesai" name="end_date"
                        value="{{ date('Y-m-d', strtotime($internshipProgram->end_date)) }}" required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                </div>

                {{-- Kode Undangan --}}
                <div class="flex flex-col sm:flex-row sm:items-start gap-2 sm:gap-4">
                    <label for="invitation_code" class="w-full sm:w-40 text-gray-700 font-medium text-lg shrink-0 mt-2">Kode Undangan<br><span
                            class="text-sm font-normal text-gray-500">(Otomatis jika kosong)</span></label>
                    <div class="flex flex-col gap-2 flex-1">
                        <input type="text" id="invitation_code" name="invitation_code" maxlength="10"
                            placeholder="Contoh: IRS2026"
                            value="{{ old('invitation_code', $internshipProgram->invitation_code) }}"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                        <span class="text-sm text-gray-500">Gunakan kode kustom atau biarkan kosong agar sistem membuatkan kode acak (6 karakter).</span>
                    </div>
                </div>

                {{-- Button Grup --}}
                <div class="flex justify-start gap-3 mt-4">
                    <button type="submit"
                        class="bg-teal-500 hover:bg-teal-600 text-white px-5 py-2 rounded-md font-medium text-lg">
                        Simpan
                    </button>
                    <a href="{{ route('internship-programs.index') }}"
                        class="bg-white border border-gray-300 text-gray-600 hover:bg-gray-50 px-5 py-2 rounded-md font-medium text-lg">
                        Batal
                    </a>
                </div>
            </form>
        </article>
    </main>
@endsection
