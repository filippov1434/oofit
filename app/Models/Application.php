<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Application extends Model
{
    
    use HasFactory;

    protected $table = 'applications';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'app_date'
    ];

    /**
     * The attributes that should be hidden for serialization.
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


    public function getAllApplicationInfo() {
        $result = DB::select
        ('
            SELECT 
            a.id as applicationId,
            a.app_date as applicationDate,
            u.name as userName,
            p.name as productName

            FROM applications a 
            LEFT JOIN users u ON a.user_id = u.id
            LEFT JOIN products p ON a.product_id = p.id
        ');
         return $result; 
    }


    public function getOneApplicationInfo($id) {
        $result = DB::select('
            SELECT 
            a.id as applicationId,
            a.app_date as applicationDate,
            u.name as userName,
            p.name as productName
            FROM applications a 
            LEFT JOIN users u ON a.user_id = u.id
            LEFT JOIN products p ON a.product_id = p.id
            WHERE a.id = :id',
            ['id' => $id]);
        return $result[0];
    }
}