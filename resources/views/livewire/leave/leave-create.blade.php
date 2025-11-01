<div class="space-y-6">
    {{-- Header Section --}}
    <div class="relative w-full">
        <flux:heading size="xl" level="1">{{ __('Create Leave') }}</flux:heading>
        <flux:subheading size="lg" class="mb-4">
            {{ __('Create a new leave request') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- Back Button --}}
    <a href="{{ route('leave.index') }}"
       class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        ← Back
    </a>

    {{-- Form Section --}}
    <form wire:submit="submit" class="flex flex-col gap-4">
        {{-- Pilih Karyawan --}}
        <flux:select
            wire:key="employee-select"
            wire:model="employee_id"
            label="Pilih Karyawan"
            placeholder="Choose employee..."
        >
            @foreach ($employees as $emp)
                <flux:select.option value="{{ $emp->uuid }}">
                    {{ $emp->user->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

        {{-- Jenis Leave --}}
        <flux:select
            wire:model="type"
            label="Jenis Cuti"
            placeholder="Choose leave type..."
        >
            <flux:select.option value="leave">Annual Leave</flux:select.option>
            <flux:select.option value="sick">Sick Leave</flux:select.option>
        </flux:select>

        {{-- Tanggal Mulai & Selesai --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input
                wire:model="start_date"
                type="date"
                max="2999-12-31"
                label="Start Date"
            />
            <flux:input
                wire:model="end_date"
                type="date"
                max="2999-12-31"
                label="End Date"
            />
        </div>

        {{-- Alasan --}}
        <flux:input
            wire:model="reason"
            label="Reason"
            placeholder="Enter your reason for leave..."
        />

        <flux:button type="submit" variant="primary" class="w-full px-8 py-2.5 text-base font-medium">
                Submit
            </flux:button>
    </form>
</div>
