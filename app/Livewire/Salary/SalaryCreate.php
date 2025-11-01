<?php

namespace App\Livewire\Salary;

use App\Models\Employee;
use App\Models\Salary;
use Livewire\Component;

class SalaryCreate extends Component
{
    public $employee_id;
    public $basic_salary;
    public $allowances = [];
    public $deductions = [];
    public $employees;

    public function mount()
    {
        // Ambil data karyawan
        $this->employees = Employee::with('user')->get();

        // Set default kosong agar form tidak error binding
        $this->allowances = [
            ['name' => '', 'amount' => 0]
        ];

        $this->deductions = [
            ['name' => '', 'amount' => 0]
        ];

        // Set default employee jika belum dipilih
        if ($this->employees->isNotEmpty() && !$this->employee_id) {
            $this->employee_id = $this->employees->first()->uuid;
        }
    }

    public function render()
    {
        return view('livewire.salary.salary-create');
    }

    public function addAllowance()
    {
        $this->allowances[] = [
            'name' => '',
            'amount' => 0,
        ];
    }

    public function addDeduction()
    {
        $this->deductions[] = [
            'name' => '',
            'amount' => 0,
        ];
    }

    public function submit()
    {
        $this->validate([
            'employee_id' => 'required|exists:employees,uuid',
            'basic_salary' => 'required|numeric|min:0',
        ]);

        Salary::create([
            'employee_id' => $this->employee_id,
            'basic_salary' => $this->basic_salary,
            'allowances' => $this->allowances,
            'deductions' => $this->deductions,
        ]);

        session()->flash('success', 'Data gaji berhasil ditambahkan.');

        return redirect()->route('salary.index');
    }
}
