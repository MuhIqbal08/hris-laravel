<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Leave') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Detail your leaves') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('leave.index') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Back
    </a>

    <div class="w-150">
        <p class="mt-6"><strong>Name: </strong>{{ $leave->employee->user->name }}</p>
        <p class="mt-6"><strong>Leave Type: </strong>{{ $leave->type }}</p>
        <p class="mt-6"><strong>Start Date: </strong>{{ $leave->start_date }}</p>
        <p class="mt-6"><strong>End Date: </strong>{{ $leave->end_date }}</p>
        <p class="mt-6"><strong>Reason: </strong>{{ $leave->reason }}</p>
        <p class="mt-6"><strong>Status: </strong>{{ $leave->status }}</p>
        <p class="mt-6"><strong>Approved By: </strong>{{ $leave->approver->user->name }}</p>
    </div>
</div>
