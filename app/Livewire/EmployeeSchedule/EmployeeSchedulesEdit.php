<?php

namespace App\Livewire\EmployeeSchedule;

use App\Models\Employee;
use App\Models\EmployeeSchedule;
use App\Models\WorkSchedule;
use Livewire\Component;

class EmployeeSchedulesEdit extends Component
{
    public $employee_schedules, $employee_id, $work_schedule_id, $start_date, $end_date;

    public function mount($uuid) {
        $this->employee_schedules = EmployeeSchedule::with('employee', 'workSchedule')->where('uuid', $uuid)->first();
        $this->employee_id = $this->employee_schedules->employee_id;
        $this->work_schedule_id = $this->employee_schedules->work_schedule_id;
        $this->start_date = $this->employee_schedules->start_date;
        $this->end_date = $this->employee_schedules->end_date;
    }

    public function render()
    {
        $employees = Employee::all();
        $workSchedules = WorkSchedule::all();
        return view('livewire.employee-schedule.employee-schedules-edit', compact('employees', 'workSchedules'));
    }

    public function submit() {
        $this->validate([
            'employee_id' => 'required|exists:employees,uuid',
            'work_schedule_id' => 'required|exists:work_schedules,uuid',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $this->employee_schedules->employee_id = $this->employee_id;
        $this->employee_schedules->work_schedule_id = $this->work_schedule_id;
        $this->employee_schedules->start_date = $this->start_date;
        $this->employee_schedules->end_date = $this->end_date;
        $this->employee_schedules->save();

        return to_route('employee-schedule.index',)->with('success', 'Employee Schedule updated successfully');
    }
}
