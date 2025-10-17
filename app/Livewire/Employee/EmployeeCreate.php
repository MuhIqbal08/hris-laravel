<?php

namespace App\Livewire\Employee;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EmployeeCreate extends Component
{
    public $name, $email, $password, $password_confirmation, $user_id, $employee_id, $allRoles, $position, $department_id, $join_date;
    public $roles = [];

    public function mount() {
        $this->allRoles = Role::all();
    }

    public function render()
    {
        $departments = Department::all();
        return view('livewire.employee.employee-create', compact('departments'));
    }

    public function submit() {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|same:password_confirmation',
            'roles' => 'required|array|min:1',
            'position' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,uuid',
            'join_date' => 'required|date',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->syncRoles($this->roles);

        Employee::create([
            'user_id' => $user->uuid,
            'position' => $this->position,
            'department_id' => $this->department_id,
            'join_date' => $this->join_date
        ]);


        return to_route('employee.index',)->with('success', 'Employee created successfully');
    }
}
