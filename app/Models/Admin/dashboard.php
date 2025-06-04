<?php

namespace App\Models\admin;

use App\Models\User;
use App\Models\Users\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dashboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'farmers_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function farmers()
    {
        return $this->belongsTo(User::class, 'farmers_id');
    }
}
