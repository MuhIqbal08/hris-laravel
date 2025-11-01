<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Attendances') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Detail attendances') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('attendance.index') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Back
    </a>

    <div class="">
        <p class="mt-6"><strong>Name: </strong>{{ $attendance->employee->user->name }}</p>
        <p class="mt-6"><strong>Check In Time: </strong>{{ $attendance->check_in_time ?? '-' }}</p>
        <p class="mt-6"><strong>Check Out Time: </strong>{{ $attendance->check_out_time ?? '-' }}</p>
        <p class="mt-6"><strong>Date: </strong>{{ $attendance->date->format('Y-m-d') ?? '-' }}</p>
        <p class="mt-6"><strong>Work Schedule: </strong>{{ $attendance->workSchedule->name ?? '-' }}</p>
        <p class="mt-6"><strong>Duration: </strong>{{ $attendance->duration ?? '-' }}</p>
        <p class="mt-6"><strong>Status: </strong>{{ $attendance->status ?? '-' }}</p>
        <p class="mt-6"><strong>Remarks: </strong>{{ $attendance->remarks ?? '-' }}</p>
        <p class="mt-6"><strong>Check In Latitude: </strong>{{ $attendance->check_in_latitude ?? '-' }}</p>
        <p class="mt-6"><strong>Check In Longitude: </strong>{{ $attendance->check_in_longitude ?? '-' }}</p>
        <p class="mt-6"><strong>Check In Address: </strong>{{ $attendance->check_in_address ?? '-' }}</p>
        <p class="mt-6"><strong>Check Out Latitude: </strong>{{ $attendance->check_out_latitude ?? '-' }}</p>
        <p class="mt-6"><strong>Check Out Longitude: </strong>{{ $attendance->check_out_longitude ?? '-' }}</p>
        <p class="mt-6"><strong>Check Out Address: </strong>{{ $attendance->check_out_address ?? '-' }}</p>
    </div>
</div>
