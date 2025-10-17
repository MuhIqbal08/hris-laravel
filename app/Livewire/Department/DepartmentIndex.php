<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Livewire\Component;

class DepartmentIndex extends Component
{
    public $search;
    public function render()
    {
        $departments = Department::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
        ->paginate(15);
        return view('livewire.department.department-index', compact('departments'));
    }

    public function delete($uuid) {
        $department = Department::where('uuid', $uuid)->firstOrFail();
        $department->delete();

        session()->flash('success', 'Department deleted successfully');
    }
}
