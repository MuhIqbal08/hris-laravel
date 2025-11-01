<?php

namespace App\Livewire\Role;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class RoleCreate extends Component
{
    public $name;
    public $permissions = [];
    public $allPermissions = [];

    public $searchPermission = '';
    
    public function mount()
    {
        $this->allPermissions = Permission::orderBy('name', 'asc')->get();
    }
    public function render()
    {
        return view('livewire.role.role-create');
    }

     public function selectAll()
    {
        $this->permissions = $this->allPermissions->pluck('name')->toArray();
    }

    public function unselectAll()
    {
        $this->permissions = [];
    }

    public function submit() {
        $this->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required'
        ]);

        $role = Role::create([
            'name' => $this->name    
        ]);

        $role->syncPermissions($this->permissions);

        return to_route('role.index',)->with('success', 'Role created successfully');
    }
}
