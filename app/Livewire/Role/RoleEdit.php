<?php

namespace App\Livewire\Role;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class RoleEdit extends Component
{
    public $name, $role;
    public $allPermissions = [];
    public $permissions = [];

    public function mount($uuid) {
        $this->role = Role::where('uuid', $uuid)->first();
        $this->allPermissions = Permission::get();
        $this->name = $this->role->name;
        $this->permissions = $this->role->permissions->pluck('name');
    }

    public function render()
    {
        return view('livewire.role.role-edit');
    }

    public function submit() {
        $this->validate([
            'name' => 'required|unique:roles,name,' . $this->role->uuid . ',uuid',
            'permissions' => 'required'
        ]);

        $this->role->name = $this->name;
        $this->role->save();

        $this->role->syncPermissions($this->permissions);

        return to_route('role.index',)->with('success', 'Role updated successfully');
    }
}
