<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'description',
        'type',
        'status'
    ];

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    protected static function booted()
    {
        static::creating(function ($job) {
            if (! $job->getKey()) {
                $job->{$job->getKeyName()} = Str::uuid();
            }
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_job', 'job_id', 'user_id');
    }
}
