@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Data Sekolah -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="bg-brand-primary p-4 flex items-center gap-3 text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <h1 class="text-xl font-bold m-0 leading-none">Data Sekolah</h1>
        </div>
        <div class="p-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Sekolah</label>
            <div class="bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-3 cursor-default">
                {{ $school->name }}
            </div>
        </div>
    </div>

    <!-- Wadah Utama -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6"
         x-data="{ 
             activeFilter: 'all', 
             tempFilter: 'all', 
             showFilterModal: false 
         }">
        <!-- Header Wadah -->
        <div class="bg-brand-primary text-white p-4 flex justify-between items-center relative rounded-t-xl">
            <h2 class="text-lg font-semibold m-0">Daftar Riwayat Kehadiran Siswa</h2>
            
            <!-- Tombol Filter -->
            <button @click="showFilterModal = true" class="flex items-center gap-2 px-3 py-1.5 bg-white/10 hover:bg-white/20 border border-white/20 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>

            <!-- Modal/Popover Filter -->
            <div x-show="showFilterModal" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-2"
                 @click.away="showFilterModal = false"
                 class="absolute top-full right-4 mt-2 w-72 bg-white rounded-xl shadow-xl border border-gray-100 z-40 text-gray-800"
                 style="display: none;">
                
                <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900">Filter Kehadiran</h3>
                    <button @click="showFilterModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-4">
                    <p class="text-sm font-medium text-gray-700 mb-3">Kategori</p>
                    <div class="flex flex-wrap gap-2">
                        <button @click="tempFilter = 'hadir'" 
                                :class="tempFilter === 'hadir' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors">
                            Hadir
                        </button>
                        <button @click="tempFilter = 'izin'" 
                                :class="tempFilter === 'izin' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors">
                            Izin
                        </button>
                        <button @click="tempFilter = 'sakit'" 
                                :class="tempFilter === 'sakit' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors">
                            Sakit
                        </button>
                        <button @click="tempFilter = 'alpa'" 
                                :class="tempFilter === 'alpa' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors">
                            Alpa
                        </button>
                    </div>
                </div>

                <div class="p-4 border-t border-gray-100 flex justify-between items-center bg-gray-50 rounded-b-xl">
                    <button @click="tempFilter = 'all'; activeFilter = 'all'; showFilterModal = false" 
                            class="px-4 py-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
                        Hapus
                    </button>
                    <button @click="activeFilter = tempFilter; showFilterModal = false" 
                            class="px-4 py-2 text-sm font-medium text-white bg-brand-primary hover:bg-teal-700 rounded-lg transition-colors">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Grid Layout foreach Attendance -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                @forelse($attendances as $attendance)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative" 
                         x-show="activeFilter === 'all' || activeFilter === '{{ strtolower($attendance->status) }}'"
                         x-data="{ 
                             showModal: false, 
                             statusUpdate: '{{ $attendance->status }}' 
                         }">
                        
                        <!-- Badges Modal Trigger -->
                        <button @click="showModal = true" class="absolute top-4 right-4 focus:outline-none">
                            @php
                                $badgeClass = match(strtolower($attendance->status)) {
                                    'hadir' => 'bg-green-100 text-green-800 border-green-200',
                                    'izin', 'sakit' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'alpa' => 'bg-red-100 text-red-800 border-red-200',
                                    default => 'bg-gray-100 text-gray-800 border-gray-200'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeClass }} transition-colors hover:opacity-80">
                                {{ ucfirst($attendance->status) }}
                                <svg class="w-4 h-4 ml-1.5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </button>

                        <div class="pr-16">
                            <!-- Badge Tanggal Sesi -->
                            <div class="flex items-center gap-2 bg-blue-50/50 border border-blue-100/50 rounded-lg p-2 mb-3 w-max">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-blue-700/80 font-semibold text-xs">TANGGAL SESI:</span>
                                <span class="text-blue-900 font-bold text-sm">{{ \Carbon\Carbon::parse($attendance->session->session_date ?? $attendance->session->created_at)->translatedFormat('l, d F Y') }}</span>
                            </div>

                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $attendance->student->user->name ?? 'Nama Siswa Tidak Ditemukan' }}</h3>
                            
                            <div class="text-sm text-gray-600 space-y-1 mb-4">
                                <p>NIS: <span class="font-medium">{{ $attendance->student->nis ?? '-' }}</span></p>
                                @if($attendance->check_in)
                                    <p>Waktu Check In: <span class="font-medium">{{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }} WIB</span></p>
                                @else
                                    <p>Waktu Check In: <span class="italic text-gray-400">Belum Check In</span></p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            @if($attendance->image)
                                <a href="{{ Storage::url($attendance->image) }}" target="_blank" 
                                   class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Lihat Bukti Presensi
                                </a>
                            @else
                                <span class="inline-flex items-center text-sm text-gray-400 cursor-not-allowed font-medium" title="Bukti Presensi Tidak Tersedia">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Bukti Presensi Kosong
                                </span>
                            @endif
                        </div>

                        <!-- Modal Konfirmasi -->
                        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50 break-words" style="display: none;">
                            <div x-show="showModal" 
                                 x-transition:enter="transition ease-out duration-300 transform"
                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                 x-transition:leave="transition ease-in duration-200 transform"
                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                 @click.away="showModal = false"
                                 class="bg-white rounded-xl shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6 m-4 relative z-50">
                                 
                                 <h3 class="text-lg font-bold text-gray-900 mb-4">Ubah Status Kehadiran</h3>
                                 <p class="text-sm text-gray-500 mb-4">Siswa: <span class="font-semibold">{{ $attendance->student->user->name ?? '-' }}</span></p>

                                 <div class="mb-5">
                                     <label class="block text-sm font-medium text-gray-700 mb-1">Status Kehadiran</label>
                                     <select x-model="statusUpdate" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary focus:ring-opacity-50">
                                        <option value="hadir">Hadir</option>
                                        <option value="izin">Izin</option>
                                        <option value="sakit">Sakit</option>
                                        <option value="alpa">Alpa</option>
                                     </select>
                                 </div>

                                 <div class="flex justify-end gap-3 mt-6">
                                     <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md transition-colors">
                                         Batal
                                     </button>
                                     <button type="button" @click="updateAttendance({{ $attendance->student_id }}, {{ $attendance->attendance_session_id }}, statusUpdate)" class="px-4 py-2 bg-brand-primary hover:bg-teal-700 text-white text-sm font-medium rounded-md transition-colors">
                                         Simpan Perubahan
                                     </button>
                                 </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center p-8 bg-gray-50 rounded-xl text-center">
                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <p class="text-gray-500 font-medium">Belum ada riwayat presensi siswa untuk sekolah ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Navigasi Pagination -->
            <div class="mt-6">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Script Update Attendance Menggunakan Fetch API -->
<script>
    function updateAttendance(studentId, sessionId, status) {
        // Ambil elemen Meta CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let updateUrl = "{{ route('attendance.validate.update', '_session_') }}";
        updateUrl = updateUrl.replace('_session_', sessionId);

        // Atur payload
        const payload = {
            updates: [
                {
                    student_id: studentId,
                    status: status
                }
            ]
        };

        // Mulai Fetch Request
        fetch(updateUrl, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if(data.status === 'success') {
                alert('Status presensi berhasil diubah!');
                window.location.reload(); // Reload untuk memperbarui tampilan badge
            } else {
                alert('Gagal mengubah status: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan data.');
        });
    }
</script>
@endsection
