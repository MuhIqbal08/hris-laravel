<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeLocation extends Model
{
    protected $table = 'office_location';
    public $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';


    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'radius_in_meters',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'radius_in_meters' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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
}
