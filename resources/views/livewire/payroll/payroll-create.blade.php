<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Payrolls') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Create your payrolls') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('payroll.index') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Back
    </a>

    @session('error')
        <div class="flex items-center p-2 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-green-900 dark:text-green-300 dark:border-green-800"
            role="alert">
            <svg class="flex-shrink-0 w-8 h-8 mr-1 text-green-700 dark:text-green-300" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
            </svg>
            <span class="font-medium"> {{ $value }} </span>
        </div>
    @endsession

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

            <flux:input wire:model="period_month" required label="Month" type="number" min="1" max="12"
                placeholder="Month" />
            <flux:input wire:model="period_year" required label="Year" type="number" value="{{ date('Y') }}"
                placeholder="Year" />

            <flux:button type="submit" variant="primary">Submit</flux:button>
        </form>
    </div>
</div>
