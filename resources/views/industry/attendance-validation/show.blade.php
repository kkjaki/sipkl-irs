@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10 pb-10 w-full" x-data="{
        successAlert: false,
        activeFilter: 'all',
        tempFilter: 'all',
        showFilterModal: false
    }" @success-modal.window="successAlert = true">

        {{-- Header Halaman --}}
        <header>
            <div class="py-6 text-left">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Validasi Presensi Siswa') }}
                </h2>
            </div>
        </header>

        {{-- Section 1: Data Sekolah --}}
        <section class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex items-center text-white">
                <x-heroicon-o-building-library class="w-6 h-6 mr-2.5 opacity-90" />
                <h3 class="text-lg font-bold m-0 leading-none">Informasi Instansi</h3>
            </div>
            <div class="p-6">
                <div class="max-w-md">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Sekolah / Instansi</label>
                    <input type="text" readonly value="{{ $school->nama_sekolah ?? $school->name }}"
                        class="block w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 font-bold py-3 px-4 shadow-inner cursor-not-allowed">
                </div>
            </div>
        </section>

        {{-- Section 2: Daftar Siswa & Filter --}}
        <article class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            
            {{-- Header Wadah dengan Filter --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex justify-between items-center text-white relative">
                <div class="flex items-center gap-2.5">
                    <x-heroicon-o-users class="w-6 h-6 shrink-0" />
                    <h2 class="font-bold text-lg m-0">Daftar Kehadiran</h2>
                </div>

                {{-- Dropdown Filter --}}
                <div class="relative">
                    <button @click="showFilterModal = !showFilterModal" @click.away="showFilterModal = false"
                        class="flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 border border-white/20 rounded-xl text-sm font-bold transition-all shadow-sm">
                        <x-heroicon-o-funnel class="w-4 h-4" />
                        <span>Filter Status</span>
                    </button>

                    <div x-show="showFilterModal" x-cloak
                        x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="absolute top-full right-0 mt-3 w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 text-gray-800 overflow-hidden">
                        
                        <div class="p-4 border-b border-gray-50">
                            <h4 class="font-black text-xs uppercase tracking-widest text-gray-400">Filter Kehadiran</h4>
                        </div>

                        <div class="p-5 flex flex-wrap gap-2">
                            @foreach(['hadir', 'izin', 'sakit', 'alpa'] as $status)
                                <button @click="tempFilter = '{{ $status }}'"
                                    :class="tempFilter === '{{ $status }}' ? 'bg-teal-600 text-white shadow-md shadow-teal-100' : 'bg-gray-50 text-gray-600 hover:bg-gray-100'"
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

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($students as $student)
                        @php
                            $attendance = $student->attendances->first();
                            $statusRaw = $attendance ? strtolower($attendance->status) : 'alpa';
                            $statusDisplay = $attendance ? ucfirst($attendance->status) : 'Belum Absen';
                        @endphp
                        
                        <section class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 p-6 relative group"
                            x-show="activeFilter === 'all' || activeFilter === '{{ $statusRaw }}'"
                            x-data="{ showModal: false, statusUpdate: '{{ $statusRaw }}' }">

                            {{-- Status Button Polos --}}
                            <div class="absolute top-6 right-6">
                                <button @click="showModal = true" class="focus:outline-none group/badge">
                                    @php
                                        $textColor = match ($statusRaw) {
                                            'hadir' => 'text-green-600',
                                            'izin', 'sakit' => 'text-blue-600',
                                            'alpa' => 'text-rose-600',
                                            'terlambat' => 'text-amber-600',
                                            default => 'text-gray-500',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 text-[10px] font-black uppercase tracking-widest {{ $textColor }} flex items-center gap-1 group-hover/badge:bg-gray-100 rounded-lg transition-all">
                                        {{ $statusDisplay }}
                                        <x-heroicon-o-chevron-down class="w-3 h-3" />
                                    </span>
                                </button>
                            </div>

                            <div class="pr-12">
                                <h3 class="text-xl font-black text-gray-900 group-hover:text-teal-600 transition-colors">
                                    {{ $student->user->name ?? '-' }}
                                </h3>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1 mb-5">NIS: {{ $student->nis ?? '-' }}</p>

                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 mb-6 group-hover:bg-white transition-colors relative overflow-hidden">
                                    <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
                                    <div class="flex items-center gap-3">
                                        <x-heroicon-o-clock class="w-4 h-4 text-blue-500" />
                                        <div class="text-xs font-bold text-gray-600">
                                            @if ($attendance && $attendance->check_in)
                                                Check In: <span class="text-gray-900">{{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }} WIB</span>
                                            @else
                                                <span class="italic text-gray-400">Data absen belum terekam</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer Aksi --}}
                            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                @if ($attendance && $attendance->image)
                                    <a href="{{ Storage::url($attendance->image) }}" target="_blank"
                                        class="flex items-center gap-2 text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-lg transition-all border border-blue-100">
                                        <x-heroicon-o-camera class="w-4 h-4" /> Bukti Foto
                                    </a>
                                @else
                                    <span class="flex items-center gap-2 text-[10px] font-bold text-gray-300 px-4 py-2 border border-dashed border-gray-200 rounded-lg">
                                        <x-heroicon-o-no-symbol class="w-4 h-4" /> Tidak Ada Foto
                                    </span>
                                @endif
                            </div>

                            {{-- Modal Ubah Status --}}
                            <div x-cloak x-show="showModal" class="fixed inset-0 z-[9999] overflow-y-auto">
                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"></div>
                                    <div class="bg-white rounded-2xl p-6 w-full max-w-md relative z-[10000] shadow-2xl" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
                                        <h3 class="text-xl font-black text-gray-900 mb-2">Ubah Kehadiran</h3>
                                        <p class="text-xs text-gray-500 mb-6 font-medium">Instansi: {{ $school->name }}</p>
                                        
                                        <div class="mb-8">
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Status Baru</label>
                                            <select x-model="statusUpdate" class="w-full rounded-xl border-gray-200 bg-gray-50 py-3 px-4 font-bold text-gray-800 focus:ring-teal-500 transition-all">
                                                <option value="hadir">Hadir</option>
                                                <option value="terlambat">Terlambat</option>
                                                <option value="izin">Izin</option>
                                                <option value="sakit">Sakit</option>
                                                <option value="alpa">Alpa</option>
                                            </select>
                                        </div>

                                        <div class="flex gap-3">
                                            <button @click="showModal = false" class="flex-1 px-4 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                                            <button @click="updateAttendance({{ $student->id }}, {{ $sessionId }}, statusUpdate); showModal = false" class="flex-1 px-4 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-lg hover:bg-teal-700 active:scale-95 transition-all">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @empty
                        <div class="col-span-full py-20 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                            <x-heroicon-o-user-minus class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                            <p class="text-gray-500 font-bold text-lg uppercase tracking-widest">Belum ada siswa magang</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $students->links() }}
                </div>
            </div>
        </article>

        {{-- SUCCESS ALERT MODAL --}}
        <div x-cloak x-show="successAlert" class="fixed inset-0 z-[10001] flex items-center justify-center px-4" style="display: none;">
            <div x-show="successAlert" 
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="successAlert = false; location.reload();"></div>
            
            <div x-show="successAlert"
                x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-4"
                class="relative bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full text-center border border-gray-100">
                
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                    <x-heroicon-s-check-circle class="h-12 w-12 text-green-600" />
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2">Berhasil!</h3>
                <p class="text-sm text-gray-500 font-medium leading-relaxed mb-8">Data kehadiran siswa telah diperbarui dan disimpan ke sistem.</p>
                <button @click="successAlert = false; location.reload();" class="w-full py-4 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl shadow-lg transition-all active:scale-95 focus:outline-none">Tutup</button>
            </div>
        </div>
    </main>

    <script>
        function updateAttendance(studentId, sessionId, status) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let updateUrl = "{{ route('attendance.validate.update', ':id') }}".replace(':id', sessionId);

            const payload = { updates: [{ student_id: studentId, status: status }] };

            fetch(updateUrl, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(res => res.ok ? res.json() : Promise.reject())
            .then(() => { 
                window.dispatchEvent(new Event('success-modal'));
            })
            .catch(() => {
                console.error('Update failed');
            });
        }
    </script>

    <style> [x-cloak] { display: none !important; } </style>
@endsection