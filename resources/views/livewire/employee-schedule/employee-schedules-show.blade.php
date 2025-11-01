<div>
     <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Employee Schedules') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Detail employee schedules') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('employee.schedules.index') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Back
    </a>

    <div class="w-150">
        <p class="mt-6"><strong>Name: </strong>{{ $employee_schedule->employee->user->name }}</p>
        <p class="mt-6"><strong>Start Date: </strong>{{ $employee_schedule->start_date->format('Y-m-d') }}</p>
        <p class="mt-6"><strong>End Date: </strong>{{ $employee_schedule->end_date->format('Y-m-d') }}</p>
    </div>
</div>
