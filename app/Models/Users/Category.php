<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    public function categoryGroup()
    {
        return $this->belongsTo(CategoryGroup::class, 'group_id');
    }
}