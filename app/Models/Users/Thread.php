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
}
