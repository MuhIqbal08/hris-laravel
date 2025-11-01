<?php

namespace App\Livewire\Salary;

use App\Models\Employee;
use App\Models\Salary;
use Livewire\Component;

class SalaryEdit extends Component
{
    public $salary;
    public $employee_id;
    public $basic_salary;
    public $allowances = [];
    public $deductions = [];
    public $employees;

    public function mount($uuid)
    {
        // Ambil data salary berdasarkan UUID
        $this->salary = Salary::where('uuid', $uuid)->firstOrFail();

        // Ambil data karyawan
        $this->employees = Employee::with('user')->get();

        // Isi form dengan data lama
        $this->employee_id = $this->salary->employee_id;
        $this->basic_salary = $this->salary->basic_salary;
        $this->allowances = $this->salary->allowances ?? [['name' => '', 'amount' => 0]];
        $this->deductions = $this->salary->deductions ?? [['name' => '', 'amount' => 0]];
    }

    public function render()
    {
        return view('livewire.salary.salary-edit');
    }

    public function addAllowance()
    {
        $this->allowances[] = [
            'name' => '',
            'amount' => 0,
        ];
    }

    public function removeAllowance($index)
    {
        unset($this->allowances[$index]);
        $this->allowances = array_values($this->allowances);
    }

    public function addDeduction()
    {
        $this->deductions[] = [
            'name' => '',
            'amount' => 0,
        ];
    }

    public function removeDeduction($index)
    {
        unset($this->deductions[$index]);
        $this->deductions = array_values($this->deductions);
    }

    public function submit()
    {
        $this->validate([
            'employee_id' => 'required|exists:employees,uuid',
            'basic_salary' => 'required|numeric|min:0',
        ]);

        // Update data salary
        $this->salary->update([
            'employee_id' => $this->employee_id,
            'basic_salary' => $this->basic_salary,
            'allowances' => $this->allowances,
            'deductions' => $this->deductions,
        ]);

        session()->flash('success', 'Data gaji berhasil diperbarui.');

        return redirect()->route('salary.index');
    }
}
