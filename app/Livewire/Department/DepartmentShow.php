<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Livewire\Component;

class DepartmentShow extends Component
{
    public $department;
    public function mount($uuid) {
        $this->department = Department::where('uuid', $uuid)->first();
    }
    public function render()
    {
        return view('livewire.department.department-show');
    }
}
