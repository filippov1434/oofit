<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    
    use HasApiTokens, HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';
    //public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status_id'
    ];

    /**
     * The attributes that should be h_idden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //
    ];

    public function getAllUsersFullInfo() {

         $result  = DB::select('
            SELECT 
            u.id as userId,
            u.name as userName,
            u.email as userEmail,
            s.name as statusName,
            us.instagram as instagram,
            us.telegram as telegram,
            us.vk as vk,
            us.whatsapp as whatsapp,
            pl.productList

            FROM users u 
            LEFT JOIN status s ON u.status_id = s.id
            LEFT JOIN users_socials us ON u.id = us.user_id
            LEFT JOIN
                (SELECT up.user_id as userId,  GROUP_CONCAT(pr.name) as productList 
                FROM users_products up LEFT JOIN products pr ON up.product_id = pr.id
                GROUP BY up.user_id) pl ON u.id = pl.userId
         ');
        return $result;
    }

    public function getOneUserFullInfo($id) {
        $result = DB::select('
            SELECT 
            u.id as userId,
            u.name as userName,
            u.email as userEmail,
            s.name as statusName,
            us.instagram as instagram,
            us.telegram as telegram,
            us.vk as vk,
            us.whatsapp as whatsapp,
            pl.productList as productList

            FROM users u 
            LEFT JOIN status s ON u.status_id = s.id
            LEFT JOIN users_socials us ON u.id = us.user_id
            LEFT JOIN
                (SELECT up.user_id as userId,  GROUP_CONCAT(pr.name) as productList 
                FROM users_products up LEFT JOIN products pr ON up.product_id = pr.id
                GROUP BY up.user_id) pl ON u.id = pl.userId
            WHERE u.id = :id',
            ['id' => $id]);
     return $result[0];
    }

    public function getCurrentProducts($id) {
        $result = DB::select('
            SELECT 
            pl.productList as productList
            FROM users u 
            LEFT JOIN
                (SELECT up.user_id as userId,  GROUP_CONCAT(pr.id) as productList 
                FROM users_products up LEFT JOIN products pr ON up.product_id = pr.id
                GROUP BY up.user_id) pl ON u.id = pl.userId
            WHERE u.id = :id',
            ['id' => $id]);
         return $result[0];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

  
}
