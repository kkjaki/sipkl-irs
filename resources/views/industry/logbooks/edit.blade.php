@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header Tosca -->
        <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-4 text-white">
            <h1 class="text-xl font-bold m-0 leading-none flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Detail Logbook
            </h1>
        </div>
        
        <form action="{{ route('industry.logbooks.validate', $logbook->id) }}" method="POST" class="p-6">
            @csrf
            @method('PATCH')

            <!-- Data Readonly -->
            <div class="space-y-4 mb-8 pb-8 border-b border-gray-100">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Siswa</label>
                    <input type="text" disabled readonly value="{{ $logbook->student->user->name ?? '-' }}" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2 cursor-not-allowed">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hari/Tanggal</label>
                    <input type="text" disabled readonly value="{{ $logbook->created_at->format('d-m-Y') }}" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kegiatan</label>
                    <textarea disabled readonly rows="4" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2 cursor-not-allowed resize-none">{{ $logbook->notes }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dokumentasi Kegiatan</label>
                    @if($logbook->documentation_file)
                        <a href="{{ route('industry.logbooks.download', $logbook->id) }}" target="_blank" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Lihat Dokumen
                        </a>
                    @else
                        <span class="inline-flex items-center text-sm text-gray-500 bg-gray-50 px-4 py-2 rounded-lg cursor-not-allowed border border-gray-200">
                            Tidak Ada Dokumen
                        </span>
                    @endif
                </div>
            </div>

            <!-- Form Edit -->
            <div class="space-y-4 mb-6">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Validasi <span class="text-red-500">*</span></label>
                    <select name="status" id="status" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary focus:ring-opacity-50 text-gray-800">
                        <option value="pending" {{ $logbook->status == 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                        <option value="approved" {{ $logbook->status == 'approved' ? 'selected' : '' }}>Disetujui (Approved)</option>
                        <option value="rejected" {{ $logbook->status == 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                        <option value="revision" {{ $logbook->status == 'revision' ? 'selected' : '' }}>Revisi (Revision)</option>
                    </select>
                </div>

                <div>
                    <label for="feedback" class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Umpan Balik</label>
                    <textarea name="feedback" id="feedback" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary focus:ring-opacity-50 text-gray-800" placeholder="Tuliskan umpan balik atau alasan penolakan/revisi jika ada...">{{ $logbook->feedback ?? old('feedback') }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('industry.logbooks.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2 bg-brand-primary hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:ring-offset-2">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
