<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryGroup extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'category_group';

    public function categories()
    {
        return $this->hasMany(Category::class, 'group_id');
    }
}