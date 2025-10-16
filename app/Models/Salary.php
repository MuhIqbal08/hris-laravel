<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    //
    public $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

     protected $fillable = [
        'employee_id',
        'basic_salary',
        'allowances',
        'deductions',
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'allowances' => 'array',  
        'deductions' => 'array',  
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}