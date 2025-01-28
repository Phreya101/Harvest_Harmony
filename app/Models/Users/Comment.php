<?php

namespace App\Models\users;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'comment',
        'thread_id',
        'farmers_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'farmers_id'); // Relationship to users table
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id'); // Relationship to thread table
    }

    public function replies()
    {
        return $this->hasMany(Replies::class);
    }
}
