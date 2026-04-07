<x-app-layout>
@section('title', 'Tambah Logbook')
    <div class="min-h-screen bg-brand-bg px-10 relative">
        {{-- Header --}}
        <header>
            <div class="w-full py-6 flex justify-between items-center">
                <div>
                    <h2 class="font-extrabold text-3xl text-gray-800 leading-tight">
                        {{ __('Tambah Logbook') }}
                    </h2>
                    <p class="text-gray-600 mt-2">
                        {{ now()->translatedFormat('l, F d Y') }}
                    </p>
                </div>
                <a href="{{ route('student.logbook.index') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition">
                    <i class="fas fa-list mr-2"></i>
                    Daftar Logbook
                </a>
            </div>
        </header>

        <article class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 flex flex-col mb-8">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex justify-between items-center text-white font-bold text-lg rounded-t-xl">
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
                            Kegiatan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="notes"
                                  rows="10"
                                  required
                                  minlength="10"
                                  maxlength="2000"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent"
                                  placeholder="Jelaskan kegiatan yang Anda lakukan secara detail...&#10;&#10;Contoh:&#10;1. Melakukan briefing pagi bersama tim&#10;2. Mempelajari dokumentasi proyek&#10;3. Membantu senior developer dalam coding&#10;4. Mengikuti meeting project"></textarea>
                        <div class="flex justify-between mt-1">
                            <p class="text-gray-500 text-sm">Minimal 10 karakter, maksimal 2000 karakter</p>
                            <span class="text-gray-500 text-sm"><span id="charCount">0</span>/2000</span>
                        </div>
                    </div>

                    {{-- Documentation File Upload --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Dokumentasi <span class="text-red-500">(Opsional)</span>
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
                            <x-heroicon-m-information-circle class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" />
                            <p class="ml-3 text-sm text-blue-700">
                                Logbook akan direview oleh mentor yang Anda pilih. Status akan berubah menjadi <strong>Disetujui</strong> atau <strong>Ditolak</strong> berdasarkan review mentor. Anda dapat mengisi logbook beberapa kali.
                            </p>
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
                            Daftar Logbook
                        </a>
                    </div>
                </form>
        </article>

        {{-- CUSTOM NOTIFICATION MODAL (TAILWIND) --}}
        <div id="notificationModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-[70] flex items-center justify-center p-4 transition-opacity">
            <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-8 text-center transform scale-95 transition-transform" id="notificationContent">
                <div id="notifIconContainer" class="mx-auto flex items-center justify-center h-20 w-20 rounded-full mb-6">
                    <i id="notifIcon" class="fas text-4xl"></i>
                </div>
                <h3 id="notifTitle" class="text-2xl font-black text-gray-900 mb-2 tracking-tight"></h3>
                <p id="notifMessage" class="text-sm text-gray-500 font-medium mb-8 leading-relaxed"></p>
                <button id="notifButton" class="w-full py-4 text-white font-bold rounded-2xl shadow-md transition-all active:scale-95 uppercase tracking-widest text-xs">
                    Mengerti
                </button>
            </div>
        </div>

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
        // FUNGSI ALERT CUSTOM
        function showNotification(type, title, message, redirectUrl = null) {
            const modal = document.getElementById('notificationModal');
            const iconContainer = document.getElementById('notifIconContainer');
            const icon = document.getElementById('notifIcon');
            const btn = document.getElementById('notifButton');

            document.getElementById('notifTitle').textContent = title;
            document.getElementById('notifMessage').textContent = message;

            iconContainer.className = 'mx-auto flex items-center justify-center h-20 w-20 rounded-full mb-6';
            icon.className = 'fas text-4xl';
            btn.className = 'w-full py-4 text-white font-black rounded-2xl shadow-lg transition-all active:scale-95 uppercase tracking-widest text-xs';

            if (type === 'success') {
                iconContainer.classList.add('bg-green-100');
                icon.classList.add('fa-check', 'text-green-600');
                btn.classList.add('bg-teal-500', 'hover:bg-teal-600', 'shadow-teal-100');
            } else if (type === 'warning') {
                iconContainer.classList.add('bg-amber-100');
                icon.classList.add('fa-exclamation-triangle', 'text-amber-600');
                btn.classList.add('bg-amber-500', 'hover:bg-amber-600', 'shadow-amber-100');
            } else {
                iconContainer.classList.add('bg-rose-100');
                icon.classList.add('fa-times', 'text-rose-600');
                btn.classList.add('bg-rose-600', 'hover:bg-rose-700', 'shadow-rose-100');
            }

            modal.classList.remove('hidden');

            btn.onclick = function() {
                modal.classList.add('hidden');
                if(redirectUrl) {
                    window.location.href = redirectUrl; 
                }
            }
        }

        function handleFileSelect(input) {
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');

            if (input.files && input.files[0]) {
                const file = input.files[0];

                if (file.size > 10 * 1024 * 1024) {
                    // GANTI ALERT FILE KEBESARAN
                    showNotification('warning', 'Ukuran Dokumen Melebihi Batas', 'Mohon unggah dokumen dengan ukuran maksimal 10MB.');
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

        // Character counter
        const notesTextarea = document.querySelector('textarea[name="notes"]');
        if (notesTextarea) {
            notesTextarea.addEventListener('input', function () {
                document.getElementById('charCount').textContent = this.value.length;
            });
        }

        // Form submission
        document.getElementById('logbookForm').addEventListener('submit', async function (e) {
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
                    // GANTI ALERT SUKSES
                    showNotification(
                        'success', 
                        'Logbook Terkirim', 
                        'Laporan kegiatan Anda telah berhasil diserahkan dan saat ini sedang menunggu proses validasi dari mentor terkait.', 
                        '{{ route('student.logbook.index') }}'
                    );
                } else {
                    // GANTI ALERT ERROR DARI BACKEND
                    showNotification('error', 'Gagal Mengirim', data.error || 'Terjadi kesalahan sistem. Silakan coba lagi.');
                }
            } catch (error) {
                console.error('Error:', error);
                // GANTI ALERT CATCH ERROR
                showNotification('error', 'Terjadi Kesalahan', 'Gagal terhubung ke server. Pastikan koneksi internet Anda stabil lalu coba kembali.');
            } finally {
                document.getElementById('loadingOverlay').classList.add('hidden');
                submitBtn.disabled = false;
            }
        });
    </script>
</x-app-layout>