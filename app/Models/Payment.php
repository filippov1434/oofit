<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    
    use HasFactory;

    protected $table = 'payments';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'payment_date',
        'user_id',
        'product_id',
        'price_rub',

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

    public function getAllPaymentInfo() {
        $result = DB::select
        ('
            SELECT 
            p.payment_date as paymentDate,
            p.price_rub as paymentPrice,
            u.name as userName,
            pr.name as productName

            FROM payments p
            LEFT JOIN users u ON p.user_id = u.id
            LEFT JOIN products pr ON p.product_id = pr.id
        ');
    return $result; 
    }


    public function getOnePaymentInfo($id) {
        $result = DB::select('
            SELECT 
            p.payment_date as paymentDate,
            p.price_rub as paymentPrice,
            u.name as userName,
            pr.name as productName

            FROM payments p
            LEFT JOIN users u ON p.user_id = u.id
            LEFT JOIN products pr ON p.product_id = pr.id
            WHERE p.id = :id',
            ['id' => $id]);
        return $result[0];
    }
}