<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public $search = '';

    public function render()
    {
        $employees = Employee::with('user', 'department')
            ->when($this->search, function ($query, ) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('employee_id', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')->paginate(15);
        return view('livewire.employee.employee-index', compact('employees'));
    }

    public function delete($uuid)
    {
        $employee = Employee::with('user', 'department')->where('uuid', $uuid)->firstOrFail();
        $employee->delete();

        session()->flash('success', 'Employee deleted successfully');
    }
}
