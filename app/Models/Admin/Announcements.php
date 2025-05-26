<?php

namespace App\Models\Admin;

use App\Http\Controllers\Admin\CTRLannouncement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    use HasFactory;

    protected $fillable = [
        'what',
        'where',
        'when',
        'who',
        'body',

    ];

    // In your Announcement model
    public function incrementViews()
    {
        $this->views++;
        $this->save();  // Save the updated views count to the database
    }
}
