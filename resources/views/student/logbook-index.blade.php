<x-app-layout>
    <div class="min-h-screen bg-brand-bg px-10">
        {{-- Header --}}
        <header>
            <div class="w-full py-6 flex justify-between items-center">
                <div>
                    <h2 class="font-extrabold text-3xl text-gray-800 leading-tight">
                        {{ __('Daftar Logbook') }}
                    </h2>
                    <p class="text-gray-600 mt-2">
                        Riwayat logbook harian Anda
                    </p>
                </div>
                <a href="{{ route('student.logbook.harian') }}"
                   class="bg-brand-primary hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Logbook Baru
                </a>
            </div>
        </header>

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b-2 border-gray-200 bg-gray-50">
                            <th class="py-4 px-6 text-gray-700 font-semibold">No</th>
                            <th class="py-4 px-6 text-gray-700 font-semibold">Tanggal</th>
                            <th class="py-4 px-6 text-gray-700 font-semibold">Mentor</th>
                            <th class="py-4 px-6 text-gray-700 font-semibold">Kegiatan</th>
                            <th class="py-4 px-6 text-gray-700 font-semibold">Dokumen</th>
                            <th class="py-4 px-6 text-gray-700 font-semibold">Status</th>
                            <th class="py-4 px-6 text-gray-700 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logbooks->items() as $index => $logbook)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-4 px-6 text-gray-800">
                                {{ ($logbooks->currentPage() - 1) * $logbooks->perPage() + $index + 1 }}
                            </td>
                            <td class="py-4 px-6 text-gray-800">
                                {{ date('d F Y', strtotime($logbook->created_at)) }}
                                <div class="text-gray-500 text-sm">
                                    {{ date('H:i', strtotime($logbook->created_at)) }}
                                </div>
                            </td>
                            <td class="py-4 px-6 text-gray-800">
                                {{ $logbook->mentor->name ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-gray-600 max-w-xs">
                                {{ \Illuminate\Support\Str::limit($logbook->notes, 100) }}
                            </td>
                            <td class="py-4 px-6">
                                @if($logbook->documentation_file)
                                    <a href="{{ asset('storage/' . $logbook->documentation_file) }}"
                                       target="_blank"
                                       class="text-brand-primary hover:text-teal-600 transition inline-flex items-center">
                                        <x-heroicon-s-document class="w-5 h-5 mr-1" />
                                        Unduh
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($logbook->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        Menunggu
                                    </span>
                                @elseif($logbook->status === 'approved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Disetujui
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex gap-2">
                                    {{-- Detail Button --}}
                                    <button onclick="showDetail({{ $logbook->id }})"
                                            class="text-blue-600 hover:text-blue-800 transition"
                                            title="Lihat Detail">
                                        <x-heroicon-s-eye class="w-5 h-5" />
                                    </button>

                                    {{-- Edit Button (only for rejected) --}}
                                    @if($logbook->status === 'rejected')
                                        <a href="{{ route('student.logbook.edit', $logbook->id) }}"
                                           class="text-yellow-600 hover:text-yellow-800 transition"
                                           title="Edit Logbook">
                                            <x-heroicon-s-pencil class="w-5 h-5" />
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <x-heroicon-s-book-open class="w-16 h-16 text-gray-300 mb-4" />
                                    <p class="text-lg font-medium">Belum ada logbook</p>
                                    <p class="text-sm mt-2">Mulai buat logbook harian Anda</p>
                                    <a href="{{ route('student.logbook.harian') }}"
                                       class="mt-4 inline-flex items-center px-4 py-2 bg-brand-primary hover:bg-teal-600 text-white font-bold rounded-lg transition">
                                        <i class="fas fa-plus mr-2"></i>
                                        Buat Logbook Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($logbooks->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                <div class="text-gray-600 text-sm">
                    Menampilkan {{ $logbooks->firstItem() }} sampai {{ $logbooks->lastItem() }}
                    dari {{ $logbooks->total() }} data
                </div>
                {{ $logbooks->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>

    {{-- Detail Modal --}}
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="bg-brand-primary text-white p-4 font-bold text-lg rounded-t-xl flex justify-between items-center">
                <span>Detail Logbook</span>
                <button onclick="closeDetailModal()" class="text-white hover:text-gray-200">
                    <x-heroicon-m-x-mark class="w-6 h-6" />
                </button>
            </div>

            <div id="detailContent" class="p-6">
                {{-- Content will be loaded here via AJAX --}}
            </div>
        </div>
    </div>

    <script>
        const logbooks = @json($logbooks->items());

        function showDetail(id) {
            const logbook = logbooks.find(l => l.id === id);

            if (!logbook) {
                alert('Logbook tidak ditemukan');
                return;
            }

            const content = document.getElementById('detailContent');

            let statusBadge = '';
            if (logbook.status === 'pending') {
                statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800"><i class="fas fa-clock mr-1"></i>Menunggu</span>';
            } else if (logbook.status === 'approved') {
                statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i>Disetujui</span>';
            } else {
                statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800"><i class="fas fa-times-circle mr-1"></i>Ditolak</span>';
            }

            content.innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-gray-600 block mb-1">Tanggal</span>
                            <span class="font-medium text-gray-900">${formatDate(logbook.created_at)}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 block mb-1">Waktu</span>
                            <span class="font-medium text-gray-900">${formatTime(logbook.created_at)}</span>
                        </div>
                    </div>

                    <div>
                        <span class="text-gray-600 block mb-1">Mentor</span>
                        <span class="font-medium text-gray-900">${logbook.mentor ? logbook.mentor.name : '-'}</span>
                    </div>

                    <div>
                        <span class="text-gray-600 block mb-1">Status</span>
                        ${statusBadge}
                    </div>

                    <div>
                        <span class="text-gray-600 block mb-2">Kegiatan</span>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-800 whitespace-pre-wrap">${logbook.notes}</p>
                        </div>
                    </div>

                    ${logbook.documentation_file ? `
                    <div>
                        <span class="text-gray-600 block mb-2">Dokumentasi</span>
                        <a href="/storage/${logbook.documentation_file}" target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-brand-primary hover:bg-teal-600 text-white font-medium rounded-lg transition">
                            <i class="fas fa-download mr-2"></i>
                            Unduh Dokumen
                        </a>
                    </div>
                    ` : ''}

                    ${logbook.status === 'rejected' ? `
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded mt-4">
                        <p class="text-sm text-red-700">
                            <i class="fas fa-info-circle mr-1"></i>
                            Logbook ini ditolak oleh mentor. Silakan edit dan kirim ulang.
                        </p>
                        <a href="${window.location.origin}/student/logbook/${logbook.id}/edit"
                           class="mt-3 inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Logbook
                        </a>
                    </div>
                    ` : ''}
                </div>
            `;

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            return date.toLocaleDateString('id-ID', options);
        }

        function formatTime(dateString) {
            const date = new Date(dateString);
            return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }

        // Close modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });
    </script>
</x-app-layout>
