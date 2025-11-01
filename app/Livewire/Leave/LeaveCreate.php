<?php

namespace App\Livewire\Leave;

use App\Models\Employee;
use App\Models\LeaveRequest;
use Livewire\Component;

class LeaveCreate extends Component
{
    public $employees, $employee_id, $type, $start_date, $end_date, $reason;

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
        return view('livewire.leave.leave-create', compact('employees'));
    }

    public function submit()
    {
        $this->validate([
            'employee_id' => 'required',
            'type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
        ]);

        LeaveRequest::create([
            'employee_id' => $this->employee_id,
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'reason' => $this->reason,
            'status' => 'pending',
        ]);

        return to_route('leave.index', )->with('success', 'Leave Request created successfully');
    }
}
