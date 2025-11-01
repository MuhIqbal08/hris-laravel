<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'status',
        'approved_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Relasi ke employee yang mengajukan cuti.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'uuid');
    }

    /**
     * Relasi ke employee yang menyetujui cuti.
     */
    public function approver()
    {
        return $this->belongsTo(Employee::class, 'approved_by', 'uuid');
    }

    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->{$model->getKeyName()})) {
            $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
        }
    });

    static::updated(function ($leaveRequest) {
            // Hanya jalan ketika status berubah jadi approved
            if ($leaveRequest->status === 'approved') {
                $employeeId = $leaveRequest->employee_id;
                $type = strtolower($leaveRequest->type);

                // Ubah type ke status attendance yang sesuai
                $statusMap = [
                    'sick' => 'sick',
                    'leave' => 'on leave',
                    'izin' => 'on leave',
                    'cuti' => 'on leave',
                ];

                $attendanceStatus = $statusMap[$type] ?? 'on leave';

                $employeeSchedule = \App\Models\EmployeeSchedule::where('employee_id', $employeeId)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
                    ->first();

                $workScheduleId = $employeeSchedule?->work_schedule_id;

                $startDate = Carbon::parse($leaveRequest->start_date);
                $endDate = Carbon::parse($leaveRequest->end_date);

                for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                    \App\Models\Attendance::updateOrCreate(
                        [
                            'employee_id' => $employeeId,
                            'date' => $date->format('Y-m-d'),
                        ],
                        [
                            'status' => $attendanceStatus,
                            'check_in_time' => null,
                            'check_out_time' => null,
                            'work_schedule_id' => $workScheduleId,
                            'duration' => null,
                            'remarks' => $leaveRequest->reason,
                        ]
                    );
                }
            }
        });
}
}

