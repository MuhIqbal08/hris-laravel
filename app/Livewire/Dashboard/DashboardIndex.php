<?php

namespace App\Livewire\Dashboard;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\PayrollRecord;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class DashboardIndex extends Component
{
    public function render()
    {
        $user = auth()->user();
        $employee = $user->employee;
        $today = Carbon::today();

        if($user->hasRole('Admin')) {
            // Card
            $users = Employee::count();
            $todayAttendances = Attendance::where('date', $today)->count();
            $leavesToday = Attendance::where('date', $today)->where('status', 'Leave')->count();
            $payrollThisMonth = PayrollRecord::where('period_month', now()->month)->where('period_year', now()->year)->sum('net_salary');
    
            // Chart
            $attendancesChart = Attendance::selectRaw('YEAR(date) as year, MONTH(date) as month, COUNT(*) as total')
                ->whereBetween('date', [Carbon::now()->subMonths(11), Carbon::now()])
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();
    
            // Pie Chart
            $present = Attendance::whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'present')
                ->count();
    
            $late = Attendance::whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'late')
                ->count();
    
            $absent = Attendance::whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'absent')
                ->count();
    
            $onLeave = Attendance::whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'on leave')
                ->count();
    
            $attendacesPie = [
                'present' => $present,
                'late' => $late,
                'absent' => $absent,
                'on leave' => $onLeave
            ];

            $role = 'admin';
    
            return view('livewire.dashboard.dashboard-index', compact('users', 'todayAttendances', 'leavesToday', 'payrollThisMonth', 'attendancesChart', 'attendacesPie', 'role'));
        }
        else {
            $todayAttendance = Attendance::where('employee_id', $user->employee->id ?? null)
                ->whereDate('date', $today)
                ->first();

                // Chart
            $present = Attendance::where('employee_id', $user->employee->id ?? null)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'present')
                ->count();

            $late = Attendance::where('employee_id', $user->employee->id ?? null)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'late')
                ->count();

            $absent = Attendance::where('employee_id', $user->employee->id ?? null)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'absent')
                ->count();

            $onLeave = Attendance::where('employee_id', $user->employee->id ?? null)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'on leave')
                ->count();

            $attendanceChart = Attendance::selectRaw('MONTH(date) as month, COUNT(*) as total')
                ->where('employee_id', $user->employee->id ?? null)
                ->whereYear('date', now()->year)
                ->groupBy('month')
                ->pluck('total', 'month');
        }

    }
}
