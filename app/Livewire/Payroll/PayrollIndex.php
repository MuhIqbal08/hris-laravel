<?php

namespace App\Livewire\Payroll;

use App\Models\PayrollRecord;
use Livewire\Component;

class PayrollIndex extends Component
{
    public function render()
    {
        $user = auth()->user();

        if($user->hasRole('Admin')) {
            $payrolls = PayrollRecord::with('employee')->latest()->paginate(); 
        } else {
            $payrolls = PayrollRecord::where('employee_id', $user->employee->uuid)->with('employee')->latest()->paginate();
        }
        return view('livewire.payroll.payroll-index', compact('payrolls'));
    }

    public function delete($uuid) {
        $payroll = PayrollRecord::find($uuid);
        $payroll->delete();

        return to_route('payroll.index')->with('success', 'Payroll deleted successfully');
    }

    public function paid($uuid) {
        $payroll = PayrollRecord::where('uuid', $uuid)->firstOrFail();
        $payroll->is_paid = true;
        $payroll->save();

        session()->flash('success', 'Payroll marked as paid successfully');
    }

}
