<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Thread extends Model
{
    use HasFactory;

    protected $table = 'threads';
    // Allow mass assignment for these fields
    protected $fillable = [
        'title',
        'category_id',
        'farmers_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'farmers_id'); // Relationship to users table
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'); // Relationship to categories table
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function reply()
    {
        return $this->hasMany(Replies::class);
    }
}
