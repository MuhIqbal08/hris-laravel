<?php

namespace App\Livewire\Leave;

use App\Models\LeaveRequest;
use Livewire\Component;

class LeaveShow extends Component
{
    public $leave;
    public function mount($uuid) {
        $this->leave = LeaveRequest::where('uuid', $uuid)->first();
    }
    public function render()
    {
        return view('livewire.leave.leave-show');
    }
}
