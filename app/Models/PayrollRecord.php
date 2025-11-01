<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PayrollRecord extends Model
{
    //
    public $primaryKey = 'uuid';
    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'period_month',
        'period_year',
        'working_days',
        'net_salary',
        'details',
        'is_paid',
    ];

    protected $casts = [
        'details' => 'array',
        'is_paid' => 'boolean',
        'net_salary' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'uuid');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
