<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Schedule;

class Equipments extends Model
{
    use HasFactory;

    protected $table = 'equipments';
    protected $fillable = ['name'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class); // An equipment can have many events
    }
}
