<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Work Schedules') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Create work schedules') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('work.schedule.index') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Back
    </a>

    <div class="w-150">
        <form wire:submit="submit" class="mt-6 space-y-6">
            <flux:input wire:model="name" label="Name" placeholder="Name" />

            <div class="flex space-x-4">
                <div class="flex-1">
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                    <input type="text" id="start_time" wire:model.live="start_time"
                        class="form-input border rounded p-2 w-full" placeholder="Pilih jam mulai..." />
                </div>

                <div class="flex-1">
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                    <input type="text" id="end_time" wire:model.live="end_time"
                        class="form-input border rounded p-2 w-full" placeholder="Pilih jam selesai..." />
                </div>
            </div>

            <flux:button type="submit" variant="primary">Submit</flux:button>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:load', initTimePickers);
            document.addEventListener('livewire:navigated', initTimePickers);

            function initTimePickers() {
                const startInput = document.getElementById('start_time');
                const endInput = document.getElementById('end_time');

                if (startInput && !startInput.classList.contains('flatpickr-input')) {
                    flatpickr(startInput, {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        time_24hr: true,
                        onChange: function(selectedDates, dateStr) {
                            startInput.value = dateStr;
                            startInput.dispatchEvent(new Event('input', { bubbles: true }));
                        },
                    });
                }

                if (endInput && !endInput.classList.contains('flatpickr-input')) {
                    flatpickr(endInput, {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        time_24hr: true,
                        onChange: function(selectedDates, dateStr) {
                            endInput.value = dateStr;
                            endInput.dispatchEvent(new Event('input', { bubbles: true }));
                        },
                    });
                }
            }
        </script>
    @endpush
</div>
