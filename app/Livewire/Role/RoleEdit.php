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
    public $originalPermissions = [];

    public function mount($uuid)
    {
        $this->role = Role::where('uuid', $uuid)->firstOrFail();
        $this->allPermissions = Permission::orderBy('name', 'asc')->get();
        $this->name = $this->role->name;

        // Simpan permission awal
        $this->permissions = $this->role->permissions->pluck('name')->toArray();
        $this->originalPermissions = $this->permissions;
    }

    public function render()
    {
        return view('livewire.role.role-edit');
    }

    public function selectAll()
    {
        $this->permissions = $this->allPermissions->pluck('name')->toArray();
    }

    public function unselectAll()
    {
        $this->permissions = [];
    }

    public function restoreOriginal()
    {
        $this->permissions = $this->originalPermissions;
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|unique:roles,name,' . $this->role->uuid . ',uuid',
            'permissions' => 'required'
        ]);

        $this->role->update(['name' => $this->name]);
        $this->role->syncPermissions($this->permissions);

        return to_route('role.index')->with('success', 'Role updated successfully');
    }
}
