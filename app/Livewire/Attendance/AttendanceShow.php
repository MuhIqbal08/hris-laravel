<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Livewire\Component;

class AttendanceShow extends Component
{
    public $attendance;
    public function mount ($uuid) {
        $this->attendance = Attendance::with('employee', 'workSchedule')->where('uuid', $uuid)->firstOrFail();
    }
    public function render()
    {
        return view('livewire.attendance.attendance-show');
    }
}
