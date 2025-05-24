<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemperatureData extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['recorded_at', 'temperature'];
    
    protected $casts = [
        'recorded_at' => 'datetime',
        'temperature' => 'decimal:1'
    ];
}
