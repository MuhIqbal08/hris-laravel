<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Leaves') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Detail leaves') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('salary.index') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Back
    </a>

    @php
        $allowances = is_string($salary->allowances) ? json_decode($salary->allowances, true) : $salary->allowances;
        $deductions = is_string($salary->deductions) ? json_decode($salary->deductions, true) : $salary->deductions;
    @endphp

    <div class="flex flex-col space-y-6 mt-6">
        <div class="flex flex-col gap-2">
            <p class=""><strong>Name: </strong>{{ $salary->employee->user->name }}</p>
            <p class=""><strong>Basic Salary: </strong>Rp{{ number_format($salary->basic_salary, 0 , ',', '.') }}</p>
            <div class="">
                <span class=""><strong>Allowances: </strong></span>
                @foreach ($allowances as $item)
                    <flux:badge color="teal" class="mt-1 w-fit">{{ $item['name'] ?? '-' }}
                        (Rp{{ number_format($item['amount'] ?? 0, 0, ',', '.') }})
                    </flux:badge>
                @endforeach
            </div>
            <div>
                <span><strong>Deductions:</strong></span>
                @foreach ($deductions as $item)
                    <flux:badge color="rose" class="mt-1">{{ $item['name'] ?? '-' }}
                        (Rp{{ number_format($item['amount'] ?? 0, 0, ',', '.') }})
                    </flux:badge>
                @endforeach
            </div>
        </div>
    </div>
</div>
