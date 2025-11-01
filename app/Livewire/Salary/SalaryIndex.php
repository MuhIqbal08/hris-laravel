<?php

namespace App\Livewire\Salary;

use App\Models\Salary;
use Livewire\Component;
use Livewire\WithPagination;

class SalaryIndex extends Component
{
    use WithPagination;
    public function render()
    {
        $user = auth()->user();

        if($user) {
            $salaries = Salary::with('employee')->paginate(15);
        } else {
            $salaries = Salary::with('employee')->where('employee_id', $user->employee->uuid)->paginate(15);
        }
        return view('livewire.salary.salary-index', compact('salaries'));
    }

    public function delete($uuid) {
        $salary = Salary::findOrFail($uuid);
        $salary->delete();
        
        session()->flash('success', 'Data gaji berhasil dihapus.');
    }
}
