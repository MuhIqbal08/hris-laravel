<?php

namespace App\Livewire\WorkSchedule;

use App\Models\WorkSchedule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class WorkSchedulesEdit extends Component
{
    public $workSchedule, $name, $start_time, $end_time;
    public function mount($uuid)
    {
        $this->workSchedule = WorkSchedule::where('uuid', $uuid)->first();
        $this->name = $this->workSchedule->name;
        $this->start_time = \Carbon\Carbon::parse($this->workSchedule->start_time)->format('H:i');
        $this->end_time = \Carbon\Carbon::parse($this->workSchedule->end_time)->format('H:i');

    }
    public function render()
    {
        return view('livewire.work-schedule.work-schedules-edit');
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        $this->workSchedule->name = $this->name;
        $this->workSchedule->start_time = $this->start_time;
        $this->workSchedule->end_time = $this->end_time;
        $this->workSchedule->save();

        Toaster::success('Work Schedule updated successfully');
        return redirect()->route('work.schedule.index', )->with('success', 'Work Schedule updated successfully');
    }
}
