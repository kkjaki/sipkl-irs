<x-app-layout>
    <div class="min-h-screen bg-brand-bg px-10">
        {{-- Header --}}
        <header>
            <div class="w-full py-6 flex justify-between items-center">
                <div>
                    <h2 class="font-extrabold text-3xl text-gray-800 leading-tight">
                        {{ __('Daftar Logbook') }}
                    </h2>
                    <p class="text-gray-600 mt-2">Riwayat logbook Anda</p>
                </div>
                <a href="{{ route('student.logbook.harian') }}"
                   class="bg-brand-primary hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Logbook
                </a>
            </div>
        </header>

        {{-- Session Success --}}
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3" role="alert">
                <i class="fas fa-check-circle text-green-500 text-lg"></i>
                <p class="text-green-800 font-medium text-sm">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Card Container --}}
        <div class="bg-white shadow-md rounded-xl overflow-hidden relative">

            {{-- HEADER CARD --}}
            <div class="bg-teal-400 text-white px-4 md:px-6 py-4 flex flex-wrap gap-3 justify-between items-center">
                <h3 class="font-semibold text-lg">Daftar Logbook</h3>

                <div class="flex items-center gap-3">
                    {{-- SORT --}}
                    <button id="sortBtn" class="hover:opacity-80" title="Urutkan">
                        <i class="fa fa-sort"></i>
                    </button>

                    {{-- FILTER --}}
                    <button id="filterBtn"
                        class="flex items-center gap-2 border border-white px-4 py-1 rounded hover:bg-white hover:text-teal-500 transition">
                        <i class="fa fa-sliders"></i>
                        Filter
                    </button>
                </div>
            </div>

            {{-- FILTER POPUP --}}
            <div id="filterPopup"
                class="hidden absolute right-6 top-20 bg-white shadow-lg border rounded-lg w-64 p-4 z-20">

                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-semibold text-gray-700">Filter</h4>
                    <button id="closeFilter" class="text-gray-400 hover:text-gray-600">✕</button>
                </div>

                <p class="text-sm text-gray-500 mb-2">Status</p>

                <div class="flex flex-wrap gap-2 mb-4">
                    <button class="filter-pill px-3 py-1 text-xs rounded-full bg-gray-200" data-filter="approved">Disetujui</button>
                    <button class="filter-pill px-3 py-1 text-xs rounded-full bg-gray-200" data-filter="rejected">Ditolak</button>
                    <button class="filter-pill px-3 py-1 text-xs rounded-full bg-gray-200" data-filter="pending">Pending</button>
                </div>

                <div class="flex justify-between">
                    <button id="resetFilter" class="text-sm text-gray-500 hover:underline">Hapus</button>
                    <button id="applyFilter" class="bg-teal-400 text-white px-3 py-1 rounded text-sm">Simpan</button>
                </div>

            </div>

            {{-- LIST LOGBOOK --}}
            <div id="logbookList" class="p-4 md:p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                @forelse($logbooks as $logbook)

                <div class="logbook-card border border-gray-200 rounded-lg p-5 shadow-sm flex flex-col justify-between hover:shadow-md transition"
                    data-status="{{ $logbook->status }}">

                    {{-- HEADER CARD --}}
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($logbook->created_at)->translatedFormat('l, d-m-Y') }}
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ \Carbon\Carbon::parse($logbook->created_at)->format('H:i') }} WIB
                            </p>
                        </div>

                        {{-- STATUS BADGE --}}
                        @if($logbook->status === 'approved')
                            <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-semibold whitespace-nowrap">
                                <i class="fas fa-check-circle mr-1"></i>Disetujui
                            </span>
                        @elseif($logbook->status === 'rejected')
                            <span class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full font-semibold whitespace-nowrap">
                                <i class="fas fa-times-circle mr-1"></i>Ditolak
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-semibold whitespace-nowrap">
                                <i class="fas fa-clock mr-1"></i>Pending
                            </span>
                        @endif
                    </div>

                    {{-- MENTOR --}}
                    <p class="text-xs text-gray-500 mb-1">
                        <i class="fas fa-user-tie mr-1"></i>
                        {{ $logbook->mentor->name ?? '-' }}
                    </p>

                    {{-- CATATAN MENTOR (hanya jika ada feedback) --}}
                    @if($logbook->feedback)
                        <div class="bg-red-50 border border-red-200 rounded-lg px-3 py-2 mb-3 flex items-start gap-2">
                            <i class="fas fa-info-circle text-red-400 mt-0.5 text-xs shrink-0"></i>
                            <div>
                                <span class="text-xs font-semibold text-red-700 block">Catatan Mentor:</span>
                                <span class="text-xs text-red-600 leading-relaxed">{{ \Illuminate\Support\Str::limit($logbook->feedback, 100) }}</span>
                            </div>
                        </div>
                    @endif

                    {{-- DESKRIPSI KEGIATAN --}}
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-700 mb-1">Kegiatan:</p>
                        <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                            {{ \Illuminate\Support\Str::limit($logbook->notes, 120) }}
                        </p>
                    </div>

                    {{-- DOKUMEN + AKSI --}}
                    <div class="flex flex-wrap gap-2 mt-auto pt-3 border-t border-gray-100">

                        {{-- DOKUMEN --}}
                        @if($logbook->documentation_file)
                            <a href="{{ asset('storage/' . $logbook->documentation_file) }}"
                               target="_blank"
                               class="inline-flex items-center gap-1.5 text-xs border border-gray-300 text-gray-600 px-3 py-1.5 rounded hover:bg-gray-50 transition">
                                <i class="fas fa-file-download"></i> Dokumen
                            </a>
                        @endif

                        {{-- LIHAT DETAIL --}}
                        <button onclick="openDetailModal({{ $logbook->id }})"
                            class="inline-flex items-center gap-1.5 text-xs border border-blue-300 text-blue-600 px-3 py-1.5 rounded hover:bg-blue-50 transition">
                            <i class="fas fa-eye"></i> Detail
                        </button>

                        {{-- EDIT (hanya jika rejected) --}}
                        @if($logbook->status === 'rejected')
                            <a href="{{ route('student.logbook.edit', $logbook->id) }}"
                               class="inline-flex items-center gap-1.5 text-xs bg-yellow-400 text-white hover:bg-yellow-500 font-semibold px-3 py-1.5 rounded transition">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                        @endif

                    </div>
                </div>

                @empty

                {{-- EMPTY STATE --}}
                <div class="col-span-1 md:col-span-2 xl:col-span-3 flex flex-col items-center justify-center py-16 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-book-open text-3xl text-gray-300"></i>
                    </div>
                    <p class="text-gray-500 font-medium text-lg">Belum ada logbook</p>
                    <p class="text-gray-400 text-sm mt-1">Mulai buat logbook Anda untuk mencatat kegiatan PKL.</p>
                    <a href="{{ route('student.logbook.harian') }}"
                       class="mt-5 inline-flex items-center px-5 py-2.5 bg-brand-primary hover:bg-teal-600 text-white font-bold rounded-lg transition">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Logbook Pertama
                    </a>
                </div>

                @endforelse

            </div>

            {{-- PAGINATION --}}
            @if($logbooks->hasPages())
            <div class="px-6 pb-6 border-t border-gray-100 pt-4">
                {{ $logbooks->links() }}
            </div>
            @endif

        </div>
    </div>


    {{-- =================== DETAIL MODAL =================== --}}
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="bg-brand-primary text-white p-4 font-bold text-lg rounded-t-xl flex justify-between items-center">
                <span>Detail Logbook</span>
                <button onclick="closeDetailModal()" class="text-white hover:text-gray-200">
                    <x-heroicon-m-x-mark class="w-6 h-6" />
                </button>
            </div>
            <div id="detailContent" class="p-6"></div>
        </div>
    </div>


    <script>
        const logbooksData = @json($logbooks->items());

        // =================== DETAIL MODAL ===================
        function openDetailModal(id) {
            const logbook = logbooksData.find(l => l.id === id);
            if (!logbook) return;

            let statusBadge = '';
            if (logbook.status === 'pending') {
                statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800"><i class="fas fa-clock mr-1"></i>Menunggu</span>';
            } else if (logbook.status === 'approved') {
                statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i>Disetujui</span>';
            } else {
                statusBadge = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800"><i class="fas fa-times-circle mr-1"></i>Ditolak</span>';
            }

            const formatDate = (d) => new Date(d).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            const formatTime = (d) => new Date(d).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

            document.getElementById('detailContent').innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-gray-500 text-sm block mb-1">Tanggal</span>
                            <span class="font-medium text-gray-900">${formatDate(logbook.created_at)}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm block mb-1">Waktu</span>
                            <span class="font-medium text-gray-900">${formatTime(logbook.created_at)} WIB</span>
                        </div>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm block mb-1">Mentor</span>
                        <span class="font-medium text-gray-900">${logbook.mentor ? logbook.mentor.name : '-'}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm block mb-1">Status</span>
                        ${statusBadge}
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm block mb-2">Kegiatan</span>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-800 whitespace-pre-wrap text-sm">${logbook.notes}</p>
                        </div>
                    </div>
                    ${logbook.documentation_file ? `
                    <div>
                        <span class="text-gray-500 text-sm block mb-2">Dokumentasi</span>
                        <a href="/storage/${logbook.documentation_file}" target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-brand-primary hover:bg-teal-600 text-white font-medium rounded-lg transition text-sm">
                            <i class="fas fa-download mr-2"></i>Unduh Dokumen
                        </a>
                    </div>
                    ` : ''}
                    ${logbook.status === 'rejected' ? `
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded mt-2">
                        <p class="text-sm text-red-700">
                            <i class="fas fa-info-circle mr-1"></i>
                            Logbook ini ditolak oleh mentor. Silakan edit dan kirim ulang.
                        </p>
                        <a href="${window.location.origin}/student/logbook/${logbook.id}/edit"
                           class="mt-3 inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition text-sm">
                            <i class="fas fa-edit mr-2"></i>Edit Logbook
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

        document.getElementById('detailModal').addEventListener('click', function (e) {
            if (e.target === this) closeDetailModal();
        });

        // =================== FILTER ===================
        const filterBtn = document.getElementById('filterBtn');
        const popup = document.getElementById('filterPopup');
        const pills = document.querySelectorAll('.filter-pill');
        let selectedFilter = null;

        filterBtn.onclick = () => popup.classList.toggle('hidden');
        document.getElementById('closeFilter').onclick = () => popup.classList.add('hidden');

        pills.forEach(p => {
            p.onclick = () => {
                pills.forEach(x => x.classList.remove('bg-teal-400', 'text-white'));
                p.classList.add('bg-teal-400', 'text-white');
                selectedFilter = p.dataset.filter;
            };
        });

        document.getElementById('applyFilter').onclick = () => {
            document.querySelectorAll('.logbook-card').forEach(card => {
                card.style.display = (!selectedFilter || card.dataset.status === selectedFilter) ? 'flex' : 'none';
            });
            popup.classList.add('hidden');
        };

        document.getElementById('resetFilter').onclick = () => {
            selectedFilter = null;
            pills.forEach(x => x.classList.remove('bg-teal-400', 'text-white'));
            document.querySelectorAll('.logbook-card').forEach(card => card.style.display = 'flex');
        };

        // =================== SORT ===================
        document.getElementById('sortBtn').onclick = () => {
            const list = document.getElementById('logbookList');
            const items = Array.from(list.querySelectorAll('.logbook-card'));
            items.reverse().forEach(el => list.appendChild(el));
        };
    </script>

</x-app-layout>
