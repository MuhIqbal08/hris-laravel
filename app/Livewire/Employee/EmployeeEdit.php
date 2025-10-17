<?php

namespace App\Livewire\Employee;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;
use Livewire\Component;

class EmployeeEdit extends Component
{
    public $employee,$name, $email, $password, $position, $department_id, $join_date, $allRoles;
    public $roles = [];

    public function mount($uuid) {
        $this->employee = Employee::with('user', 'department')->where('uuid', $uuid)->first();
        $this->name = $this->employee->user->name;
        $this->email = $this->employee->user->email;
        $this->position = $this->employee->position;
        $this->department_id = $this->employee->department->name;
        $this->join_date = $this->employee->join_date;
        $this->allRoles = Role::all();
        $this->roles = $this->employee->user->roles->pluck('name');
    }

    public function render()
    {
        $departments = Department::all();
        return view('livewire.employee.employee-edit', compact('departments'));
    }

    public function submit() {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->employee->user->uuid . ',uuid',
            'position' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,uuid',
            'join_date' => 'required|date',
        ]);

        $this->employee->user->name = $this->name;
        $this->employee->user->email = $this->email;
        $this->employee->user->save();
        $this->user->syncRoles($this->roles);

        $this->employee->position = $this->position;
        $this->employee->department_id = $this->department_id;
        $this->employee->join_date = $this->join_date;
        $this->employee->save();


        return to_route('employee.index',)->with('success', 'Employee updated successfully');
    }
}
