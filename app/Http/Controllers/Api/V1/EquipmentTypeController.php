<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\EquipmentTypeCollection;
use App\Http\Resources\EquipmentTypeResource;
use App\Models\EquipmentType;

class EquipmentTypeController extends Controller
{
    //
    public function index()
    {
        return new EquipmentTypeCollection(EquipmentType::paginate());
    }
}
