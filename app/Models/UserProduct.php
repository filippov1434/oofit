<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    

    protected $table = 'users_products';
    protected $primaryKey = 'id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'user_id',
        'product_id'
    ];
    
    //protected $guarded = [];
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

  
}
