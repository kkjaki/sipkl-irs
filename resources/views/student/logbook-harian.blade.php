<x-app-layout>
    <div class="min-h-screen bg-brand-bg px-10">
        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-extrabold text-3xl text-gray-800 leading-tight">
                    {{ __('Logbook Harian') }}
                </h2>
                <p class="text-gray-600 mt-2">
                    {{ date('d F Y', strtotime(now())) }}
                </p>
            </div>
        </header>

        @if($existingLogbook)
            {{-- Already submitted today --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 p-8">
                <div class="text-center">
                    <x-heroicon-s-check-circle class="w-20 h-20 text-green-500 mx-auto mb-4" />
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Logbook Hari Ini Sudah Dikirim</h3>
                    <p class="text-gray-600 mb-6">
                        Anda sudah mengirim logbook untuk hari ini.
                    </p>

                    <div class="max-w-md mx-auto bg-gray-50 rounded-lg p-6 text-left">
                        <div class="space-y-3">
                            <div class="flex">
                                <span class="w-32 text-gray-600">Mentor:</span>
                                <span class="font-medium text-gray-900">{{ $existingLogbook->mentor->name ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-32 text-gray-600">Status:</span>
                                <span class="font-medium">
                                    @if($existingLogbook->status === 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                            Menunggu Validasi
                                        </span>
                                    @elseif($existingLogbook->status === 'approved')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                            Disetujui
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex">
                                <span class="w-32 text-gray-600">Catatan:</span>
                                <span class="flex-1 text-gray-900">{{ \Illuminate\Support\Str::limit($existingLogbook->notes, 150) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('student.logbook.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-brand-primary hover:bg-teal-600 text-white font-bold rounded-lg transition">
                            <i class="fas fa-list mr-2"></i>
                            Lihat Daftar Logbook
                        </a>
                    </div>
                </div>
            </div>
        @else
            {{-- Logbook Form --}}
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                    <div class="bg-brand-primary text-white p-4 font-bold text-lg">
                        Buat Logbook Baru
                    </div>

                    <form id="logbookForm" class="p-6 space-y-6">
                        @csrf

                        {{-- Mentor Selection --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Pilih Mentor <span class="text-red-500">*</span>
                            </label>
                            <select name="mentor_id" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent">
                                <option value="">-- Pilih Mentor --</option>
                                @foreach($mentors as $mentor)
                                    <option value="{{ $mentor->user_id }}">
                                        {{ $mentor->user->name }} - {{ $mentor->position }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-gray-500 text-sm mt-1">
                                Pilih mentor yang akan memvalidasi logbook Anda
                            </p>
                        </div>

                        {{-- Notes/Activity Description --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Kegiatan Harian <span class="text-red-500">*</span>
                            </label>
                            <textarea name="notes"
                                      rows="10"
                                      required
                                      minlength="10"
                                      maxlength="2000"
                                      class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent"
                                      placeholder="Jelaskan kegiatan yang Anda lakukan hari ini secara detail...&#10;&#10;Contoh:&#10;1. Melakukan briefing pagi bersama tim&#10;2. Mempelajari dokumentasi proyek&#10;3. Membantu senior developer dalam coding&#10;4. Mengikuti meeting project"></textarea>
                            <p class="text-gray-500 text-sm mt-1">
                                Minimal 10 karakter, maksimal 2000 karakter
                            </p>
                        </div>

                        {{-- Documentation File Upload --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Dokumentasi (Opsional)
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-brand-primary transition">
                                <input type="file"
                                       name="documentation_file"
                                       id="documentationFile"
                                       accept=".pdf,.doc,.docx,.zip,.rar"
                                       class="hidden"
                                       onchange="handleFileSelect(this)">
                                <label for="documentationFile" class="cursor-pointer">
                                    <x-heroicon-s-document-text class="w-12 h-12 text-gray-400 mx-auto mb-3" />
                                    <p class="text-gray-700 font-medium mb-1">Klik untuk upload atau drag & drop</p>
                                    <p class="text-gray-500 text-sm">PDF, DOC, DOCX, ZIP, RAR (Max 10MB)</p>
                                </label>
                                <div id="fileInfo" class="hidden mt-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <x-heroicon-s-document class="w-5 h-5 text-brand-primary mr-2" />
                                            <span id="fileName" class="text-gray-700 text-sm"></span>
                                        </div>
                                        <button type="button" onclick="clearFile()" class="text-red-500 hover:text-red-700">
                                            <x-heroicon-m-x-mark class="w-5 h-5" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <x-heroicon-m-information-circle class="w-5 h-5 text-blue-500" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Logbook akan direview oleh mentor yang Anda pilih. Status akan berubah menjadi "Disetujui" atau "Ditolak" berdasarkan review mentor.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex gap-4">
                            <button type="submit"
                                    id="submitBtn"
                                    class="flex-1 bg-brand-primary hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Logbook
                            </button>
                            <a href="{{ route('student.logbook.index') }}"
                               class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-lg transition">
                                <i class="fas fa-list mr-2"></i>
                                Lihat Daftar Logbook
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    {{-- Loading Overlay --}}
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-[60] flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 flex items-center gap-4">
            <svg class="animate-spin h-8 w-8 text-brand-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-800 font-semibold">Menyimpan logbook...</span>
        </div>
    </div>

    <script>
        function handleFileSelect(input) {
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');

            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Validate file size (10MB)
                if (file.size > 10 * 1024 * 1024) {
                    alert('File terlalu besar! Maksimal 10MB.');
                    input.value = '';
                    return;
                }

                fileInfo.classList.remove('hidden');
                fileName.textContent = file.name + ' (' + formatFileSize(file.size) + ')';
            }
        }

        function clearFile() {
            const input = document.getElementById('documentationFile');
            const fileInfo = document.getElementById('fileInfo');

            input.value = '';
            fileInfo.classList.add('hidden');
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        // Form submission
        document.getElementById('logbookForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = document.getElementById('submitBtn');

            document.getElementById('loadingOverlay').classList.remove('hidden');
            submitBtn.disabled = true;

            try {
                const response = await fetch('{{ route('student.logbook.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert('Logbook berhasil dikirim! Menunggu validasi mentor.');
                    window.location.reload();
                } else {
                    alert(data.error || 'Terjadi kesalahan. Silakan coba lagi.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                document.getElementById('loadingOverlay').classList.add('hidden');
                submitBtn.disabled = false;
            }
        });

        // Character counter for notes
        const notesTextarea = document.querySelector('textarea[name="notes"]');
        if (notesTextarea) {
            const infoDiv = notesTextarea.parentElement.querySelector('.text-gray-500');
            const counter = document.createElement('div');
            counter.className = 'text-gray-500 text-sm mt-1';
            counter.innerHTML = '<span id="charCount">0</span>/2000 karakter';
            infoDiv.after(counter);

            notesTextarea.addEventListener('input', function() {
                document.getElementById('charCount').textContent = this.value.length;
            });
        }
    </script>
</x-app-layout>
