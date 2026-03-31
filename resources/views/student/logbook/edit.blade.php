<x-app-layout>
    <div class="min-h-screen bg-brand-bg px-10">
        {{-- Header --}}
        <header>
            <div class="w-full py-6 flex justify-between items-center">
                <div>
                    <h2 class="font-extrabold text-3xl text-gray-800 leading-tight">
                        {{ __('Edit Logbook') }}
                    </h2>
                    <p class="text-gray-600 mt-2">
                        {{ \Carbon\Carbon::parse($logbook->created_at)->translatedFormat('l, d F Y') }}
                    </p>
                </div>
                <a href="{{ route('student.logbook.index') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </header>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="bg-brand-primary text-white p-4 font-bold text-lg flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit & Kirim Ulang Logbook
                </div>

                <div class="p-6 space-y-6">

                    {{-- ===== UMPAN BALIK MENTOR (Read-Only) ===== --}}
                    @if($logbook->feedback)
                        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-info-circle text-red-500 mt-0.5 text-lg shrink-0"></i>
                                <div>
                                    <h4 class="font-semibold text-red-800 mb-1">Alasan Penolakan dari Mentor</h4>
                                    <p class="text-red-700 text-sm leading-relaxed">{{ $logbook->feedback }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-4">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-exclamation-triangle text-yellow-500 text-lg shrink-0"></i>
                                <p class="text-yellow-800 text-sm font-medium">Logbook ini ditolak oleh mentor. Silakan perbaiki dan kirim ulang.</p>
                            </div>
                        </div>
                    @endif

                    {{-- ===== FORM EDIT ===== --}}
                    <form id="editForm"
                          action="{{ route('student.logbook.update', $logbook->id) }}"
                          method="POST"
                          enctype="multipart/form-data"
                          class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Tanggal (Read-Only) --}}
                        <div class="grid md:grid-cols-[200px_1fr] gap-4 items-center">
                            <label class="text-sm font-semibold text-gray-700">Hari, Tanggal</label>
                            <input type="text"
                                   value="{{ \Carbon\Carbon::parse($logbook->created_at)->translatedFormat('l, d-m-Y') }}"
                                   readonly
                                   class="w-full md:w-72 border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                        </div>

                        {{-- Pilih Mentor --}}
                        <div class="grid md:grid-cols-[200px_1fr] gap-4 items-start">
                            <label class="text-sm font-semibold text-gray-700 pt-2">
                                Pilih Mentor <span class="text-red-500">*</span>
                            </label>
                            <div>
                                <select name="mentor_id" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent {{ $errors->has('mentor_id') ? 'border-red-500' : '' }}">
                                    <option value="">-- Pilih Mentor --</option>
                                    @foreach($mentors as $mentor)
                                        <option value="{{ $mentor->user_id }}"
                                            {{ old('mentor_id', $logbook->mentor_id) == $mentor->user_id ? 'selected' : '' }}>
                                            {{ $mentor->user->name }} - {{ $mentor->position }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('mentor_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Kegiatan --}}
                        <div class="grid md:grid-cols-[200px_1fr] gap-4 items-start">
                            <label class="text-sm font-semibold text-gray-700 pt-2">
                                Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <div>
                                <textarea name="notes"
                                          id="notesTextarea"
                                          rows="10"
                                          required
                                          minlength="10"
                                          maxlength="2000"
                                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent {{ $errors->has('notes') ? 'border-red-500' : '' }}"
                                          placeholder="Jelaskan kegiatan yang Anda lakukan secara detail...">{{ old('notes', $logbook->notes) }}</textarea>
                                <div class="flex justify-between mt-1">
                                    <p class="text-gray-400 text-xs">Minimal 10 karakter, maksimal 2000 karakter</p>
                                    <span class="text-gray-400 text-xs"><span id="charCount">{{ strlen(old('notes', $logbook->notes ?? '')) }}</span>/2000</span>
                                </div>
                                @error('notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Dokumentasi --}}
                        <div class="grid md:grid-cols-[200px_1fr] gap-4 items-start">
                            <label class="text-sm font-semibold text-gray-700 pt-2">
                                Dokumentasi (Opsional)
                            </label>
                            <div>
                                {{-- File lama --}}
                                @if($logbook->documentation_file)
                                    <div class="mb-3 p-3 bg-gray-50 border border-gray-200 rounded-lg flex items-center justify-between">
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <i class="fas fa-file text-brand-primary"></i>
                                            <span>File saat ini:</span>
                                            <a href="{{ asset('storage/' . $logbook->documentation_file) }}"
                                               target="_blank"
                                               class="text-brand-primary hover:underline font-medium">
                                                {{ basename($logbook->documentation_file) }}
                                            </a>
                                        </div>
                                        <span class="text-xs text-gray-400">Upload baru untuk mengganti</span>
                                    </div>
                                @endif

                                {{-- Upload baru --}}
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-5 text-center hover:border-brand-primary transition">
                                    <input type="file"
                                           name="documentation_file"
                                           id="documentationFile"
                                           accept=".pdf,.doc,.docx,.zip,.rar"
                                           class="hidden"
                                           onchange="handleFileSelect(this)">
                                    <label for="documentationFile" class="cursor-pointer">
                                        <x-heroicon-s-document-text class="w-10 h-10 text-gray-300 mx-auto mb-2" />
                                        <p class="text-gray-600 text-sm font-medium">Klik untuk upload file baru</p>
                                        <p class="text-gray-400 text-xs mt-1">PDF, DOC, DOCX, ZIP, RAR (Max 10MB)</p>
                                    </label>
                                    <div id="fileInfo" class="hidden mt-3 p-2 bg-gray-50 rounded text-left">
                                        <div class="flex items-center justify-between">
                                            <span id="fileName" class="text-sm text-gray-700"></span>
                                            <button type="button" onclick="clearFile()" class="text-red-400 hover:text-red-600 ml-2">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-400 mt-2">*Maksimal ukuran file 10MB</p>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-info-circle text-blue-400"></i>
                                <p class="text-sm text-blue-700">Setelah disimpan, logbook akan kembali ke status <strong>Menunggu Validasi</strong> dan dikirim ke mentor.</p>
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <button type="submit" id="submitBtn"
                                    class="flex-1 bg-brand-primary hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-lg transition disabled:bg-gray-400 disabled:cursor-not-allowed">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Simpan & Kirim Ulang
                            </button>
                            <a href="{{ route('student.logbook.index') }}"
                               class="inline-flex items-center justify-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-lg transition">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Character counter
        const textarea = document.getElementById('notesTextarea');
        if (textarea) {
            textarea.addEventListener('input', function () {
                document.getElementById('charCount').textContent = this.value.length;
            });
        }

        function handleFileSelect(input) {
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');

            if (input.files && input.files[0]) {
                const file = input.files[0];
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
            document.getElementById('documentationFile').value = '';
            document.getElementById('fileInfo').classList.add('hidden');
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }
    </script>
</x-app-layout>