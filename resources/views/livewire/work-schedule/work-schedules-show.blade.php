<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Work Schedules') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Detail work schedule') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('work.schedule.index') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Back
    </a>

    <div class="w-150">
        <p class="mt-6"><strong>Name: </strong>{{ $workSchedule->name }}</p>
        <p class="mt-6"><strong>Start Time: </strong>{{ \Carbon\Carbon::parse($workSchedule->start_time)->format('H:i') }}</p>
        {{-- Carbon To H:I --}}
        <p class="mt-6"><strong>End Time: </strong>{{ \Carbon\Carbon::parse($workSchedule->end_time)->format('H:i') }}</p>
    </div>
</div>
