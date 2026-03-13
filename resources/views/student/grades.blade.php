<x-app-layout>
    <div class="min-h-screen bg-brand-bg px-10">
        {{-- Header --}}
        <header>
            <div
                class="w-full py-6 flex justify-between items-center">
                <div>
                    <h2
                        class="font-extrabold text-3xl text-gray-800 leading-tight">
                        {{ __('Nilai') }}
                    </h2>
                    <p class="text-gray-600 mt-2">
                        Daftar nilai penilaian Anda
                    </p>
                </div>
                @if($gradeCount > 0)
                <a href="{{ route('student.nilai.download') }}"
                    class="bg-brand-primary hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 flex items-center gap-2">
                    <i class="fas fa-file-pdf"></i>
                    Download PDF
                </a>
                @endif
            </div>
        </header>

        @if($gradeCount > 0)
        {{-- Statistics Cards --}}
        <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            {{-- Average Score --}}
            <div
                class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 p-6">
                <div
                    class="flex items-center justify-between">
                    <div>
                        <p
                            class="text-gray-600 text-sm font-medium">
                            Rata-rata</p>
                        <p
                            class="text-3xl font-bold text-brand-primary mt-1">
                            {{ number_format($averageScore,
                            1) }}
                        </p>
                    </div>
                    <div
                        class="bg-brand-primary bg-opacity-10 p-3 rounded-full">
                        <x-heroicon-s-academic-cap
                            class="w-8 h-8 text-brand-primary" />
                    </div>
                </div>
            </div>

            {{-- Highest Score --}}
            <div
                class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 p-6">
                <div
                    class="flex items-center justify-between">
                    <div>
                        <p
                            class="text-gray-600 text-sm font-medium">
                            Tertinggi</p>
                        <p
                            class="text-3xl font-bold text-green-600 mt-1">
                            {{ $highestScore }}
                        </p>
                    </div>
                    <div
                        class="bg-green-100 p-3 rounded-full">
                        <x-heroicon-s-trophy
                            class="w-8 h-8 text-green-600" />
                    </div>
                </div>
            </div>

            {{-- Lowest Score --}}
            <div
                class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 p-6">
                <div
                    class="flex items-center justify-between">
                    <div>
                        <p
                            class="text-gray-600 text-sm font-medium">
                            Terendah</p>
                        <p
                            class="text-3xl font-bold text-red-600 mt-1">
                            {{ $lowestScore }}
                        </p>
                    </div>
                    <div
                        class="bg-red-100 p-3 rounded-full">
                        <x-heroicon-s-arrow-down
                            class="w-8 h-8 text-red-600" />
                    </div>
                </div>
            </div>

            {{-- Total Grades --}}
            <div
                class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 p-6">
                <div
                    class="flex items-center justify-between">
                    <div>
                        <p
                            class="text-gray-600 text-sm font-medium">
                            Total Kriteria</p>
                        <p
                            class="text-3xl font-bold text-blue-600 mt-1">
                            {{ $gradeCount }}
                        </p>
                    </div>
                    <div
                        class="bg-blue-100 p-3 rounded-full">
                        <x-heroicon-s-clipboard-document-list
                            class="w-8 h-8 text-blue-600" />
                    </div>
                </div>
            </div>
        </div>



        {{-- Grades Table --}}
        <div
            class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr
                            class="border-b-2 border-gray-200 bg-gray-50">
                            <th
                                class="py-4 px-6 text-gray-700 font-semibold">
                                No</th>
                            <th
                                class="py-4 px-6 text-gray-700 font-semibold">
                                Kriteria Penilaian</th>
                            <th
                                class="py-4 px-6 text-gray-700 font-semibold">
                                Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $index =>
                        $grade)
                        <tr
                            class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td
                                class="py-4 px-6 text-gray-800 font-medium">
                                {{ $index + 1 }}</td>
                            <td
                                class="py-4 px-6 text-gray-800">
                                {{ $grade->criterion->name
                                ?? '-' }}
                                @if($grade->criterion->description)
                                <p
                                    class="text-gray-500 text-sm mt-1">
                                    {{
                                    \Illuminate\Support\Str::limit($grade->criterion->description,
                                    80) }}</p>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span
                                    class="text-2xl font-bold {{ $grade->score >= 90 ? 'text-green-600' : ($grade->score >= 80 ? 'text-blue-600' : ($grade->score >= 70 ? 'text-yellow-600' : 'text-red-600')) }}">
                                    {{ $grade->score }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr
                            class="border-t-2 border-gray-200 bg-brand-primary bg-opacity-5">
                            <td colspan="2"
                                class="py-4 px-6 text-gray-800 font-bold text-right">
                                Rata-rata Keseluruhan
                            </td>
                            <td colspan="2"
                                class="py-4 px-6">
                                <span
                                    class="text-2xl font-bold text-brand-primary">
                                    {{
                                    number_format($averageScore,
                                    1) }}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @else
        {{-- No Grades --}}
        <div
            class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 p-10 text-center">
            <x-heroicon-s-academic-cap
                class="w-20 h-20 text-gray-400 mx-auto mb-4" />
            <h3
                class="text-xl font-semibold text-gray-800 mb-2">
                Belum Ada Nilai</h3>
            <p class="text-gray-600">
                Nilai Anda belum tersedia. Silakan tunggu
                mentor atau pembimbing industri untuk
                melakukan penilaian.
            </p>
        </div>
        @endif
    </div>
</x-app-layout>