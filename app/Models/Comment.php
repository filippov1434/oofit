<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    
    use HasFactory;

    protected $table = 'comments';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'comment_date',
        'comment'
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

    public function getAllCommentInfo() {
        $result = DB::select
        ('
            SELECT
            u.email as userEmail,
            c.comment_date as commentDate,
            c.comment as comment
            FROM comments c
            LEFT JOIN users u ON c.user_id = u.id
        ');
    return $result; 
    }

    public function getOneCommentInfo($id) {
        $result = DB::select
        ('
            SELECT
            u.email as userEmail,
            c.comment_date as commentDate,
            c.comment as comment
            FROM comments c
            LEFT JOIN users u ON c.user_id = u.id
            WHERE c.id = :id',
            ['id' => $id]
        );
        return $result[0];
    }
}