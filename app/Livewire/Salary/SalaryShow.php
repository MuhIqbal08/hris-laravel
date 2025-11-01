<?php

namespace App\Livewire\Salary;

use App\Models\Salary;
use Livewire\Component;

class SalaryShow extends Component
{
    public $salary;
    public function mount($uuid) {
        $this->salary = Salary::where('uuid', $uuid)->first();
    }
    public function render()
    {
        return view('livewire.salary.salary-show');
    }
}
