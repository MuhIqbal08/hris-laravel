<?php

namespace App\Livewire\Role;

use App\Models\Role;
use Livewire\Component;

class RoleShow extends Component
{
    public $role;

    public function mount($uuid) {
        $this->role = Role::where('uuid', $uuid)->first();
    }

    public function render()
    {
        return view('livewire.role.role-show');
    }
}
