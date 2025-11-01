<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Salaries') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage your salaries') }}</flux:subheading>
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
        @can('salary.create')
            <a href="{{ route('salary.create') }}"
                class="mb-4 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                Create
            </a>
        @endcan
        <div class="overflow-x-auto mt-4">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3">EMP</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Allowance</th>
                        <th scope="col" class="px-6 py-3">Deduction</th>
                        <th scope="col" class="px-6 py-3 w-70">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salaries as $salary)
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-2 font-medium text-gray-900">{{ $salary->employee->employee_id }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ $salary->employee->user->name }}</td>
                            <td class="px-6 py-2 text-gray-700">
                                @php
                                    $allowances = is_string($salary->allowances)
                                        ? json_decode($salary->allowances, true)
                                        : $salary->allowances;
                                @endphp

                                @if (!empty($allowances))
                                    @foreach ($allowances as $item)
                                        <flux:badge color="teal" class="mt-1">{{ $item['name'] ?? '-' }}
                                            (Rp{{ number_format($item['amount'] ?? 0, 0, ',', '.') }})
                                        </flux:badge>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-2 text-gray-700">
                                @php
                                    $deductions = is_string($salary->deductions)
                                        ? json_decode($salary->deductions, true)
                                        : $salary->deductions;
                                @endphp

                                @if (!empty($deductions))
                                    @foreach ($deductions as $item)
                                        <flux:badge color="rose" class="mt-1">{{ $item['name'] ?? '-' }}
                                            (Rp{{ number_format($item['amount'] ?? 0, 0, ',', '.') }})
                                        </flux:badge>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-2 space-x-1">
                                @can('salary.edit')
                                <a href="{{ route('salary.edit', $salary->uuid) }}"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Edit
                                </a>
                                @endcan
                                <a href="{{ route('salary.show', $salary->uuid) }}"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                                    Show
                                </a>
                                @can('salary.delete')
                                    <button wire:click="delete('{{ $salary->uuid }}')"
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
