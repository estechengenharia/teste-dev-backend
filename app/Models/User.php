<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes;

    protected $table = 'user';

    protected $dates = ['deleted_at'];

    protected $fillable = ['name','cpf','professional_resume','user_type','email','senha'];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y',
        'updated_at' => 'datetime:d/m/Y'
    ];

    protected $hidden = [
        'senha',
        'remember_token',
    ];

    public function getAuthPassword()
    {
      return $this->senha;
    }

    public function setPasswordAttribute($password){
        $this->attributes['senha'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
    }

    

}
