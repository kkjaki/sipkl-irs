@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8" x-data="{
        search: '',
        get hasVisible() {
            if (this.search === '') return true;
            const term = this.search.toLowerCase();
            return Array.from(this.$refs.grid.querySelectorAll('.student-card-data')).some(el => el.innerText.toLowerCase().includes(term));
        }
    }">
        <!-- Header Wadah -->
        <div
            class="bg-gradient-to-r from-teal-500 to-teal-600 p-4 {{ count($logbooks) > 0 ? 'rounded-t-xl rounded-b-none border-b border-teal-600/50' : 'rounded-xl mb-6 shadow-sm' }} flex flex-col sm:flex-row justify-between items-center text-white gap-4 transition-all">
            <div class="flex items-center gap-2.5 text-white w-full sm:w-auto">
                <x-heroicon-o-book-open class="w-6 h-6 shrink-0" />
                <h2 class="font-bold text-lg m-0 shrink-0">Validasi Logbook Harian Siswa</h2>
            </div>

            <!-- High-Contrast Search bar di Header -->
            <div class="relative w-full md:w-64 shrink-0">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                    <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                </span>
                <input x-model.debounce.500ms="search" type="text"
                    class="block w-full pl-11 pr-4 py-2 bg-white/95 border border-white/40 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-teal-300 sm:text-sm transition-colors"
                    placeholder="Cari nama siswa...">
            </div>
        </div>

        @if (count($logbooks) > 0)
            <!-- Connected Data Container -->
            <div class="bg-white rounded-b-xl border border-gray-100 shadow-sm p-6 mb-6">
                <!-- Grid Layout foreach Logbook -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4" x-ref="grid">
                    @forelse($logbooks as $logbook)
                        <div x-show="search === '' || $el.innerText.toLowerCase().includes(search.toLowerCase())"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            class="student-card-data bg-white rounded-xl border border-gray-200 shadow-md hover:shadow-lg transition-shadow duration-200 p-5 relative flex flex-col h-full"
                            x-data="{ showModal: false, statusUpdate: '{{ $logbook->status }}' }">

                            <!-- Badges Status Trigger/Button -->
                            <div class="absolute top-4 right-4">
                                <button @click="showModal = true" class="focus:outline-none">
                                    @php
                                        $currentStatus = $logbook->status;
                                        $badgeClass = match ($currentStatus) {
                                            'approved' => 'bg-green-100 text-green-800 border-green-200',
                                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                            default => 'bg-gray-100 text-gray-800 border-gray-200',
                                        };

                                        $statusLabel = match ($currentStatus) {
                                            'approved' => 'Disetujui',
                                            'pending' => 'Menunggu',
                                            'rejected' => 'Ditolak',
                                            default => ucfirst($currentStatus),
                                        };
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeClass }} transition-colors hover:opacity-80 flex items-center gap-1">
                                        {{ $statusLabel }}
                                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>

                            <div class="pr-36 flex-grow">
                                <!-- Badge Tanggal Sesi -->
                                <div
                                    class="flex items-center gap-2 bg-blue-50/50 border border-blue-100/50 rounded-lg p-2 mb-3 w-max">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span
                                        class="text-blue-900 font-bold text-sm">{{ $logbook->created_at->translatedFormat('l, d F Y') }}</span>
                                </div>

                                <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $logbook->student->user->name ?? '-' }}
                                </h3>
                                <p class="text-sm text-gray-500 font-medium mb-4">
                                    {{ $logbook->student->school->name ?? '-' }}</p>

                                <div class="text-sm text-gray-600 mb-4">
                                    <span class="font-bold text-gray-800 block mb-1">Deskripsi Kegiatan:</span>
                                    <p class="whitespace-pre-wrap">{{ $logbook->notes }}</p>
                                </div>
                            </div>

                            <!-- Footer Card (Border Top) -->
                            <div
                                class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    @if ($logbook->documentation_file)
                                        <a href="{{ route('industry.logbooks.download', $logbook->id) }}" target="_blank"
                                            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            Lihat Dokumen
                                        </a>
                                    @endif

                                    <a href="{{ route('industry.logbooks.edit', $logbook->id) }}"
                                        class="inline-flex items-center text-sm text-teal-700 bg-teal-50 hover:bg-teal-100 font-medium px-3 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                        Umpan Balik
                                    </a>
                                </div>
                            </div>

                            <!-- Modal Konfirmasi Status Logbook -->
                            <div x-show="showModal"
                                class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50 break-words"
                                style="display: none;">
                                <div x-show="showModal" x-transition:enter="transition ease-out duration-300 transform"
                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                    x-transition:leave="transition ease-in duration-200 transform"
                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    @click.away="showModal = false"
                                    class="bg-white rounded-xl shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6 m-4 relative z-50">

                                    <h3 class="text-lg font-bold text-gray-900 mb-4">Ubah Status Logbook</h3>
                                    <p class="text-sm text-gray-500 mb-4">Siswa: <span
                                            class="font-semibold">{{ $logbook->student->user->name ?? '-' }}</span></p>

                                    <div class="mb-5">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Validasi</label>
                                        <select x-model="statusUpdate"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary focus:ring-opacity-50 text-gray-800">
                                            <option value="pending">Menunggu</option>
                                            <option value="approved">Disetujui</option>
                                            <option value="rejected">Ditolak</option>
                                        </select>
                                    </div>

                                    <div class="flex justify-end gap-3 mt-6">
                                        <button type="button" @click="showModal = false"
                                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md transition-colors">
                                            Batal
                                        </button>
                                        <button type="button" @click="updateLogbook({{ $logbook->id }}, statusUpdate)"
                                            class="px-4 py-2 bg-brand-primary hover:bg-teal-700 text-white text-sm font-medium rounded-md transition-colors">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>

                <!-- Search Empty State -->
                <div x-show="!hasVisible" style="display: none;"
                    class="col-span-full w-full text-center py-12 rounded-xl bg-gray-50 border border-dashed border-gray-200 mt-4">
                    <p class="text-gray-500">Logbook siswa dengan nama tersebut tidak ditemukan.</p>
                </div>

                <!-- Navigasi Pagination -->
                <div class="mt-6">
                    {{ $logbooks->links() }}
                </div>
            </div>
        @else
            <!-- Empty State Terpisah -->
            <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-dashed border-gray-200">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <p class="text-gray-500 font-medium">Belum ada data riwayat logbook siswa.</p>
            </div>
        @endif
    </div>

    <!-- Script Update Logbook Menggunakan Fetch API -->
    <script>
        function updateLogbook(logbookId, status) {
            // Ambil elemen Meta CSRF Token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let updateUrl = "{{ route('industry.logbooks.validate', '_id_') }}";
            updateUrl = updateUrl.replace('_id_', logbookId);

            // Atur payload status
            const payload = {
                status: status
            };

            // Mulai Fetch Request
            fetch(updateUrl, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(response => {
                    if (!response.ok) {
                        // Return json data if validation error exists
                        return response.json().then(err => {
                            throw err;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Status logbook berhasil diubah!');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data: ' + (error.message || 'Unknown error'));
                });
        }
    </script>

@endsection
