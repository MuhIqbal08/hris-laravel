<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Attendances') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Edit attendances') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('attendance.index') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Back
    </a>

    <div class="w-150">
        <form wire:submit="submit" class="mt-6 space-y-6">
            @session('error')
            <div class="flex items-center p-2 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-red-900 dark:text-red-300 dark:border-red-800"
                role="alert">
                <svg class="flex-shrink-0 w-8 h-8 mr-1 text-red-700 dark:text-red-300" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                </svg>
                <span class="font-medium"> {{ $value }} </span>
            </div>
        @endsession
            <flux:select wire:model="employee_id" label="Pilih Karyawan" placeholder="Choose employee...">
                @foreach ($employees as $emp)
                    <flux:select.option value="{{ $emp->uuid }}">{{ $emp->user->name }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex flex-col gap-2">
                <label class="text-sm font-medium">Jam Masuk</label>
                <input type="time" wire:model="check_in_time" class="form-input border rounded p-2 w-full" />
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-sm font-medium">Jam Keluar</label>
                <input type="time" wire:model="check_out_time" class="form-input border rounded p-2 w-full" />
            </div>

            <flux:input wire:model="date" type="date" label="Tanggal" max="2999-12-31" />

            <flux:select wire:model="status" label="Status Kehadiran" placeholder="Pilih status...">
                <flux:select.option value="present">Hadir</flux:select.option>
                <flux:select.option value="late">Terlambat</flux:select.option>
                <flux:select.option value="absent">Absen</flux:select.option>
                <flux:select.option value="on leave">Cuti</flux:select.option>
                <flux:select.option value="sick">Sakit</flux:select.option>
            </flux:select>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 mb-1">Check In Latitude</label>
                    <input type="text" wire:model="check_in_latitude"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300" />
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Check In Longitude</label>
                    <input type="text" wire:model="check_in_longitude"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300" />
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Check Out Latitude</label>
                    <input type="text" wire:model="check_out_latitude"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300" />
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Check Out Longitude</label>
                    <input type="text" wire:model="check_out_longitude"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300" />
                </div>
            </div>

            <flux:button type="button" onclick="getCurrentLocation()" variant="primary">Ambil Lokasi Saya</flux:button>
            <flux:button type="submit" variant="primary">Simpan Absensi</flux:button>
        </form>
    </div>

    <script>
        function getCurrentLocation() {
            if (!navigator.geolocation) {
                alert("Browser Anda tidak mendukung geolocation!");
                return;
            }
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    Livewire.find(
                        document.querySelector('[wire\\:id]').getAttribute('wire:id')
                    ).set('check_in_latitude', pos.coords.latitude);
                    Livewire.find(
                        document.querySelector('[wire\\:id]').getAttribute('wire:id')
                    ).set('check_in_longitude', pos.coords.longitude);
                    Livewire.find(
                        document.querySelector('[wire\\:id]').getAttribute('wire:id')
                    ).set('check_in_address', 'Lokasi otomatis');
                    Livewire.find(
                        document.querySelector('[wire\\:id]').getAttribute('wire:id')
                    ).set('check_out_latitude', pos.coords.latitude);
                    Livewire.find(
                        document.querySelector('[wire\\:id]').getAttribute('wire:id')
                    ).set('check_out_longitude', pos.coords.longitude);
                    Livewire.find(
                        document.querySelector('[wire\\:id]').getAttribute('wire:id')
                    ).set('check_out_address', 'Lokasi otomatis');
                },
                (err) => {
                    alert("Gagal mendapatkan lokasi!");
                    console.error(err);
                }
            );
        }
    </script>

</div>
