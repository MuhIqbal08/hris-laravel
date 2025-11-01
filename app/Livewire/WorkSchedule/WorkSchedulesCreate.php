<?php

namespace App\Livewire\WorkSchedule;

use App\Models\WorkSchedule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class WorkSchedulesCreate extends Component
{
    public $name, $start_time, $end_time;
    public function render()
    {
        return view('livewire.work-schedule.work-schedules-create');
    }

    public function submit() {
        $this->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        WorkSchedule::create([
            'name' => $this->name,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time
        ]);

        Toaster::success('Work Schedule created successfully');
        return redirect()->route('work.schedule.index', )->with('success', 'Work Schedule created successfully');
    }
}
