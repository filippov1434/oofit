<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPage extends Model
{
    protected $table = 'products_pages';
    protected $primaryKey = 'id';

    protected $fillable = [
        'page_id',
        'course_id'
    ];
}