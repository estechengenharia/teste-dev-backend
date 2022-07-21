<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class JobUser extends Pivot
{
    use HasFactory;

    protected $table = "job_user";

    protected $fillable = ["user_id", "job_id"];

}
