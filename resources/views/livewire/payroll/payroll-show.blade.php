<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Payrolls') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Detail payrolls') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="flex gap-2">
        <a href="{{ route('payroll.index') }}"
            class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
            Back
        </a>
        <flux:button variant="primary" wire:click="download('{{ $payroll->uuid }}')" color="zinc">Download</flux:button>
    </div>

    <div class="p-6 space-y-6 w-full">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Payroll Details</h2>

        @php
            $details = is_string($payroll->details) ? json_decode($payroll->details, true) : $payroll->details;

            $employee = $payroll->employee ?? null;

            $totalAllowances = collect($details['allowances'] ?? [])->sum(fn($a) => $a['amount']);
            $totalDeductions = collect($details['deductions'] ?? [])->sum(fn($d) => $d['amount']);
            $netSalary = ($details['earned_salary'] ?? 0) + $totalAllowances - $totalDeductions;
        @endphp

        {{-- Informasi Umum --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-800">
            <div>
                <p class="text-sm text-gray-500">Employee Name</p>
                <p class="font-medium">{{ $employee->user->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Employee ID</p>
                <p class="font-medium">{{ $employee->employee_id ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Working Days</p>
                <p class="font-medium">{{ $payroll->working_days ?? '-' }} days</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Payroll Period</p>
                <p class="font-medium">
                    {{ $payroll->period_month ?? '-' }}/{{ $payroll->period_year ?? '-' }}
                </p>
            </div>
        </div>

        <hr class="my-4 border-gray-300">

        {{-- Salary Section --}}
        <div class="space-y-2 text-gray-800">
            <div class="flex justify-between">
                <span>Basic Salary</span>
                <span>Rp{{ number_format($details['basic_salary'] ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Earned Salary</span>
                <span>Rp{{ number_format($details['earned_salary'] ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Absent Days</span>
                <span>{{ $details['absent_days'] ?? 0 }}</span>
            </div>
        </div>

        {{-- Allowances --}}
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Allowances</h3>
            @if (!empty($details['allowances']))
                <div class="space-y-1">
                    @foreach ($details['allowances'] as $allowance)
                        <div class="flex justify-between text-gray-700">
                            <span>{{ $allowance['name'] ?? '-' }}</span>
                            <span>Rp{{ number_format($allowance['amount'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                    <div class="flex justify-between font-semibold border-t pt-2 mt-2">
                        <span>Total Allowances</span>
                        <span>Rp{{ number_format($totalAllowances, 0, ',', '.') }}</span>
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-sm">No allowances recorded.</p>
            @endif
        </div>

        {{-- Deductions --}}
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Deductions</h3>
            @if (!empty($details['deductions']))
                <div class="space-y-1">
                    @foreach ($details['deductions'] as $deduction)
                        <div class="flex justify-between text-gray-700">
                            <span>{{ $deduction['name'] ?? '-' }}</span>
                            <span>Rp{{ number_format($deduction['amount'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                    <div class="flex justify-between font-semibold border-t pt-2 mt-2">
                        <span>Total Deductions</span>
                        <span>Rp{{ number_format($totalDeductions, 0, ',', '.') }}</span>
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-sm">No deductions recorded.</p>
            @endif
        </div>

        <hr class="my-4 border-gray-300">

        {{-- Net Salary --}}
        <div class="flex justify-between text-lg font-bold text-gray-900">
            <span>Net Salary</span>
            <span>Rp{{ number_format($netSalary, 0, ',', '.') }}</span>
        </div>
    </div>
</div>
