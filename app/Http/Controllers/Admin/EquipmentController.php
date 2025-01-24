<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Equipments;

class EquipmentController extends Controller
{
    public function index()
    {
        return Equipments::all()->map(function ($equipment) {
            return ['key' => $equipment->id, 'label' => $equipment->name];
        });
    }
}
