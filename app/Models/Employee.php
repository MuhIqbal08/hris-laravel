<?php

namespace App\Models;

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

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
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
