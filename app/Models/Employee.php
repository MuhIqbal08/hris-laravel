<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasRoles;
    public $primaryKey = 'uuid';
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        // 'uuid',
        'user_id',
        'employee_id',
        'position',
        'department_id',
        'join_date',
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uuid');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'uuid');
    }

    public function salaries()
    {
        return $this->hasOne(Salary::class, 'employee_id', 'uuid');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'employee_id', 'uuid');
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'employee_id', 'uuid');
    }

    public function employeeSchedules()
    {
        return $this->hasMany(EmployeeSchedule::class, 'employee_id', 'uuid');
    }

    public function activeSchedule()
    {
        $today = Carbon::today()->toDateString();
        
        return $this->hasOne(EmployeeSchedule::class)
                    ->where('start_date', '<=', $today)
                    ->where('end_date', '>=', $today);
    }

    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        parent::boot();

    static::deleting(function ($employee) {
        $employee->user()->delete();
    });
        if (empty($model->{$model->getKeyName()})) {
            $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
        }

        if (empty($model->employee_id)) {
                $latest = static::latest('created_at')->first();
                $number = 1;

                if ($latest && $latest->employee_id) {
                    $lastNumber = (int) str_replace('EMP-', '', $latest->employee_id);
                    $number = $lastNumber + 1;
                }

                $model->employee_id = 'EMP-' . str_pad($number, 5, '0', STR_PAD_LEFT);
            }
    });
}
}
