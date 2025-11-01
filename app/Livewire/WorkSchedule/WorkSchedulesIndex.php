<?php

namespace App\Livewire\WorkSchedule;

use App\Models\WorkSchedule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class WorkSchedulesIndex extends Component
{
    public $search;
    public function render()
    {
        // $workSchedules = WorkSchedule::all();
        $workSchedules = WorkSchedule::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->paginate(15);
        return view('livewire.work-schedule.work-schedules-index', compact('workSchedules'));
    }

    public function delete($uuid) {
        $workSchedule = WorkSchedule::where('uuid', $uuid)->firstOrFail();
        $workSchedule->delete();

        Toaster::success('Work Schedule deleted successfully');
        session()->flash('success', 'Work Schedule deleted successfully');
    }
}
