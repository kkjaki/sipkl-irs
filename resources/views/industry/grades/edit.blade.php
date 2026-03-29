@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header Wadah -->
        <div
            class="bg-gradient-to-r from-teal-500 to-teal-600 p-4 rounded-t-xl shadow-sm text-white mb-6 flex justify-between items-center">
            <h2 class="text-xl font-bold m-0">Tambah Penilaian Siswa</h2>
            <a href="{{ route('grades.schools.show', $school->id) }}"
                class="text-white hover:text-teal-200 text-sm font-medium transition-colors">
                &larr; Kembali
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profil Siswa Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 text-lg mb-4 border-b pb-2">Profil Siswa</h3>
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
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <form method="POST" action="{{ route('grades.schools.update', [$school->id, $student->id]) }}">
                        @csrf
                        @method('PUT')

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
                                                    class="score-input w-full border border-gray-300 rounded-lg p-2 text-center focus:ring-brand-primary focus:border-brand-primary transition-colors"
                                                    min="0" max="100" required>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50 border-t border-gray-100">
                                    <tr>
                                        <td colspan="2" class="p-4 text-right font-bold text-gray-700">NILAI AKHIR :</td>
                                        <td class="p-4 text-center">
                                            <span id="final-score" class="font-black text-2xl text-brand-primary">0</span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="p-6 bg-white border-t border-gray-100 flex justify-end gap-3">
                            <a href="{{ route('grades.schools.show', $school->id) }}"
                                class="px-5 py-2.5 rounded-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-5 py-2.5 rounded-lg font-medium text-white bg-brand-primary hover:bg-teal-700 transition-colors shadow-sm">
                                Simpan Penilaian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
