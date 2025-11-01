<?php

namespace App\Livewire\Permission;

use App\Models\Permission;
use Livewire\Component;

class PermissionCreate extends Component
{
    public $name;
    public function render()
    {
        return view('livewire.permission.permission-create');
    }

    public function submit () {
        $this->validate([
            'name' => 'required|min:3',
        ]);
        Permission::create([
            'name' => $this->name,
            'guard_name' => 'web'
        ]);

        return to_route('permission.index')->with('success', 'Permission created successfully');
    }
}
