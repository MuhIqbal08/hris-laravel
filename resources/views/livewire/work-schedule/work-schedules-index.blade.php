<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Work Schedules') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage your work schedules') }}</flux:subheading>
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

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            @can('work-schedule.create')
                <a href="{{ route('work.schedule.create') }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 transition">
                    Create Work Schedule
                </a>
            @endcan

            <div class="w-full md:w-1/3">
                <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Search work schedules..."
                    class="w-full" />
            </div>
        </div>
        <div class="overflow-x-auto mt-4 space-y-6">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Start</th>
                        <th scope="col" class="px-6 py-3">End</th>
                        <th scope="col" class="px-6 py-3 w-70">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workSchedules as $schedule)
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-2 font-medium text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ $schedule->name }}</td>
                            <td class="px-6 py-2 text-gray-700">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                            </td>
                            <td class="px-6 py-2 text-gray-700">
                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                            </td>
                            <td class="px-6 py-2 space-x-1">
                                @can('work-schedule.edit')
                                    <a href="{{ route('work.schedule.edit', $schedule->uuid) }}"
                                        class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        Edit
                                    </a>
                                @endcan
                                <a href="{{ route('work.schedule.show', $schedule->uuid) }}"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                                    Show
                                </a>
                                @can('work-schedule.delete')
                                    <button wire:click="delete('{{ $schedule->uuid }}')"
                                        wire:confirm="Are you sure to remove this work schedule"
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
</div>
