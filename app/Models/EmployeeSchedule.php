<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSchedule extends Model
{
    public $primaryKey = 'uuid';
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'work_schedule_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'uuid');
    }

    public function workSchedule()
    {
        return $this->belongsTo(WorkSchedule::class, 'work_schedule_id', 'uuid');
    }

    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->{$model->getKeyName()})) {
            $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
        }
    });
}
}
