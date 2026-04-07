<x-app-layout>
@section('title', 'Daftar Kehadiran')
    {{-- 1. Bungkus dengan x-data Alpine.js --}}
    <div class="min-h-screen bg-brand-bg px-10 pb-10" x-data="{
        activeFilter: 'all',
        tempFilter: 'all',
        showFilterModal: false
    }">
        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-extrabold text-3xl text-gray-800 leading-tight">
                    {{ __('Daftar Kehadiran') }}
                </h2>
                <p class="text-gray-600 mt-2">
                    Riwayat presensi Anda
                </p>
            </div>
        </header>

        {{-- Pastikan gak ada overflow-hidden biar filter gak kepotong --}}
        <article class="w-full bg-white rounded-xl shadow-md border border-gray-200 mb-8 flex flex-col relative">

            {{-- HEADER WADAH DENGAN FILTER (Sama Persis Kayak Mentor) --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex justify-between items-center text-white relative rounded-t-xl">
                <div class="flex items-center gap-2.5">
                    <x-heroicon-o-list-bullet class="w-6 h-6 shrink-0 opacity-90" />
                    <h2 class="font-bold text-lg m-0">Daftar Riwayat</h2>
                </div>

                {{-- Dropdown Filter Alpine.js --}}
                <div class="relative flex items-center @click.away="showFilterModal = false">
                    <button @click="showFilterModal = !showFilterModal" "
                        class="flex items-center gap-2 px-4 py-1.5 bg-white hover:bg-teal-50 text-teal-700 rounded-lg text-sm font-bold transition-all shadow-sm border border-transparent leading-none">
                        <x-heroicon-o-funnel class="w-4 h-4" />
                        <span>Filter Status</span>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="showFilterModal" x-cloak x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="absolute top-full right-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 text-gray-800 overflow-hidden">

                        <div class="p-4 border-b border-gray-50">
                            <h4 class="font-black text-xs uppercase tracking-widest text-gray-400">Filter Kehadiran</h4>
                        </div>

                        <div class="p-5 flex flex-wrap gap-2">
                            @foreach (['hadir', 'terlambat', 'izin', 'sakit', 'alpa'] as $status)
                                <button @click="tempFilter = '{{ $status }}'"
                                    :class="tempFilter === '{{ $status }}' ?
                                        'bg-teal-600 text-white shadow-md shadow-teal-100' :
                                        'bg-gray-50 text-gray-600 hover:bg-gray-100'"
                                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all border border-transparent">
                                    {{ ucfirst($status) }}
                                </button>
                            @endforeach
                        </div>

                        <div class="p-4 bg-gray-50 flex justify-between items-center gap-3">
                            <button @click="tempFilter = 'all'; activeFilter = 'all'; showFilterModal = false"
                                class="flex-1 py-2 text-xs font-bold text-gray-500 hover:text-gray-700 transition-colors">Reset</button>
                            <button @click="activeFilter = tempFilter; showFilterModal = false"
                                class="flex-1 py-2 bg-teal-600 text-white rounded-lg text-xs font-bold shadow-md shadow-teal-100 transition-all">Terapkan</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- LIST KEHADIRAN --}}
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                @forelse($attendances as $attendance)
                    @php
                        // 2. Logic "Terlambat Otomatis" biar filter Terlambat-nya jalan!
                        $statusRaw = strtolower($attendance->status);

                        if ($statusRaw === 'hadir' && $attendance->check_in && $attendance->session) {
                            $checkIn = date('H:i', strtotime($attendance->check_in));
                            $deadline = date('H:i', strtotime($attendance->session->on_time_deadline));
                            
                            if ($checkIn > $deadline) {
                                $statusRaw = 'terlambat';
                            }
                        }

                        $statusDisplay = match ($statusRaw) {
                            'hadir' => 'Hadir',
                            'terlambat' => 'Terlambat',
                            'izin' => 'Izin',
                            'sakit' => 'Sakit',
                            'alpa' => 'Alpa',
                            default => 'Belum Absen',
                        };

                        $badgeStyle = match ($statusRaw) {
                            'hadir' => 'bg-green-50 text-green-600 border-green-100',
                            'terlambat' => 'bg-rose-50 text-rose-600 border-rose-100',
                            'izin', 'sakit' => 'bg-blue-50 text-blue-600 border-blue-100',
                            'alpa' => 'bg-red-50 text-red-600 border-red-100',
                            default => 'bg-gray-50 text-gray-500 border-gray-200',
                        };
                    @endphp

                    {{-- 3. x-show Alpine untuk menyembunyikan/menampilkan Card --}}
                    <div x-show="activeFilter === 'all' || activeFilter === '{{ $statusRaw }}'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="border border-gray-200 rounded-2xl p-6 flex flex-col justify-between bg-white shadow-sm hover:shadow-md transition-all">

                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <p class="font-black text-gray-800 text-lg">
                                    {{ \Carbon\Carbon::parse($attendance->check_in ?? $attendance->created_at)->translatedFormat('l, F d Y') }}
                                </p>
                                <p class="text-sm font-bold text-gray-400 flex items-center gap-1.5 mt-1">
                                    <x-heroicon-o-clock class="w-4 h-4 text-teal-500" />
                                    {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') . ' WIB' : '-' }}
                                </p>
                            </div>

                            {{-- STATUS BADGE --}}
                            <span class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border {{ $badgeStyle }} flex items-center gap-1.5 shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full {{ str_replace('text', 'bg', explode(' ', $badgeStyle)[0]) }}"></span>
                                {{ $statusDisplay }}
                            </span>
                        </div>

                        {{-- BUKTI PRESENSI --}}
                        <div class="pt-4 border-t border-gray-100 mt-auto">
                            @if($attendance->image)
                                <a href="{{ asset('storage/' . $attendance->image) }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 text-[10px] uppercase tracking-widest font-black border border-teal-200 text-teal-600 bg-teal-50 px-4 py-2.5 rounded-xl hover:bg-teal-600 hover:text-white transition-all active:scale-95">
                                    <x-heroicon-o-camera class="w-4 h-4" />
                                    Lihat Bukti Presensi
                                </a>
                            @else
                                <span class="inline-flex items-center gap-2 text-[10px] uppercase tracking-widest font-black border border-dashed border-gray-200 text-gray-400 bg-gray-50 px-4 py-2.5 rounded-xl cursor-not-allowed">
                                    <x-heroicon-o-no-symbol class="w-4 h-4" />
                                    Tidak Ada Bukti
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    {{-- EMPTY STATE --}}
                    <div class="col-span-1 md:col-span-2 flex flex-col items-center justify-center py-20 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <div class="w-20 h-20 bg-white shadow-sm border border-gray-100 rounded-full flex items-center justify-center mb-5">
                            <x-heroicon-o-calendar-days class="w-10 h-10 text-gray-300" />
                        </div>
                        <p class="text-gray-400 font-black uppercase tracking-widest mb-2">Belum ada data kehadiran</p>
                        <p class="text-gray-400 text-xs font-medium">Mulai lakukan presensi harian Anda di halaman Presensi Harian.</p>
                    </div>
                @endforelse

            </div>

            {{-- PAGINATION --}}
            @if($attendances->hasPages())
            <div class="px-6 pb-6 pt-4 border-t border-gray-100">
                {{ $attendances->links() }}
            </div>
            @endif

        </article>
    </div>

    {{-- Hide element sebelum Alpine.js load --}}
    <style> [x-cloak] { display: none !important; } </style>
</x-app-layout>