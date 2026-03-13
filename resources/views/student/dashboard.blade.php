<x-app-layout>
    <div class="min-h-screen bg-brand-bg px-10">

        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-extrabold text-3xl text-gray-800 leading-tight">
                    {{ __('Dashboard Siswa') }}
                </h2>
            </div>
        </header>

        {{-- Profil Siswa --}}
        <div class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 px-5 py-5 mb-6">
            <div class="bg-brand-primary text-white p-4 font-bold text-lg rounded-t-xl">
                Profil Siswa
            </div>
            <div class="p-4">
                <div class="space-y-2">
                    <div class="flex border-b py-2">
                        <span class="w-44 font-medium text-gray-700">Nama</span>
                        <span class="mx-2">:</span>
                        <span class="flex-1 text-gray-900">{{ $user->name }}</span>
                    </div>
                    <div class="flex border-b py-2">
                        <span class="w-44 font-medium text-gray-700">NIS</span>
                        <span class="mx-2">:</span>
                        <span class="flex-1 text-gray-900">{{ $student->nis ?? '-' }}</span>
                    </div>
                    <div class="flex border-b py-2">
                        <span class="w-44 font-medium text-gray-700">Kelas</span>
                        <span class="mx-2">:</span>
                        <span class="flex-1 text-gray-900">{{ $student->class ?? '-' }}</span>
                    </div>
                    <div class="flex border-b py-2">
                        <span class="w-44 font-medium text-gray-700">Sekolah</span>
                        <span class="mx-2">:</span>
                        <span class="flex-1 text-gray-900">{{ $student->school->name ?? '-' }}</span>
                    </div>
                    <div class="flex border-b py-2">
                        <span class="w-44 font-medium text-gray-700">Guru Pembimbing</span>
                        <span class="mx-2">:</span>
                        <span class="flex-1 text-gray-900">{{ $student->schoolSupervisor->name ?? '-' }}</span>
                    </div>
                    <div class="flex border-b py-2">
                        <span class="w-44 font-medium text-gray-700">Telepon</span>
                        <span class="mx-2">:</span>
                        <span class="flex-1 text-gray-900">{{ $student->phone ?? '-' }}</span>
                    </div>
                    <div class="flex border-b py-2">
                        <span class="w-44 font-medium text-gray-700">Alamat</span>
                        <span class="mx-2">:</span>
                        <span class="flex-1 text-gray-900">{{ $student->address ?? '-' }}</span>
                    </div>
                    <div class="flex py-2">
                        <span class="w-44 font-medium text-gray-700">Hobi</span>
                        <span class="mx-2">:</span>
                        <span class="flex-1 text-gray-900">{{ $student->hobby ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Program Magang --}}
        @if($student && $student->internshipProgram)
        <div class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 px-5 py-5 mb-6">
            <div class="bg-brand-primary text-white p-4 font-bold text-lg rounded-t-xl">
                Program Magang
            </div>
            <div class="p-4">
                <div class="space-y-2">
                    <div class="flex border-b py-2">
                        <span class="w-44 font-medium text-gray-700">Nama Program</span>
                        <span class="mx-2">:</span>
                        <span class="flex-1 text-gray-900">{{ $student->internshipProgram->name }}</span>
                    </div>
                    <div class="flex border-b py-2">
                        <span class="w-44 font-medium text-gray-700">Industri</span>
                        <span class="mx-2">:</span>
                        <span class="flex-1 text-gray-900">{{ $student->internshipProgram->industry->name ?? '-' }}</span>
                    </div>
                    <div class="flex py-2">
                        <span class="w-44 font-medium text-gray-700">Periode</span>
                        <span class="mx-2">:</span>
                        <span class="flex-1 text-gray-900">
                            {{ $student->internshipProgram->start_date->format('d M Y') }}
                            —
                            {{ $student->internshipProgram->end_date->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Ringkasan Kehadiran --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            {{-- Hadir --}}
            <div class="w-full h-40 px-7 py-5 bg-white rounded-xl shadow-md outline outline-1 outline-offset-[-1px] outline-gray-300 inline-flex justify-center items-center gap-2.5">
                <div class="flex-1 inline-flex flex-col justify-start items-start gap-2.5">
                    <div class="text-neutral-800 text-xl font-extrabold leading-7">Jumlah Hadir</div>
                    <div class="text-green-600 text-3xl font-bold leading-7">{{ $attendanceCounts['hadir'] }}</div>
                </div>
                <div class="px-3 inline-flex flex-col justify-center items-center gap-2.5 overflow-hidden">
                    <x-heroicon-s-check-circle class="w-12 h-12 text-green-500" />
                </div>
            </div>

            {{-- Izin/Sakit --}}
            <div class="w-full h-40 px-7 py-5 bg-white rounded-xl shadow-md outline outline-1 outline-offset-[-1px] outline-gray-300 inline-flex justify-center items-center gap-2.5">
                <div class="flex-1 inline-flex flex-col justify-start items-start gap-2.5">
                    <div class="text-neutral-800 text-xl font-extrabold leading-7">Izin/Sakit</div>
                    <div class="text-blue-600 text-3xl font-bold leading-7">{{ $attendanceCounts['izin_sakit'] }}</div>
                </div>
                <div class="px-3 inline-flex flex-col justify-center items-center gap-2.5 overflow-hidden">
                    <x-heroicon-s-document-text class="w-12 h-12 text-blue-500" />
                </div>
            </div>

            {{-- Terlambat --}}
            <div class="w-full h-40 px-7 py-5 bg-white rounded-xl shadow-md outline outline-1 outline-offset-[-1px] outline-gray-300 inline-flex justify-center items-center gap-2.5">
                <div class="flex-1 inline-flex flex-col justify-start items-start gap-2.5">
                    <div class="text-neutral-800 text-xl font-extrabold leading-7">Terlambat</div>
                    <div class="text-yellow-600 text-3xl font-bold leading-7">{{ $attendanceCounts['terlambat'] }}</div>
                </div>
                <div class="px-3 inline-flex flex-col justify-center items-center gap-2.5 overflow-hidden">
                    <x-heroicon-s-clock class="w-12 h-12 text-yellow-500" />
                </div>
            </div>

            {{-- Tidak Hadir --}}
            <div class="w-full h-40 px-7 py-5 bg-white rounded-xl shadow-md outline outline-1 outline-offset-[-1px] outline-gray-300 inline-flex justify-center items-center gap-2.5">
                <div class="flex-1 inline-flex flex-col justify-start items-start gap-2.5">
                    <div class="text-neutral-800 text-xl font-extrabold leading-7">Tidak Hadir</div>
                    <div class="text-red-600 text-3xl font-bold leading-7">{{ $attendanceCounts['tidak_hadir'] }}</div>
                </div>
                <div class="px-3 inline-flex flex-col justify-center items-center gap-2.5 overflow-hidden">
                    <x-heroicon-s-x-circle class="w-12 h-12 text-red-500" />
                </div>
            </div>
        </div>

        {{-- Nilai --}}
        @if($grades->count() > 0)
        <div class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 px-5 py-5 mb-6">
            <div class="bg-brand-primary text-white p-4 font-bold text-lg rounded-t-xl">
                Nilai
            </div>
            <div class="p-4">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="py-3 px-4 text-gray-700 font-semibold">No</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold">Kriteria</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold">Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $index => $grade)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-3 px-4 text-gray-800">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 text-gray-800">{{ $grade->criterion->name ?? '-' }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $grade->score >= 80 ? 'bg-green-100 text-green-800' : ($grade->score >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $grade->score }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-gray-200">
                            <td colspan="2" class="py-3 px-4 text-gray-800 font-bold">Rata-rata</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-brand-primary text-white">
                                    {{ number_format($grades->avg('score'), 1) }}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @endif

        {{-- Daftar Logbook --}}
        <div class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 px-5 py-5">
            <div class="flex justify-between items-center bg-brand-primary text-white p-4 font-bold text-lg rounded-t-xl">
                <span>Daftar Logbook</span>
                <a href="{{ route('student.logbook.index') }}" class="text-sm bg-white text-brand-primary px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                    Lihat Semua
                </a>
            </div>
            <div class="p-4">
                @if($recentLogbooks->count() > 0)
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="py-3 px-4 text-gray-700 font-semibold">No</th>
                                <th class="py-3 px-4 text-gray-700 font-semibold">Tanggal</th>
                                <th class="py-3 px-4 text-gray-700 font-semibold">Mentor</th>
                                <th class="py-3 px-4 text-gray-700 font-semibold">Status</th>
                                <th class="py-3 px-4 text-gray-700 font-semibold">Kegiatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentLogbooks as $index => $logbook)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="py-3 px-4 text-gray-800">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 text-gray-800">
                                    {{ date('d M Y', strtotime($logbook->created_at)) }}
                                    <div class="text-gray-500 text-sm">
                                        {{ date('H:i', strtotime($logbook->created_at)) }}
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-gray-800">
                                    {{ $logbook->mentor->name ?? '-' }}
                                </td>
                                <td class="py-3 px-4">
                                    @if($logbook->status === 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                            Menunggu
                                        </span>
                                    @elseif($logbook->status === 'approved')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                            Disetujui
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-gray-600 max-w-xs">
                                    {{ \Illuminate\Support\Str::limit($logbook->notes, 80) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-10">
                        <x-heroicon-s-book-open class="w-16 h-16 text-gray-400 mx-auto mb-4" />
                        <p class="text-gray-600">Belum ada logbook</p>
                        <a href="{{ route('student.logbook.harian') }}" class="inline-block mt-4 px-4 py-2 bg-brand-primary text-white rounded-lg hover:bg-teal-600 transition">
                            Buat Logbook Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
