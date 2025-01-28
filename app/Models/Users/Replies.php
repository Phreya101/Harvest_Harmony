<?php

namespace App\Models\users;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replies extends Model
{
    use HasFactory;

    protected $table = 'replies';

    protected $fillable = [
        'reply',
        'comment_id',
        'farmers_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'farmers_id'); // Relationship to users table
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id'); // Relationship to thread table
    }
}
