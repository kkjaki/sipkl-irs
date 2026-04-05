@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10 pb-10 w-full" 
        x-data="{
            search: '',
            successAlert: false,
            showConfirmBulk: false,
            bulkTarget: '', 
            get hasVisible() {
                if (this.search === '') return true;
                const term = this.search.toLowerCase();
                return Array.from(this.$refs.grid.querySelectorAll('.student-card-data')).some(el => 
                    el.innerText.toLowerCase().includes(term)
                );
            }
        }"
        @success-modal.window="successAlert = true; showConfirmBulk = false">
        
        <header>
            <div class="py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Validasi Logbook Siswa') }}
                </h2>
            </div>
        </header>

        <article class="w-full bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            {{-- Header Card Teal --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-6 flex flex-col md:flex-row justify-between items-center text-white gap-4">
                <div class="flex items-center gap-2.5">
                    <x-heroicon-o-book-open class="w-6 h-6 shrink-0" />
                    <h2 class="font-bold text-lg m-0 leading-none">Antrean Validasi Logbook</h2>
                </div>

                <div class="relative w-full md:w-80 shrink-0">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                        <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                    </span>
                    <input x-model.live.debounce.150ms="search" type="text"
                        @keydown.enter.prevent
                        class="block w-full pl-11 pr-4 py-2.5 bg-white border border-transparent rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-teal-300 sm:text-sm transition-all shadow-sm"
                        placeholder="Cari nama siswa...">
                </div>
            </div>

            <div class="p-6">
                @if (count($logbooks) > 0)
                    {{-- Bulk Action --}}
                    <div class="mb-8 flex flex-col sm:flex-row items-center justify-between bg-gray-50 p-5 rounded-2xl border border-gray-200 shadow-inner gap-4">
                        <div class="flex items-center gap-4 text-gray-700">
                            <input type="checkbox" id="selectAll" class="rounded-md border-gray-300 text-teal-600 focus:ring-teal-500 w-6 h-6 cursor-pointer">
                            <div class="flex flex-col">
                                <label for="selectAll" class="text-sm font-black cursor-pointer">Pilih Semua</label>
                                <span id="selectedCount" class="text-[10px] font-bold text-teal-600 uppercase hidden">0 Terpilih</span>
                            </div>
                        </div>
                        <div class="flex gap-3 w-full sm:w-auto">
                            <button @click="bulkTarget = 'approved'; showConfirmBulk = true" id="btnApproveBulk" disabled class="flex-1 sm:flex-none bg-white text-green-600 border border-green-200 px-5 py-2.5 rounded-xl text-sm font-bold transition-all disabled:opacity-50 hover:bg-green-600 hover:text-white shadow-sm active:scale-95">Setujui</button>
                            <button @click="bulkTarget = 'rejected'; showConfirmBulk = true" id="btnRejectBulk" disabled class="flex-1 sm:flex-none bg-white text-rose-600 border border-rose-200 px-5 py-2.5 rounded-xl text-sm font-bold transition-all disabled:opacity-50 hover:bg-rose-600 hover:text-white shadow-sm active:scale-95">Tolak</button>
                        </div>
                    </div>

                    {{-- Daftar Grid Logbook --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" x-ref="grid">
                        @foreach($logbooks as $logbook)
                            <section 
                                x-show="search === '' || $el.innerText.toLowerCase().includes(search.toLowerCase())"
                                x-transition:enter="transition ease-out duration-200"
                                x-data="{ showModal: false, statusUpdate: '{{ $logbook->status }}' }"
                                class="student-card-data bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 p-6 relative flex flex-col group">

                                <div class="absolute top-6 left-6 z-10">
                                    <input type="checkbox" value="{{ $logbook->id }}" class="logbook-checkbox rounded-md border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5 cursor-pointer shadow-sm">
                                </div>

                                <div class="absolute top-6 right-6">
                                    <button @click="showModal = true" class="focus:outline-none">
                                        @php
                                            $textColor = match ($logbook->status) {
                                                'approved' => 'text-green-600',
                                                'pending' => 'text-amber-600',
                                                'rejected' => 'text-rose-600',
                                                default => 'text-gray-500',
                                            };
                                        @endphp
                                        <span class="px-2 py-1 text-[10px] font-black uppercase tracking-widest {{ $textColor }} flex items-center gap-1 hover:bg-gray-50 rounded-lg transition-all">
                                            {{ $logbook->status === 'approved' ? 'Disetujui' : ($logbook->status === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                            <x-heroicon-o-chevron-down class="w-3 h-3" />
                                        </span>
                                    </button>
                                </div>

                                <div class="mt-10">
                                    <h3 class="text-xl font-black text-gray-900 group-hover:text-teal-600 transition-colors">{{ $logbook->student->user->name ?? '-' }}</h3>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1 mb-5">{{ $logbook->student->school->name ?? '-' }}</p>
                                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 mb-6 group-hover:bg-white transition-colors">
                                        <p class="text-sm text-gray-700 font-medium whitespace-pre-wrap leading-relaxed">{{ $logbook->notes }}</p>
                                    </div>
                                </div>

                                <div class="mt-auto pt-5 border-t border-gray-100 flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-xs font-bold">
                                        @if ($logbook->documentation_file)
                                            <a href="{{ route('industry.logbooks.download', $logbook->id) }}" target="_blank" class="text-blue-600 bg-blue-50 px-4 py-2 rounded-lg border border-blue-100 hover:bg-blue-600 hover:text-white transition-all">Dokumen</a>
                                        @endif
                                        <a href="{{ route('industry.logbooks.edit', $logbook->id) }}" class="text-teal-700 bg-teal-50 px-4 py-2 rounded-lg border border-teal-100 hover:bg-teal-600 hover:text-white transition-all">Feedback</a>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-400 italic">{{ $logbook->created_at->translatedFormat('d M Y') }}</span>
                                </div>

                                {{-- Modal Ganti Status Individu --}}
                                <div x-cloak x-show="showModal" class="fixed inset-0 z-[9999] overflow-y-auto">
                                    <div class="flex items-center justify-center min-h-screen p-4">
                                        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showModal = false"></div>
                                        <div class="bg-white rounded-2xl p-6 w-full max-w-md relative z-[10000] shadow-2xl">
                                            <h3 class="text-xl font-black text-gray-900 mb-6">Ubah Status</h3>
                                            <div class="mb-8 text-left">
                                                <select x-model="statusUpdate" class="w-full rounded-xl border-gray-200 bg-gray-50 py-3 px-4 font-bold text-gray-800 focus:ring-teal-500 focus:border-teal-500 transition-all">
                                                    <option value="pending">Menunggu</option>
                                                    <option value="approved">Disetujui</option>
                                                    <option value="rejected">Ditolak</option>
                                                </select>
                                            </div>
                                            <div class="flex gap-3">
                                                <button @click="showModal = false" class="flex-1 px-4 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                                                <button @click="updateLogbook({{ $logbook->id }}, statusUpdate); showModal = false" class="flex-1 px-4 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-lg hover:bg-teal-700 active:scale-95 transition-all">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endforeach
                    </div>
                @endif
            </div>
        </article>

        {{-- MODAL KONFIRMASI MASSAL --}}
        <div x-cloak x-show="showConfirmBulk" class="fixed inset-0 z-[10001] flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showConfirmBulk = false"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full text-center border border-gray-100"
                x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
                
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-amber-100 mb-6">
                    <x-heroicon-o-exclamation-triangle class="h-10 w-10 text-amber-600" />
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2">Konfirmasi Validasi Massal</h3>
                <p class="text-sm text-gray-500 font-medium leading-relaxed mb-8">
                    Apakah Anda yakin ingin memproses <span class="font-black text-teal-600" id="bulkConfirmCount">0</span> logbook terpilih untuk 
                    <span class="font-black" :class="bulkTarget === 'approved' ? 'text-green-600' : 'text-rose-600'" x-text="bulkTarget === 'approved' ? 'DISETUJUI' : 'DITOLAK'"></span>?
                </p>
                <div class="flex gap-3">
                    <button @click="showConfirmBulk = false" class="flex-1 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                    <button @click="submitBulk(bulkTarget)" class="flex-1 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-lg hover:bg-teal-700 active:scale-95 transition-all">Ya, Proses Semua</button>
                </div>
            </div>
        </div>

        {{-- MODAL ALERT SUKSES --}}
        <div x-cloak x-show="successAlert" class="fixed inset-0 z-[10002] flex items-center justify-center px-4" style="display: none;">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="successAlert = false; location.reload();"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full text-center border border-gray-100">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                    <x-heroicon-s-check-circle class="h-12 w-12 text-green-600" />
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">Berhasil!</h3>
                <p class="text-sm text-gray-500 font-medium leading-relaxed mb-8">Data validasi logbook telah berhasil diperbarui!</p>
                <button @click="successAlert = false; location.reload();" class="w-full py-4 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl shadow-lg transition-all active:scale-95">Mantap!</button>
            </div>
        </div>
    </main>

    <script>
        // Fungsi Update Individu 
        function updateLogbook(id, status) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let url = "{{ route('industry.logbooks.validate', ':id') }}".replace(':id', id);
            fetch(url, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: JSON.stringify({ status })
            })
            .then(res => res.ok ? res.json() : Promise.reject())
            .then(() => { window.dispatchEvent(new Event('success-modal')); })
            .catch(() => { console.error('Gagal update data.'); });
        }

        // Fungsi Update Massal
        function submitBulk(status) {
            const ids = Array.from(document.querySelectorAll('.logbook-checkbox:checked')).map(c => c.value);
            if (!ids.length) return;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch('{{ route("industry.logbooks.bulkValidate") }}', {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: JSON.stringify({ ids, status })
            })
            .then(res => res.ok ? res.json() : Promise.reject())
            .then(() => { window.dispatchEvent(new Event('success-modal')); })
            .catch(() => { console.error('Gagal proses massal.'); });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.logbook-checkbox');
            const btns = [document.getElementById('btnApproveBulk'), document.getElementById('btnRejectBulk')];
            const label = document.getElementById('selectedCount');
            const confirmCount = document.getElementById('bulkConfirmCount');

            const updateUI = () => {
                const count = document.querySelectorAll('.logbook-checkbox:checked').length;
                btns.forEach(b => b.disabled = count === 0);
                if(label) {
                    label.textContent = count + ' Terpilih';
                    label.classList.toggle('hidden', count === 0);
                }
                if(confirmCount) confirmCount.textContent = count;
            };

            if(selectAll) selectAll.addEventListener('change', () => {
                checkboxes.forEach(c => c.checked = selectAll.checked);
                updateUI();
            });
            checkboxes.forEach(c => c.addEventListener('change', updateUI));
        });
    </script>

    <style> [x-cloak] { display: none !important; } </style>
@endsection