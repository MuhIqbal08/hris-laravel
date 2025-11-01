<div class="">
    <h2 class="text-2xl font-bold mb-4">Pengaturan Lokasi Kantor</h2>

    <form wire:submit="submit" class="space-y-4">
        <div>
            <label class="block text-gray-700 mb-1">Nama Kantor</label>
            <input type="text" wire:model="name" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300" placeholder="Contoh: Kantor Pusat" />
            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Latitude</label>
            <input type="text" wire:model="latitude" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300" />
            @error('latitude') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Longitude</label>
            <input type="text" wire:model="longitude" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300" />
            @error('longitude') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700 mb-1">Radius (meter)</label>
            <input type="number" wire:model="radius_in_meters" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300" placeholder="Misal: 100" />
            @error('radius_in_meters') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-between items-center mt-4">
            {{-- <button
                wire:click="getLocation"
                type="button"
                onclick="getCurrentLocation()"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
            >
                Gunakan Lokasi Saya
            </button> --}}

            <flux:button onclick="getCurrentLocation()" variant="primary" color="indigo">Ambil Lokasi Saya</flux:button>

            <flux:button type="submit" variant="primary">Submit</flux:button>

            {{-- <button
                wire:click=""
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
                Simpan
            </button> --}}
        </div>
    </form>

    <script>
        function getCurrentLocation() {
            if (!navigator.geolocation) {
                alert("Browser Anda tidak mendukung geolocation!");
                return;
            }
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    @this.set('latitude', pos.coords.latitude);
                    @this.set('longitude', pos.coords.longitude);
                },
                (err) => {
                    alert("Gagal mendapatkan lokasi!");
                }
            );
        }
    </script>
</div>
