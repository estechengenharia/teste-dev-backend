<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataCsv extends Model
{
    use HasFactory;

    protected $table = 'data_csv';

    protected $fillable = ['data','temperatura'];

    public $timestamps = false;
}
