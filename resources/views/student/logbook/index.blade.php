<x-app-layout>
    @section('title', 'Daftar Logbook')

    <div class="min-h-screen bg-brand-bg px-10 pb-10" x-data="{
        activeFilter: 'all',
        tempFilter: 'all',
        showFilterModal: false,
        sortDesc: true,
        showDetailModal: false,
        detailLogbook: null,
    
        // AMBIL DATA DARI BACKEND
        logbooks: @js($logbooks->items()),
    
        // FUNGSI SORTING REAL-TIME
        get sortedLogbooks() {
            let filtered = this.logbooks.filter(l => this.activeFilter === 'all' || l.status.toLowerCase() === this.activeFilter);
            return this.sortDesc ?
                filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at)) :
                filtered.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
        },
    
        openDetail(id) {
            this.detailLogbook = this.logbooks.find(l => l.id === id);
            this.showDetailModal = true;
        },
    
        formatDate(dateStr) {
            // GANTI BAGIAN DALAM KURUNG INI
            return new Date(dateStr).toLocaleDateString('en-US', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        },
    
        formatTime(dateStr) {
            return new Date(dateStr).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
        }
    }">

        {{-- Header --}}
        <header>
            <div class="w-full py-6 flex justify-between items-center">
                <div>
                    <h2 class="font-extrabold text-3xl text-gray-800 leading-tight">Daftar Logbook</h2>
                    <p class="text-gray-600 mt-2">Riwayat logbook Anda</p>
                </div>
                <a href="{{ route('student.logbook.harian') }}"
                    class="bg-teal-500 hover:bg-teal-600 active:scale-95 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-teal-100 transition-all flex items-center gap-2">
                    <x-heroicon-s-plus class="w-5 h-5" /> Tambah Logbook
                </a>
            </div>
        </header>

        {{-- Card Container --}}
        <article class="w-full bg-white rounded-xl shadow-md border border-gray-200 mb-8 flex flex-col relative">

            {{-- HEADER WADAH --}}
            <div
                class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex justify-between items-center text-white relative rounded-t-xl">
                <div class="flex items-center gap-2.5">
                    <x-heroicon-o-book-open class="w-6 h-6 shrink-0 opacity-90" />
                    <h2 class="font-bold text-lg m-0">Daftar Riwayat PKL</h2>
                </div>

                <div class="flex items-center gap-3">
                    {{-- TOMBOL SORT --}}
                    <button @click="sortDesc = !sortDesc"
                        class="p-2 rounded-lg transition-all hover:bg-teal-700 focus:outline-none flex items-center gap-1.5"
                        :class="!sortDesc ? 'bg-teal-800 shadow-inner' : ''">
                        <x-heroicon-s-arrows-up-down class="w-5 h-5" />
                        <span class="text-xs font-bold" x-text="sortDesc ? 'Terbaru' : 'Terlama'"></span>
                    </button>

                    {{-- FILTER --}}
                    <div class="relative flex items-center" @click.away="showFilterModal = false">
                        <button @click="showFilterModal = !showFilterModal"
                            class="flex items-center gap-2 px-4 py-1.5 bg-white hover:bg-teal-50 text-teal-700 rounded-lg text-sm font-bold transition-all shadow-sm">
                            <x-heroicon-o-funnel class="w-4 h-4" />
                            <span>Filter Status</span>
                        </button>

                        <div x-show="showFilterModal" x-cloak x-transition
                            class="absolute top-full right-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 text-gray-800 overflow-hidden">
                            <div class="p-4 border-b border-gray-50 text-xs font-black uppercase text-gray-400">Pilih
                                Status</div>
                            <div class="p-5 flex flex-wrap gap-2">
                                @foreach (['pending' => 'Pending', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'] as $val => $label)
                                    <button @click="tempFilter = '{{ $val }}'"
                                        :class="tempFilter === '{{ $val }}' ? 'bg-teal-600 text-white shadow-md' :
                                            'bg-gray-50 text-gray-600'"
                                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all">{{ $label }}</button>
                                @endforeach
                            </div>
                            <div class="p-4 bg-gray-50 flex justify-between items-center gap-3">
                                <button @click="tempFilter = 'all'; activeFilter = 'all'; showFilterModal = false"
                                    class="flex-1 text-xs font-bold text-gray-500">Reset</button>
                                <button @click="activeFilter = tempFilter; showFilterModal = false"
                                    class="flex-1 py-2 bg-teal-600 text-white rounded-lg text-xs font-bold shadow-md">Terapkan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- LIST LOGBOOK (LOOPING DARI GETTER ALPINE) --}}
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                    <template x-for="logbook in sortedLogbooks" :key="logbook.id">
                        <div
                            class="border border-gray-200 rounded-2xl p-6 flex flex-col justify-between bg-white shadow-sm hover:shadow-md transition-all">

                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <p class="font-black text-gray-800 text-lg" x-text="formatDate(logbook.created_at)">
                                    </p>
                                    <p class="text-sm font-bold text-gray-400 flex items-center gap-1.5 mt-1">
                                        <x-heroicon-o-clock class="w-4 h-4 text-teal-500" />
                                        <span x-text="formatTime(logbook.created_at)"></span>
                                    </p>
                                </div>

                                {{-- Status Badge --}}
                                <span
                                    class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border flex items-center gap-1.5 shadow-sm"
                                    :class="{
                                        'bg-green-50 text-green-600 border-green-100': logbook.status === 'approved',
                                        'bg-rose-50 text-rose-600 border-rose-100': logbook.status === 'rejected',
                                        'bg-amber-50 text-amber-600 border-amber-100': logbook.status === 'pending'
                                    }">
                                    <span class="w-1.5 h-1.5 rounded-full"
                                        :class="{
                                            'bg-green-600': logbook.status === 'approved',
                                            'bg-rose-600': logbook.status === 'rejected',
                                            'bg-amber-600': logbook.status === 'pending'
                                        }"></span>
                                    <span
                                        x-text="logbook.status === 'approved' ? 'Disetujui' : (logbook.status === 'rejected' ? 'Ditolak' : 'Pending')"></span>
                                </span>
                            </div>

                            <div class="mb-4 text-sm text-gray-600 font-medium flex items-center gap-2">
                                <x-heroicon-s-user-circle class="w-5 h-5 text-gray-400" />
                                <span x-text="logbook.mentor?.user?.name || '-'"></span>
                            </div>

                            <div class="mb-6 flex-1 text-sm text-gray-700 leading-relaxed line-clamp-3 font-medium"
                                x-text="logbook.notes"></div>

                            <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-100 mt-auto">
                                <button @click="openDetail(logbook.id)"
                                    class="flex-1 text-center inline-flex justify-center items-center gap-1.5 text-[10px] uppercase font-black border border-teal-200 text-teal-600 bg-teal-50 px-3 py-2 rounded-xl hover:bg-teal-600 hover:text-white transition-all">
                                    <x-heroicon-s-eye class="w-4 h-4" /> Detail
                                </button>

                                <template x-if="logbook.status === 'pending' || logbook.status === 'rejected'">
                                    <a :href="'/student/logbook/' + logbook.id + '/edit'"
                                        class="flex-1 text-center inline-flex justify-center items-center gap-1.5 text-[10px] uppercase font-black border border-amber-200 text-amber-600 bg-amber-50 px-3 py-2 rounded-xl hover:bg-amber-500 hover:text-white transition-all">
                                        <x-heroicon-s-pencil-square class="w-4 h-4" /> Edit
                                    </a>
                                </template>
                            </div>
                        </div>
                    </template>

                    {{-- Empty State --}}
                    <div x-show="sortedLogbooks.length === 0"
                        class="col-span-full py-20 text-center font-bold text-gray-400 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        Tidak ada logbook dengan status tersebut.
                    </div>
                </div>
            </div>

            @if ($logbooks->hasPages())
                <div class="px-6 pb-6 pt-4 border-t border-gray-100">
                    {{ $logbooks->links() }}
                </div>
            @endif
        </article>

        {{-- MODAL DETAIL --}}
        <div x-cloak x-show="showDetailModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div x-show="showDetailModal" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm"
                @click="showDetailModal = false"></div>
            <div x-show="showDetailModal" x-transition:enter="transition ease-out duration-300 transform scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl flex flex-col overflow-hidden">
                <div
                    class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex justify-between items-center text-white shrink-0">
                    <h3 class="font-bold text-lg">Detail Logbook</h3>
                    <button @click="showDetailModal = false"
                        class="bg-white/10 hover:bg-white/20 rounded-full p-1.5"><x-heroicon-m-x-mark
                            class="w-5 h-5" /></button>
                </div>
                <div class="p-8 overflow-y-auto" x-show="detailLogbook">
                    <template x-if="detailLogbook">
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-6 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Tanggal</p>
                                    <p class="font-bold text-gray-800" x-text="formatDate(detailLogbook.created_at)">
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Waktu</p>
                                    <p class="font-bold text-gray-800" x-text="formatTime(detailLogbook.created_at)">
                                    </p>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase mb-3">Kegiatan</p>
                                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 text-gray-700 text-sm leading-relaxed whitespace-pre-wrap font-medium"
                                    x-text="detailLogbook.notes"></div>
                            </div>
                            <template x-if="detailLogbook.documentation_file">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase mb-3">Dokumentasi</p>
                                    <a :href="'/storage/' + detailLogbook.documentation_file" target="_blank"
                                        class="inline-flex items-center gap-2 px-5 py-3 bg-teal-50 text-teal-700 hover:bg-teal-600 hover:text-white border border-teal-200 rounded-xl font-bold text-sm transition-all">Lihat
                                        File</a>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</x-app-layout>
