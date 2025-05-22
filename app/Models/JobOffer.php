<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'active',
        'clt',
        'pj',
        'freelancer'
    ];

    protected $casts = [
        'active' => 'boolean',
        'clt' => 'boolean',
        'pj' => 'boolean',
        'freelancer' => 'boolean'
    ];

    public function applicants()
    {
        return $this->belongsToMany(User::class, 'user_job_offer_applications')
            ->withPivot('deleted_at');
    }
}