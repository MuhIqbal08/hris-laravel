<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Employee Schedule') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Edit Employee Schedule') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('employee.schedules.index') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Back
    </a>

    <div class="w-150">
        <form wire:submit="submit" class="mt-6 space-y-6">
            <flux:select wire:key="employee-select" wire:model="employee_id" label="Pilih Karyawan"
                placeholder="Choose employee...">
                @foreach ($employees as $emp)
                    <flux:select.option value="{{ $emp->uuid }}">
                        {{ $emp->user->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:key="work-schedule-select" wire:model="work_schedule_id" label="Pilih Jadwal  Shift"
                placeholder="Choose Shift...">
                @foreach ($workSchedules as $ws)
                    <flux:select.option value="{{ $ws->uuid }}">
                        {{ $ws->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <div class="col-span-full">
                <flux:input wire:model="start_date" type="date" max="2999-12-31" label="Start Date" />
            </div>

            <div class="col-span-full">
                <flux:input wire:model="end_date" type="date" max="2999-12-31" label="End Date" />
            </div>

            {{-- <div class="flex space-x-4">
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
            </div> --}}

            <flux:button type="submit" variant="primary">Submit</flux:button>
        </form>
    </div>
</div>
