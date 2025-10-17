<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Livewire\Component;

class DepartmentEdit extends Component
{
    public $department, $name;
    
    public function mount($uuid) {
        // $department = Department::find('uuid', $uuid);
        $this->department = Department::where('uuid', $uuid)->first();
        $this->name = $this->department->name;
    }

    public function render()
    {
        return view('livewire.department.department-edit');
    }

    public function submit() {
        $this->validate([
            'name' => 'required'
        ]);

        $this->department->name = $this->name;

        $this->department->save();

        // return redirect()->route('department.index');
        return to_route('department.index',)->with('success', 'Department updated successfully');
    }
}
