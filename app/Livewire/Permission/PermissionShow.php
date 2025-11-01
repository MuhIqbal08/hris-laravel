<?php

namespace App\Livewire\Permission;

use App\Models\Permission;
use Livewire\Component;

class PermissionShow extends Component
{
    public $permission;
    public function mount($uuid) {
        $this->permission = Permission::find($uuid);
    }
    public function render()
    {
        return view('livewire.permission.permission-show');
    }
}
