<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Livewire\Component;

class EmployeeShow extends Component
{
    public $employee;
    
    public function mount($uuid) {
        $this->employee = Employee::where('uuid', $uuid)->first();
    }
    public function render()
    {
        return view('livewire.employee.employee-show');
    }
}
