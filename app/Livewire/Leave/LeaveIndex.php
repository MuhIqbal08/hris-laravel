<?php

namespace App\Livewire\Leave;

use App\Models\LeaveRequest;
use Livewire\Component;

class LeaveIndex extends Component
{
    // public 
    public function render()
    {
        $user = auth()->user();

        if($user->hasRole('Admin')) {
            $leaves = LeaveRequest::paginate(15);
        } else {
            $leaves = LeaveRequest::where('employee_id', $user->employee->uuid)->paginate(15);
        }
        return view('livewire.leave.leave-index', ['leaves' => $leaves]);
    }

    public function approval($uuid) {
        $leave = LeaveRequest::where('uuid', $uuid)->first();
        $leave->status = 'approved';
        $leave->approved_by = auth()->user()->employee->uuid;
        $leave->save();
        return session()->flash('success', 'Leave request approved successfully');
    }

    public function reject($uuid) {
        $leave = LeaveRequest::where('uuid', $uuid)->first();
        $leave->status = 'rejected';
        $leave->save();

        return session()->flash('success', 'Leave request rejected successfully');
    }

    public function delete($uuid) {
        $leave = LeaveRequest::where('uuid', $uuid)->first();
        $leave->delete();

        return session()->flash('success', 'Leave request deleted successfully');
    }
}
