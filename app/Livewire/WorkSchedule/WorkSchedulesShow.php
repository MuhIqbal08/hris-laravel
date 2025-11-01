<?php

namespace App\Livewire\WorkSchedule;

use App\Models\WorkSchedule;
use Livewire\Component;

class WorkSchedulesShow extends Component
{   
    public $workSchedule ;

    public function mount($uuid) {
        $this->workSchedule = WorkSchedule::where('uuid', $uuid)->first();
    }
    public function render()
    {
        return view('livewire.work-schedule.work-schedules-show');
    }
}
