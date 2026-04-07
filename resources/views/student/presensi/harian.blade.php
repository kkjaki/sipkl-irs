<x-app-layout>
    @section('title', 'Presensi Harian')
    <div class="min-h-screen bg-brand-bg px-10">
        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-extrabold text-3xl text-gray-800 leading-tight">
                    {{ __('Presensi Harian') }}
                </h2>
                <p class="text-gray-600 mt-2">
                    {{ date('F d Y', strtotime(now())) }}
                </p>
            </div>
        </header>

        @if ($attendanceSessions->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach ($attendanceSessions as $session)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                        <div class="bg-brand-primary text-white p-4 font-bold text-lg">
                            Sesi Presensi
                        </div>
                        <div class="p-6">
                            <div class="space-y-3 mb-4">
                                <div class="flex border-b py-2">
                                    <span class="w-40 font-medium text-gray-700">Industri</span>
                                    <span class="mx-2">:</span>
                                    <span class="flex-1 text-gray-900">
                                        {{ $session->industry->name }}
                                    </span>
                                </div>
                                <div class="flex border-b py-2">
                                    <span class="w-40 font-medium text-gray-700">Tanggal</span>
                                    <span class="mx-2">:</span>
                                    <span class="flex-1 text-gray-900">
                                        {{ date('F d Y', strtotime($session->session_date)) }}
                                    </span>
                                </div>
                                <div class="flex border-b py-2">
                                    <span class="w-40 font-medium text-gray-700">Batas Waktu</span>
                                    <span class="mx-2">:</span>
                                    <span class="flex-1 text-gray-900">
                                        {{ date('H:i', strtotime($session->on_time_deadline)) }}
                                    </span>
                                </div>
                                <div class="flex border-b py-2">
                                    <span class="w-40 font-medium text-gray-700">Dibuka Oleh</span>
                                    <span class="mx-2">:</span>
                                    <span class="flex-1 text-gray-900">
                                        {{ $session->user->name ?? '-' }}
                                    </span>
                                </div>
                                <div class="flex py-2">
                                    <span class="w-40 font-medium text-gray-700">Status</span>
                                    <span class="mx-2">:</span>
                                    <span class="flex-1">
                                        @if ($session->already_attended)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                                Sudah Presensi
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                                Belum Presensi
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            </div>

                            @if ($session->already_attended)
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                    <h4 class="font-semibold text-gray-800 mb-3">Data Presensi Anda:</h4>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <span class="w-32 text-gray-600">Status:</span>
                                            <span
                                                class="font-medium {{ $session->attendance_data->status === 'hadir' ? 'text-green-600' : ($session->attendance_data->status === 'izin' ? 'text-blue-600' : 'text-yellow-600') }}">
                                                {{ ucfirst($session->attendance_data->status) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="w-32 text-gray-600">Waktu Check-in:</span>
                                            <span class="font-medium text-gray-900">
                                                {{ date('H:i', strtotime($session->attendance_data->check_in)) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="w-32 text-gray-600">Keterangan:</span>
                                            @if ($session->attendance_data->status == 'hadir')
                                                @php
                                                    // Ambil jam check-in saja (format H:i)
                                                    $checkInTime = date(
                                                        'H:i',
                                                        strtotime($session->attendance_data->check_in),
                                                    );
                                                    // Ambil jam deadline saja (format H:i)
                                                    $deadlineTime = date('H:i', strtotime($session->on_time_deadline));
                                                @endphp

                                                @if ($checkInTime <= $deadlineTime)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-green-50 text-green-700 border border-green-100">
                                                        <i class="fas fa-check-circle mr-1"></i> Tepat Waktu
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-rose-50 text-rose-700 border border-rose-100">
                                                        <i class="fas fa-clock mr-1"></i> Terlambat
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-gray-400 font-bold italic">-</span>
                                            @endif
                                        </div>
                                        @if ($session->attendance_data->image)
                                            <div class="flex items-start">
                                                <span class="w-32 text-gray-600">Foto:</span>
                                                <a href="{{ asset('storage/' . $session->attendance_data->image) }}"
                                                    target="_blank" class="text-brand-primary hover:underline">
                                                    Lihat Foto
                                                </a>
                                            </div>
                                        @endif
                                        @if ($session->attendance_data->notes)
                                            <div class="flex items-start">
                                                <span class="w-32 text-gray-600">Catatan:</span>
                                                <span
                                                    class="font-medium text-gray-900">{{ $session->attendance_data->notes }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <button onclick="openAttendanceModal({{ $session->id }})"
                                    class="w-full mt-4 bg-brand-primary hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                                    <i class="fas fa-camera mr-2"></i> Lakukan Presensi
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 p-10 text-center">
                <x-heroicon-s-calendar class="w-20 h-20 text-gray-400 mx-auto mb-4" />
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak Ada Sesi Presensi</h3>
                <p class="text-gray-600">Belum ada sesi presensi yang dibuka untuk hari ini. Silakan cek kembali nanti
                    atau hubungi mentor Anda.</p>
            </div>
        @endif
    </div>

    {{-- Attendance Modal --}}
    <div id="attendanceModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
            <div
                class="bg-brand-primary text-white p-4 font-bold text-lg rounded-t-xl flex justify-between items-center">
                <span>Form Presensi</span>
                <button onclick="closeAttendanceModal()" class="text-white hover:text-gray-200">
                    <x-heroicon-m-x-mark class="w-6 h-6" />
                </button>
            </div>

            <form id="attendanceForm" class="p-6 space-y-5" x-data="{ status: '' }">
                @csrf
                <input type="hidden" id="attendance_session_id" name="attendance_session_id">

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Status Kehadiran <span
                            class="text-red-500">*</span></label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" x-model="status" name="status" value="hadir" class="hidden peer"
                                required>
                            <div
                                class="peer-checked:bg-green-100 peer-checked:border-green-500 peer-checked:text-green-700 border-2 border-gray-200 rounded-lg p-3 text-center transition hover:border-green-300">
                                <i class="fas fa-check-circle text-2xl mb-1"></i>
                                <div class="font-medium">Hadir</div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" x-model="status" name="status" value="izin" class="hidden peer">
                            <div
                                class="peer-checked:bg-blue-100 peer-checked:border-blue-500 peer-checked:text-blue-700 border-2 border-gray-200 rounded-lg p-3 text-center transition hover:border-blue-300">
                                <i class="fas fa-file-alt text-2xl mb-1"></i>
                                <div class="font-medium">Izin</div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" x-model="status" name="status" value="sakit" class="hidden peer">
                            <div
                                class="peer-checked:bg-yellow-100 peer-checked:border-yellow-500 peer-checked:text-yellow-700 border-2 border-gray-200 rounded-lg p-3 text-center transition hover:border-yellow-300">
                                <i class="fas fa-briefcase-medical text-2xl mb-1"></i>
                                <div class="font-medium">Sakit</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div x-show="status === 'hadir'" x-transition class="mt-4">
                    <label class="block text-gray-700 font-semibold mb-2">Foto Presensi (Selfie) <span
                            class="text-red-500">*</span></label>
                    <div class="space-y-3">
                        <div class="relative">
                            <video id="cameraPreview" class="w-full h-64 bg-black rounded-lg object-cover" autoplay
                                playsinline></video>
                            <canvas id="photoCanvas" class="hidden"></canvas>
                            <img id="photoPreview" class="w-full h-64 object-cover rounded-lg hidden">
                        </div>
                        <div class="flex gap-2">
                            <button type="button" id="startCameraBtn" onclick="startCamera()"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                                <i class="fas fa-camera mr-2"></i>Aktifkan Kamera
                            </button>
                            <button type="button" id="captureBtn" onclick="capturePhoto()"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition hidden">
                                <i class="fas fa-camera mr-2"></i>Ambil Foto
                            </button>
                            <button type="button" id="retakeBtn" onclick="retakePhoto()"
                                class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition hidden">
                                <i class="fas fa-redo mr-2"></i>Ulang Foto
                            </button>
                        </div>
                        <p id="cameraError" class="text-red-500 text-sm hidden"></p>
                    </div>
                </div>

                <div x-show="status === 'izin' || status === 'sakit'" x-transition class="mt-4">
                    <label class="block text-gray-700 font-semibold mb-2">Upload Surat Keterangan <span
                            class="text-red-500">*</span></label>
                    <button type="button" onclick="document.getElementById('imageInput').click()"
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-lg transition flex justify-center items-center">
                        <i class="fas fa-upload mr-2"></i>Pilih File Surat
                    </button>
                    <p class="text-xs text-gray-500 mt-2 text-center">Format: JPG (< 5MB)</p>
                </div>

                <input type="file" id="imageInput" name="image" accept="image/*,.pdf" class="hidden"
                    onchange="handleFileSelect(event)">

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Catatan (Opsional)</label>
                    <textarea name="notes" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent"
                        placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                </div>

                {{-- HIDDEN INPUT UNTUK GEOFENCING BACKEND --}}
                <input type="hidden" name="latitude" id="latitude_input">
                <input type="hidden" name="longitude" id="longitude_input">

                <button type="submit" id="submitBtn"
                    class="w-full bg-brand-primary hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed">
                    <i class="fas fa-paper-plane mr-2"></i> Kirim Presensi
                </button>
            </form>
        </div>
    </div>

    {{-- Loading Overlay --}}
    <div id="loadingOverlay"
        class="fixed inset-0 bg-black bg-opacity-50 hidden z-[60] flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 flex items-center gap-4">
            <svg class="animate-spin h-8 w-8 text-brand-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="text-gray-800 font-semibold">Menyimpan presensi...</span>
        </div>
    </div>
    {{-- Custom Alert Modal --}}
    <div id="notificationModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-[70] flex items-center justify-center p-4 transition-opacity">
        <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-8 text-center transform scale-95 transition-transform"
            id="notificationContent">
            <div id="notifIconContainer" class="mx-auto flex items-center justify-center h-20 w-20 rounded-full mb-6">
                <i id="notifIcon" class="fas text-4xl"></i>
            </div>
            <h3 id="notifTitle" class="text-2xl font-black text-gray-900 mb-2 tracking-tight"></h3>
            <p id="notifMessage" class="text-sm text-gray-500 font-medium mb-8 leading-relaxed"></p>
            <button id="notifButton"
                class="w-full py-4 text-white font-bold rounded-2xl shadow-md transition-all active:scale-95 uppercase tracking-widest text-xs">
                Mengerti
            </button>
        </div>
    </div>

    <script>
        let mediaStream = null;
        let photoDataUrl = null;

        // FUNGSI PEMANGGIL ALERT CUSTOM
        function showNotification(type, title, message, reloadOnClose = false) {
            const modal = document.getElementById('notificationModal');
            const iconContainer = document.getElementById('notifIconContainer');
            const icon = document.getElementById('notifIcon');
            const btn = document.getElementById('notifButton');

            document.getElementById('notifTitle').textContent = title;
            document.getElementById('notifMessage').textContent = message;

            // Reset Kelas CSS
            iconContainer.className = 'mx-auto flex items-center justify-center h-20 w-20 rounded-full mb-6';
            icon.className = 'fas text-4xl';
            btn.className =
                'w-full py-4 text-white font-black rounded-2xl shadow-lg transition-all active:scale-95 uppercase tracking-widest text-xs';

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
                if (reloadOnClose) window.location.reload();
            }
        }

        function openAttendanceModal(sessionId) {
            document.getElementById('attendanceModal').classList.remove('hidden');
            document.getElementById('attendance_session_id').value = sessionId;
        }

        function closeAttendanceModal() {
            document.getElementById('attendanceModal').classList.add('hidden');
            stopCamera();
            resetForm();
        }

        async function startCamera() {
            const video = document.getElementById('cameraPreview');
            const errorMsg = document.getElementById('cameraError');

            try {
                mediaStream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user'
                    },
                    audio: false
                });
                video.srcObject = mediaStream;
                document.getElementById('startCameraBtn').classList.add('hidden');
                document.getElementById('captureBtn').classList.remove('hidden');
                errorMsg.classList.add('hidden');
            } catch (err) {
                // ALERT 1: KAMERA TIDAK DIIZINKAN
                showNotification('warning', 'Akses Kamera Ditolak',
                    'Kamera belum diaktifkan. Mohon izinkan akses kamera pada peramban (browser) Anda untuk melanjutkan proses presensi.'
                    );
            }
        }

        function stopCamera() {
            if (mediaStream) {
                mediaStream.getTracks().forEach(track => track.stop());
                mediaStream = null;
            }
        }

        function capturePhoto() {
            const video = document.getElementById('cameraPreview');
            const canvas = document.getElementById('photoCanvas');
            const ctx = canvas.getContext('2d');
            const photoPreview = document.getElementById('photoPreview');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude.toFixed(8);
                        const lon = position.coords.longitude.toFixed(8);

                        document.getElementById('latitude_input').value = lat;
                        document.getElementById('longitude_input').value = lon;

                        const timeNow = new Date().toLocaleDateString('id-ID', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        });
                        const text1 = `Lat: ${lat}, Long: ${lon}`;

                        ctx.fillStyle = "white";
                        ctx.font = "bold 20px Arial";
                        ctx.shadowColor = "black";
                        ctx.shadowBlur = 7;
                        ctx.fillText(text1, 20, canvas.height - 50);
                        ctx.fillText(timeNow, 20, canvas.height - 20);

                        const dataURL = canvas.toDataURL('image/jpeg', 0.8);
                        photoPreview.src = dataURL;
                        photoDataUrl = dataURL;

                        video.classList.add('hidden');
                        photoPreview.classList.remove('hidden');
                        document.getElementById('captureBtn').classList.add('hidden');
                        document.getElementById('retakeBtn').classList.remove('hidden');
                    },
                    function(error) {
                        // ALERT 2: LOKASI TIDAK DIIZINKAN
                        showNotification('warning', 'Akses Lokasi Ditolak',
                            'Akses lokasi (GPS) tidak ditemukan. Mohon aktifkan layanan lokasi pada perangkat Anda untuk memvalidasi area presensi.'
                            );
                    }, {
                        enableHighAccuracy: true,
                        timeout: 5000
                    }
                );
            } else {
                showNotification('error', 'Fitur Tidak Didukung',
                    'Peramban (browser) yang Anda gunakan saat ini tidak mendukung layanan pelacakan lokasi (GPS).');
            }
        }

        function retakePhoto() {
            document.getElementById('cameraPreview').classList.remove('hidden');
            document.getElementById('photoPreview').classList.add('hidden');
            document.getElementById('retakeBtn').classList.add('hidden');
            document.getElementById('captureBtn').classList.remove('hidden');
            photoDataUrl = null;
            document.getElementById('latitude_input').value = '';
            document.getElementById('longitude_input').value = '';
            startCamera();
        }

        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoDataUrl = e.target.result;
                    const photoPreview = document.getElementById('photoPreview');
                    photoPreview.src = photoDataUrl;
                    document.getElementById('cameraPreview').classList.add('hidden');
                    photoPreview.classList.remove('hidden');
                    stopCamera();
                };
                reader.readAsDataURL(file);
            }
        }

        function resetForm() {
            document.getElementById('cameraPreview').classList.remove('hidden');
            document.getElementById('photoPreview').classList.add('hidden');
            document.getElementById('startCameraBtn').classList.remove('hidden');
            document.getElementById('captureBtn').classList.add('hidden');
            document.getElementById('retakeBtn').classList.add('hidden');
            document.getElementById('latitude_input').value = '';
            document.getElementById('longitude_input').value = '';
            photoDataUrl = null;
            document.getElementById('attendanceForm').reset();
        }

        document.getElementById('attendanceForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            // ALERT 3: VALIDASI FOTO BELUM DIISI (Dibedakan teksnya berdasarkan status)
            if (!photoDataUrl && !document.getElementById('imageInput').value) {
                const statusVal = document.querySelector('input[name="status"]:checked').value;
                if (statusVal === 'hadir') {
                    showNotification('warning', 'Dokumentasi Tidak Lengkap',
                        'Mohon ambil foto selfie Anda terlebih dahulu sebelum mengirimkan data presensi.');
                } else {
                    showNotification('warning', 'Dokumen Tidak Lengkap',
                        'Mohon unggah foto surat keterangan (Sakit/Izin) terlebih dahulu sebelum mengirimkan data.'
                        );
                }
                return;
            }

            const formData = new FormData(this);

            if (photoDataUrl && photoDataUrl.startsWith('data:image')) {
                const blob = await fetch(photoDataUrl).then(r => r.blob());
                formData.set('image', blob, 'attendance.jpg');
            }

            document.getElementById('loadingOverlay').classList.remove('hidden');

            try {
                const response = await fetch('{{ route('student.presensi.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok || data.success) {
                    // ALERT 4: PRESENSI SUKSES
                    closeAttendanceModal();
                    showNotification('success', 'Presensi Berhasil',
                        'Data kehadiran Anda telah sukses terekam di dalam sistem.', true);
                } else {
                    // ALERT 5: DITOLAK BACKEND (Contoh: Jarak Geofencing Terlalu Jauh)
                    let errorMsg = 'Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.';
                    if (data.error) errorMsg = data.error;
                    else if (data.message) errorMsg = data.message;
                    else if (data.errors) errorMsg = Object.values(data.errors)[0][0];

                    showNotification('error', 'Presensi Ditolak', errorMsg);
                }
            } catch (error) {
                console.log('Error:', error);
                showNotification('error', 'Terjadi Kesalahan', 'Gagal terhubung ke server: ' + error.message);
            } finally {
                document.getElementById('loadingOverlay').classList.add('hidden');
            }
        });

        document.getElementById('attendanceModal').addEventListener('click', function(e) {
            if (e.target === this) closeAttendanceModal();
        });
    </script>
</x-app-layout>
