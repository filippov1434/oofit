<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductCategory extends Model
{
    
    use HasFactory;

    protected $table = 'products_category';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status_id'
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

    //


    public function getAllProductCategoryInfo() {
        $result = DB::select
        ('
            SELECT
            pc.name as categoryName,
            s.name as statusName
            FROM products_category pc
            LEFT JOIN status s ON pc.status_id = s.id
        ');
        return $result; 
    }

    public function getOneProductCategoryInfo($id) {
        $result = DB::select
        ('
            SELECT
            pc.name as categoryName,
            s.name as statusName
            FROM products_category pc
            LEFT JOIN status s ON pc.status_id = s.id
            WHERE pc.id = :id',
            ['id' => $id]
        );
        return $result[0];
    }
}