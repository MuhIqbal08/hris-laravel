<?php

namespace App\Livewire\Department;

use Livewire\Component;

class DepartmentCreate extends Component
{
    public $name;
    public function render()
    {
        return view('livewire.department.department-create');
    }

    public function submit() {
        $this->validate([
            'name' => 'required'
        ]);

        \App\Models\Department::create([
            'name' => $this->name
        ]);

        // return redirect()->route('department.index');
        return to_route('department.index',)->with('success', 'Department created successfully');
    }
}
