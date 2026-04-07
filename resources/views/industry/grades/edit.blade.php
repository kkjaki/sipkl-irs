@extends('layouts.app')
@section('title', 'Tambah Penilaian Siswa')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header Wadah -->
        <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex items-center text-white rounded-t-xl">
            <x-heroicon-o-pencil-square class="w-6 h-6 mr-2.5 opacity-90" />
            <h3 class="text-lg font-bold m-0 leading-none">Tambah Penilaian Siswa</h3>
        </div>

      {{-- MODAL ALERT SUKSES --}}
@if (session('success'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-cloak 
         class="fixed inset-0 z-[10002] flex items-center justify-center px-4">
        
        {{-- Backdrop Blur --}}
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="show = false"></div>
        
        {{-- Container Modal (Ukuran max-w-sm biar nggak kekurusan/kegendutan) --}}
        <div class="relative bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full text-center border border-gray-100"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100">
            
            {{-- Icon Centang Gede --}}
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                <x-heroicon-s-check-circle class="h-12 w-12 text-green-600" />
            </div>
            
            <h3 class="text-2xl font-black text-gray-900 mb-2">Berhasil!</h3>
            <p class="text-sm text-gray-500 font-medium leading-relaxed mb-8">
                {{ session('success') }}
            </p>
            
            {{-- Tombol Mantap (w-full biar gagah) --}}
            <button @click="show = false" 
                class="w-full py-4 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl shadow-lg transition-all active:scale-95">
                Mantap!
            </button>
        </div>
    </div>
@endif

{{-- Pastikan CSS x-cloak ada biar gak kedip --}}
<style>
    [x-cloak] { display: none !important; }
</style>

        <div class="bg-white p-8 rounded-b-xl shadow-sm border-x border-b border-gray-100 mb-10">
            <form method="POST" action="{{ route('grades.schools.update', [$school->id, $student->id]) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profil Siswa Card -->
                <div class="lg:col-span-1">
                    <div class="border border-gray-200 rounded-xl p-6">
                    <h3 class="font-bold text-gray-800 text-lg mb-4 border-b pb-2 flex items-center gap-2">
                        <x-heroicon-o-user-circle class="w-6 h-6 text-gray-700" />
                        Profil Siswa
                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <span class="block text-sm text-gray-500">NIS</span>
                            <span class="font-semibold text-gray-800">{{ $student->nis ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="block text-sm text-gray-500">Nama</span>
                            <span class="font-semibold text-gray-800">{{ $student->user->name ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="block text-sm text-gray-500">Kelas</span>
                            <span class="font-semibold text-gray-800">{{ $student->class ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="block text-sm text-gray-500">Sekolah</span>
                            <span class="font-semibold text-gray-800">{{ $school->name }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Form Tabel Penilaian -->
            <div class="lg:col-span-2">
                <div class="border border-gray-200 rounded-xl p-6 overflow-hidden">
                    <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-100">
                                        <th class="p-4 font-semibold text-gray-600 text-sm w-16 text-center">No</th>
                                        <th class="p-4 font-semibold text-gray-600 text-sm">Kriteria Penilaian</th>
                                        <th class="p-4 font-semibold text-gray-600 text-sm w-32 text-center">Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grades as $index => $grade)
                                        @php
                                            // Cari nama kriteria dari list criterion yg di-pass dari controller
                                            $critName =
                                                $criterion->firstWhere('id', $grade->criteria_id)->name ??
                                                'Kriteria tidak diketahui';
                                        @endphp
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="p-4 text-center text-gray-500 text-sm">{{ $loop->iteration }}</td>
                                            <td class="p-4 text-gray-800 font-medium">{{ $critName }}</td>
                                            <td class="p-4">
                                                <input type="hidden" name="grades[{{ $index }}][id]"
                                                    value="{{ $grade->id }}">
                                                <input type="number" name="grades[{{ $index }}][score]"
                                                    value="{{ $grade->score }}"
                                                    class="score-input w-full border border-gray-300 rounded-lg p-2 text-center focus:ring-teal-500 focus:border-teal-500 transition-colors"
                                                    min="0" max="100" required>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50 border-t border-gray-100">
                                    <tr>
                                        <td colspan="2" class="p-4 text-right font-bold text-gray-700">NILAI AKHIR :</td>
                                        <td class="p-4 text-center">
                                            <span id="final-score" class="font-bold text-2xl text-teal-600">0</span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 flex justify-between items-center">
                {{-- Tombol Kembali --}}
                <a href="{{ route('grades.schools.show', $school->id) }}"
                    class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2.5 rounded-lg font-medium transition-colors">
                    <x-heroicon-o-arrow-left class="w-4 h-4" />
                    Kembali
                </a>

                <div class="flex gap-4">
                    <button type="button"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2.5 rounded-lg font-medium transition-colors">
                        Batal
                    </button>
                    {{-- Button Simpan Solid Teal --}}
                    <button type="submit"
                        class="bg-teal-500 hover:bg-teal-600 text-white font-bold px-6 py-2.5 rounded-lg shadow-sm transition-colors">
                        Simpan Penilaian
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scoreInputs = document.querySelectorAll('.score-input');
            const finalScoreDisplay = document.getElementById('final-score');

            function calculateAverage() {
                let total = 0;
                let count = scoreInputs.length;

                if (count === 0) return;

                scoreInputs.forEach(input => {
                    let val = parseFloat(input.value) || 0;
                    total += val;
                });

                let average = total / count;
                finalScoreDisplay.textContent = Math.round(average); // Membulatkan nilai
            }

            // Kalkulasi awal saat halaman dimuat
            calculateAverage();

            // Tambahkan event listener ke setiap input
            scoreInputs.forEach(input => {
                input.addEventListener('input', calculateAverage);
            });
        });
    </script>
@endsection
