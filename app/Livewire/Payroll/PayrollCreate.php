<?php

namespace App\Livewire\Payroll;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\PayrollRecord;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PayrollCreate extends Component
{
    public $employees;
    public $employee_id;
    public $period_month;
    public $period_year;

    public function mount()
    {
        // Ambil semua employee beserta relasi salary (pastikan relasi di model Employee bernama `salary`)
        $this->employees = Employee::with('salaries')->get();

        if ($this->employees->isNotEmpty() && !$this->employee_id) {
            $this->employee_id = $this->employees->first()->uuid;
        }

        $this->period_year = date('Y');
        $this->period_month = date('n'); // default bulan sekarang
    }

    public function render()
    {
        // Untuk dropdown / listing kita bisa pakai paginasi di view, tapi property $employees sudah di-mount
        return view('livewire.payroll.payroll-create', [
            // jika mau paginate di render, gunakan ini; tapi perhatikan property $employees di mount
            'employees' => Employee::with('salaries')->paginate(15),
        ]);
    }

    public function submit()
    {
        $this->validate([
            'employee_id' => ['required', Rule::exists('employees', 'uuid')],
            'period_month' => 'required|integer|min:1|max:12',
            'period_year' => 'required|integer|min:2000',
        ]);

        $employee = Employee::with('salaries')->findOrFail($this->employee_id);

        // Pastikan relasi salary ada; jika relasi plural (salaries) -> ambil first()
        $salary = $employee->salaries ? $employee->salaries->first() : null;

        if (!$salary) {
            session()->flash('error', 'Karyawan ini belum memiliki data gaji.');
            return;
        }

        $attendances = Attendance::where('employee_id', $this->employee_id)
            ->whereMonth('date', $this->period_month)
            ->whereYear('date', $this->period_year)
            ->get();

        $workingDays = $attendances->whereIn('status', ['present', 'late'])->count();
        $absentDays = $attendances->where('status', 'absent')->count();
        $totalDays = $attendances->count() ?: 1;

        $basic_salary = (float) $salary->basic_salary;
        $daily_rate = $basic_salary / $totalDays;
        $earned_salary = $daily_rate * $workingDays;

        $allowances = collect($salary->allowances ?? [])->sum('amount');
        $deductions = collect($salary->deductions ?? [])->sum('amount');

        $net_salary = $earned_salary + $allowances - $deductions;

        PayrollRecord::create([
            'uuid' => (string) Str::uuid(),
            'employee_id' => $employee->uuid,
            'period_month' => (int) $this->period_month,
            'period_year' => (int) $this->period_year,
            'working_days' => $workingDays,
            'net_salary' => $net_salary,
            'details' => [
                'basic_salary' => $basic_salary,
                'earned_salary' => $earned_salary,
                'allowances' => $salary->allowances,
                'deductions' => $salary->deductions,
                'absent_days' => $absentDays,
            ],
        ]);

        // Redirect ke index (Livewire mendukung redirect)
        return redirect()->route('payroll.index')->with('success', 'Payroll created successfully');
    }
}
