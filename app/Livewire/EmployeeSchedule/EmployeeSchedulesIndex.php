<?php

namespace App\Livewire\EmployeeSchedule;

use App\Models\EmployeeSchedule;
use Carbon\Carbon;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EmployeeSchedulesIndex extends Component
{
    public $search;
    public function render()
    {
        $user = auth()->user();

        if($user->hasRole('Admin')) {
            $employeeSchedules = EmployeeSchedule::with(['employee', 'workSchedule'])
                ->when($this->search, function ($query) {
                    $query->whereHas('employee', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                        $q->where('employee_id', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderByDesc('created_at')
                ->paginate(15);
        } else {
            $employeeSchedules = EmployeeSchedule::with(['employee', 'workSchedule'])
                ->where('employee_id', $user->employee->uuid)->paginate(15);
        }

        return view('livewire.employee-schedule.employee-schedules-index', compact('employeeSchedules'));
    }

    public function copyWeekSchedule () {
        $today = Carbon::now();

        $startOfWeek = $today->copy()->startOfWeek();
        $endOfWeek = $today->copy()->endOfWeek();

        $schedules = EmployeeSchedule::whereBetween('start_date', [$startOfWeek, $endOfWeek])->get();

        if($schedules->isEmpty()) {
            Toaster::warning('No employee schedule found for the week');
            session()->flash('warning', 'No employee schedule found for the week');
        }

        foreach ($schedules as $schedule) {
            $newStart = Carbon::parse($schedule->start_date)->addWeek();
            $newEnd = Carbon::parse($schedule->end_date)->addWeek();

            $exists = EmployeeSchedule::where('employee_id', $schedule->employee_id)
                ->where('work_schedule_id', $schedule->work_schedule_id)
                ->whereDate('start_date', $newStart)
                ->exists();
            
            if(!$exists) {
                EmployeeSchedule::create([
                    'employee_id' => $schedule->employee_id,
                    'work_schedule_id' => $schedule->work_schedule_id,
                    'start_date' => $newStart,
                    'end_date' => $newEnd
                ]);
            }
        }

        Toaster::success('Employee Schedule copied successfully');
        session()->flash('success', 'Employee Schedule copied successfully');
    }

    public function delete($uuid) {
        $employeeSchedule = EmployeeSchedule::where('uuid', $uuid)->firstOrFail();
        $employeeSchedule->delete();

        Toaster::success('Employee Schedule deleted successfully');
        session()->flash('success', 'Employee Schedule deleted successfully');
    }
}
