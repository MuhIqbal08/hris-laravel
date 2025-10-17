<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
    ];

    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->{$model->getKeyName()})) {
            $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
        }
    });
}

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }


}
