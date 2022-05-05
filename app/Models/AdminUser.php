<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class AdminUser extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'admin_users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'statusId'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}