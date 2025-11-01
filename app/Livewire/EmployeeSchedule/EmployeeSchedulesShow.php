<?php

namespace App\Livewire\EmployeeSchedule;

use App\Models\EmployeeSchedule;
use Livewire\Component;

class EmployeeSchedulesShow extends Component
{
    public $employee_schedule;

    public function mount($uuid) {
        $this->employee_schedule = EmployeeSchedule::with('employee', 'workSchedule')->where('uuid', $uuid)->first();
    }

    public function render()
    {
        return view('livewire.employee-schedule.employee-schedules-show');
    }
}
