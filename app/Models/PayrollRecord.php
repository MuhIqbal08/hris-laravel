<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'period_month' => 'integer',
        'period_year' => 'integer',
        'working_days' => 'integer',
        'net_salary' => 'decimal:2',
        'details' => 'array',
        'is_paid' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
