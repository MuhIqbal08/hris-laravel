<?php

namespace App\Livewire\Role;

use App\Models\Role;
use Livewire\Component;

class RoleIndex extends Component
{
    public $search;
    public function render()
    {
        $roles = Role::with('permissions')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(15);

        return view('livewire.role.role-index', compact('roles'));
    }

    public function delete($uuid) {
        $role = Role::where('uuid', $uuid)->firstOrFail();
        $role->delete();

        session()->flash('success', 'Role deleted successfully');
    }
}
