<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Payrolls') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage your payrolls') }}</flux:subheading>
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
        @can('payroll.create')
            <a href="{{ route('payroll.create') }}"
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
                        <th scope="col" class="px-6 py-3">Periode</th>
                        <th scope="col" class="px-6 py-3">Net Salary</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 w-70">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payrolls as $payroll)
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-2 font-medium text-gray-900">{{ $payroll->employee->employee_id }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ $payroll->employee->user->name }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ $payroll->period_month }} /
                                {{ $payroll->period_year }}</td>
                            <td class="px-6 py-2 text-gray-700">{{ number_format($payroll->net_salary, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-2 text-gray-700">
                                <flux:badge color="{{ $payroll->is_paid ? 'green' : 'yellow' }}">
                                    {{ $payroll->is_paid ? 'Paid' : 'Unpaid' }}</flux:badge>
                            </td>
                            <td class="px-6 py-2 space-x-1">
                                @can('payroll.paid')
                                    <button wire:click="paid('{{ $payroll->uuid }}')"
                                        class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-indigo-700 rounded-lg hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        Paid
                                    </button>
                                @endcan

                                <a href="{{ route('payroll.show', $payroll->uuid) }}"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                                    Show
                                </a>
                                @can('payroll.delete')
                                    <button wire:click="delete('{{ $payroll->uuid }}')"
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
