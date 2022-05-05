<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Language extends Model
{
    
    use HasFactory;

    protected $table = 'languages';
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




    public function getAllLanguageInfo() {
        $result = DB::select
        ('
            SELECT
            l.name as languageName,
            s.name as statusName
            FROM languages l
            LEFT JOIN status s ON l.status_id = s.id
        ');
    return $result; 
    }

    public function getOneLanguageInfo($id) {
        $result = DB::select
        ('
            SELECT
            l.name as languageName,
            s.name as statusName
            FROM languages l
            LEFT JOIN status s ON l.status_id = s.id
            WHERE l.id = :id',
            ['id' => $id]
        );
        return $result[0];
    }

}