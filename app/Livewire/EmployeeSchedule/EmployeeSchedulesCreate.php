<?php

namespace App\Livewire\EmployeeSchedule;

use App\Models\Employee;
use App\Models\EmployeeSchedule;
use App\Models\WorkSchedule;
use Livewire\Component;

class EmployeeSchedulesCreate extends Component
{
    public $employees, $employee_id, $work_schedule_id, $start_date, $end_date;
    // public $employee = [];
    // public function mount () {
    //     this->employee
    // }

    public function mount()
{
    $this->employees = Employee::with('user')->get();

    // Jika employee_id belum ada, set default ke data pertama
    if ($this->employees->isNotEmpty() && !$this->employee_id) {
        $this->employee_id = $this->employees->first()->uuid;
    }
}

    public function render()
    {
        $employees = Employee::all();
        $workSchedules = WorkSchedule::all();
        return view('livewire.employee-schedule.employee-schedules-create', compact('employees', 'workSchedules'));
    }

    public function submit () {
        $this->validate([
            'employee_id' => 'required|exists:employees,uuid',
            'work_schedule_id' => 'required|exists:work_schedules,uuid',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $exists = EmployeeSchedule::where('employee_id', $this->employee_id)
        ->where(function ($query) {
            $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                ->orWhere(function ($q) {
                    $q->where('start_date', '<=', $this->start_date)
                      ->where('end_date', '>=', $this->end_date);
                });
        })
        ->exists();

    if ($exists) {
        session()->flash('error', 'Karyawan ini sudah memiliki jadwal pada rentang tanggal tersebut!');
        return;
    }

    EmployeeSchedule::create([
        'employee_id' => $this->employee_id,
        'work_schedule_id' => $this->work_schedule_id,
        'start_date' => $this->start_date,
        'end_date' => $this->end_date,
    ]);

        return to_route('employee.schedules.index',)->with('success', 'Employee Schedule created successfully');
    }
}
