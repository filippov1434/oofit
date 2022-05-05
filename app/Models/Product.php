<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    

    protected $table = 'products';
    protected $primaryKey = 'id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status_id',
        'category_id',
        'language_id'
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

    public function getAllProduct() {

        $result  = DB::select('
           SELECT 
           pr.name as productName,
           st.name as statusName,
           pc.name as categoryName,
           l.name as languageName
           FROM products pr
           LEFT JOIN status st ON pr.status_id = st.id
           LEFT JOIN products_category pc ON pr.category_id = pc.id
           LEFT JOIN languages l ON pr.language_id = l.id
        ');
       return $result;
   }

   public function getOneProduct($id) {

        $result  = DB::select('
        SELECT 
        pr.name as productName,
        st.name as statusName,
        pc.name as categoryName,
        l.name as languageName
        FROM products pr
        LEFT JOIN status st ON pr.status_id = st.id
        LEFT JOIN products_category pc ON pr.category_id = pc.id
        LEFT JOIN languages l ON pr.language_id = l.id
        WHERE pr.id = :id',
        ['id' => $id]);
        return $result[0];
    }
  
}
