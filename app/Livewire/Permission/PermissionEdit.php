<?php

namespace App\Livewire\Permission;

use App\Models\Permission;
use Livewire\Component;

class PermissionEdit extends Component
{
    public $permissions, $name;
    public function mount($uuid) {
        $this->permissions = Permission::find($uuid);
        $this->name = $this->permissions->name;
    }
    public function render()
    {
        return view('livewire.permission.permission-edit');
    }

    public function submit () {
        $this->validate([
            'name' => 'required|min:3',
        ]);
        
        $this->permissions->name = $this->name;
        $this->permissions->guard_name = 'web';
        $this->permissions->save();

        return to_route('permission.index')->with('success', 'Permission updated successfully');
    }
}
