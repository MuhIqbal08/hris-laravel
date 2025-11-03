<?php

namespace App\Livewire\Dashboard;

use App\Models\Attendance;
use App\Models\PayrollRecord;
use Carbon\Carbon;
use Livewire\Component;

class DashboardUserIndex extends Component
{
    public function render()
    {
        $user = auth()->user();
        $employee = $user->employee;
        $today = Carbon::today();

        // --- Kehadiran Hari Ini ---
        $todayAttendance = Attendance::where('employee_id', $employee->uuid ?? null)
            ->whereDate('date', $today)
            ->first();

        // --- Statistik Mingguan ---
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        $weeklyStats = [
            'present' => Attendance::where('employee_id', $employee->uuid ?? null)
                ->whereBetween('date', [$weekStart, $weekEnd])
                ->where('status', 'present')
                ->count(),
            'late' => Attendance::where('employee_id', $employee->uuid ?? null)
                ->whereBetween('date', [$weekStart, $weekEnd])
                ->where('status', 'late')
                ->count(),
            'on_leave' => Attendance::where('employee_id', $employee->uuid ?? null)
                ->whereBetween('date', [$weekStart, $weekEnd])
                ->where('status', 'on leave')
                ->count(),
        ];

        // --- Gaji Terakhir ---
        $lastPayroll = PayrollRecord::where('employee_id', $employee->uuid ?? null)
            ->latest('created_at')
            ->first();
            
        return view('livewire.dashboard.dashboard-user-index', compact('user', 'employee', 'todayAttendance', 'weeklyStats', 'lastPayroll'));
    }
}
