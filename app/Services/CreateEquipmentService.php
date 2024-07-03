<?php

namespace App\Services;

use App\Http\Requests\EquipmentStoreRequest;
use App\Models\Equipment;

class CreateEquipmentService
{
    public function make(EquipmentStoreRequest $request)
    {
        $equipment = Equipment::create([
            'equipment_type_id' => $request->input('equipment_type_id'),
        ]);
        return $equipment;
    }
}
