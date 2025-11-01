<?php

namespace App\Livewire\Permission;

use App\Models\Permission;
use Livewire\Component;

class PermissionIndex extends Component
{
    public function render()
    {
        $permissions = Permission::orderBy('name', 'asc')->paginate(15);
        return view('livewire.permission.permission-index', compact('permissions'));
    }

    public function delete($uuid) {
        $permission = Permission::find($uuid);
        $permission->delete();
        return to_route('permission.index')->with('success', 'Permission deleted successfully');
    }
}
