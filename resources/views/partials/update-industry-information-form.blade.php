<section>
    <header>
        <h2 class="text-lg font-bold text-gray-900">
            {{ __('Informasi Industri & Pembatasan Geografis') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui detail perusahaan dan tentukan lokasi GPS kantor untuk verifikasi kehadiran siswa.') }}
        </p>
    </header>

    <form method="post" action="{{ route('industry.profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="industry_name" :value="__('Nama Industri')" />
            <x-text-input id="industry_name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->industry->name ?? '')"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Kontak Industri')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->industry->phone ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="address" :value="__('Alamat Industri')" />
            <textarea name="address" rows="3"
                class="mt-1 block w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm">{{ old('address', $user->industry->address ?? '') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="mt-4">
            <div>
                <x-input-label for="map" :value="__('Lokasi Absensi (Gesek PIN)')" />
                <div id="map" class="mt-2 w-full rounded-xl border border-gray-300 shadow-inner z-10"
                    style="height: 350px; min-height: 350px;"></div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <x-input-label for="latitude" :value="__('Latitude')" />
                    <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full bg-gray-100"
                        :value="old('latitude', $user->industry->latitude ?? '')" readonly />
                </div>
                <div>
                    <x-input-label for="longitude" :value="__('Longitude')" />
                    <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full bg-gray-100"
                        :value="old('longitude', $user->industry->longitude ?? '')" readonly />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-teal-600 hover:bg-teal-700">{{ __('Simpan') }}</x-primary-button>
            @if (session('status') === 'profile-industry-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>

</section>

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');

            if (!latInput || !lngInput) {
                console.error("Input lat/lng tidak ditemukan di HTML!");
                return;
            }

            let defaultLat = latInput.value ? parseFloat(latInput.value) : -7.3996;
            let defaultLng = lngInput.value ? parseFloat(lngInput.value) : 109.6977;

            try {
                const map = L.map('map').setView([defaultLat, defaultLng], 15);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                const marker = L.marker([defaultLat, defaultLng], {
                    draggable: true
                }).addTo(map);

                marker.on('dragend', function(e) {
                    const pos = e.target.getLatLng();
                    latInput.value = pos.lat.toFixed(8);
                    lngInput.value = pos.lng.toFixed(8);
                });
            } catch (error) {
                console.error("Leaflet gagal dimuat: ", error);
            }
        });
    </script>
@endpush
