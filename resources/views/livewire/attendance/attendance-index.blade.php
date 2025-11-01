<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Attendances') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage your attendances') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="p-3">
        @session('success')
            <div class="flex items-center p-2 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-green-900 dark:text-green-300 dark:border-green-800"
                role="alert">
                <svg class="flex-shrink-0 w-8 h-8 mr-1 text-green-700 dark:text-green-300" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                </svg>
                <span class="font-medium"> {{ $value }} </span>
            </div>
        @endsession
        @session('error')
            <div class="flex items-center p-2 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50">
                <svg class="flex-shrink-0 w-8 h-8 mr-1 text-red-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="font-medium"> {{ $value }} </span>
            </div>
        @endsession

        <div class="flex justify-between">
            @can('attendance.create')
                <a href="{{ route('attendance.create') }}"
                    class="mb-4 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Create Attendance Manual
                </a>
            @endcan
            <div class="flex gap-2">
                <form wire:submit.prevent="checkIn">
                    <input type="hidden" id="latitude" wire:model="latitude">
                    <input type="hidden" id="longitude" wire:model="longitude">
                    <input type="hidden" id="address" wire:model="address">
                    @can('attendance.check-in-out')
                        <flux:button type="submit" variant="primary">Check In</flux:button>
                    @endcan

                    {{-- <button type="submit"
                        class="mb-4 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800"
                        > Check In </button> --}}

                </form>
                <form wire:submit.prevent="checkOut">
                    <input type="hidden" id="latitude" wire:model="latitude">
                    <input type="hidden" id="longitude" wire:model="longitude">
                    <input type="hidden" id="address" wire:model="address">
                    @can('attendance.check-in-out')
                        <flux:button type="submit" variant="primary">Check Out</flux:button>
                    @endcan

                    {{-- <button type="submit"
                        class="mb-4 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800"
                        > Check In </button> --}}

                </form>
            </div>
        </div>
        <div class="overflow-x-auto mt-4">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3">EMP</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Check In</th>
                        <th scope="col" class="px-6 py-3">Check Out</th>
                        <th scope="col" class="px-6 py-3">Duration</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 w-70">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-2 font-medium text-gray-900">{{ $attendance->employee_id }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ $attendance->employee->user->name }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ $attendance->check_in_time ?? '-' }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ $attendance->check_out_time ?? '-' }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ $attendance->duration ?? '-' }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ $attendance->status }}</td>
                            <td class="px-6 py-2 space-x-1">
                                <a href="{{ route('attendance.edit', $attendance->uuid) }}"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Edit
                                </a>
                                <a href="{{ route('attendance.show', $attendance->uuid) }}"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                                    Show
                                </a>
                                @can('attendance.delete')
                                <button wire:click="delete('{{ $attendance->uuid }}')"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
                                    Delete
                                </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Tunggu sampai Livewire siap digunakan
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        console.log('Koordinat berhasil diambil:', position.coords.latitude, position.coords
                            .longitude);

                        // Set nilai langsung ke komponen Livewire
                        Livewire.find(
                            document.querySelector('[wire\\:id]').getAttribute('wire:id')
                        ).set('latitude', position.coords.latitude);

                        Livewire.find(
                            document.querySelector('[wire\\:id]').getAttribute('wire:id')
                        ).set('longitude', position.coords.longitude);

                        Livewire.find(
                            document.querySelector('[wire\\:id]').getAttribute('wire:id')
                        ).set('address', 'Lokasi terdeteksi otomatis');
                    },
                    (error) => {
                        alert('Gagal mendapatkan lokasi! Pastikan izin lokasi diaktifkan.');
                        console.error(error);
                    }
                );
            } else {
                alert('Browser tidak mendukung geolocation.');
            }
        });
    </script>

</div>
