<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Equipments;
use App\Models\User;

class Schedule extends Model
{
    use HasFactory;
    protected $table = 'events';
    // Define the table name if it's not the plural of the model name
    protected $fillable = ['start_date', 'end_date', 'equipment_id', 'farmer_id'];

    protected $dates = ['start_date', 'end_date'];
    public function equipment()
    {
        return $this->belongsTo(Equipments::class);  // Assuming Schedule belongs to Equipment
    }

    public function farmer()
    {
        return $this->belongsTo(User::class, 'farmer_id');  // Assuming farmer is a User model
    }
}
