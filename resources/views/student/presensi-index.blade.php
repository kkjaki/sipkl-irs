<x-app-layout>
    <div class="min-h-screen bg-brand-bg px-10">
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

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b-2 border-gray-200 bg-gray-50">
                            <th class="py-4 px-6 text-gray-700 font-semibold">No</th>
                            <th class="py-4 px-6 text-gray-700 font-semibold">Industri</th>
                            <th class="py-4 px-6 text-gray-700 font-semibold">Tanggal</th>
                            <th class="py-4 px-6 text-gray-700 font-semibold">Waktu</th>
                            <th class="py-4 px-6 text-gray-700 font-semibold">Status</th>
                            <th class="py-4 px-6 text-gray-700 font-semibold">Catatan</th>
                            <th class="py-4 px-6 text-gray-700 font-semibold">Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances->items() as $index => $attendance)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-4 px-6 text-gray-800">{{ ($attendances->currentPage() - 1) * $attendances->perPage() + $index + 1 }}</td>
                            <td class="py-4 px-6 text-gray-800">
                                {{ $attendance->session->industry->name }}
                            </td>
                            <td class="py-4 px-6 text-gray-800">
                                {{ date('d F Y', strtotime($attendance->check_in)) }}
                            </td>
                            <td class="py-4 px-6 text-gray-800">
                                {{ date('H:i:s', strtotime($attendance->check_in)) }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $attendance->status === 'hadir' ? 'bg-green-100 text-green-800' :
                                       ($attendance->status === 'izin' ? 'bg-blue-100 text-blue-800' :
                                       ($attendance->status === 'sakit' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-gray-600 max-w-xs truncate">
                                {{ $attendance->notes ?? '-' }}
                            </td>
                            <td class="py-4 px-6">
                                @if($attendance->image)
                                    <a href="{{ asset('storage/' . $attendance->image) }}"
                                       target="_blank"
                                       class="text-brand-primary hover:text-teal-600 transition">
                                        <x-heroicon-s-photo class="w-6 h-6" />
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <x-heroicon-s-calendar class="w-16 h-16 text-gray-300 mb-4" />
                                    <p class="text-lg font-medium">Belum ada data presensi</p>
                                    <p class="text-sm mt-2">Mulai lakukan presensi harian Anda</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($attendances->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                <div class="text-gray-600 text-sm">
                    Menampilkan {{ $attendances->firstItem() }} sampai {{ $attendances->lastItem() }}
                    dari {{ $attendances->total() }} data
                </div>
                {{ $attendances->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
