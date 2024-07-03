<?php

namespace App\Services;

use App\Http\Requests\EquipmentStoreRequest;
use App\Models\Equipment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateEquipmentService
{
    public function make(array $array)
    {
        $validator = Validator::make($array,
            [
                'equipment_type_id' => 'required|exists:equipment_types,id',
                'serial_number' => 'required|unique:equipment,serial_number,null,id,equipment_type_id,' . $array['equipment_type_id'],
            ],
            [
                'serial_number.unique' => 'The (equipment_type_id, serial_number) has already been taken.'
            ]
        );
        if($validator->fails()){
            return $validator->errors()->messages();
        }

        $equipment = Equipment::create([
            'equipment_type_id' => $array['equipment_type_id'],
            'serial_number' => $array['serial_number'],
            'desc' => $array['desc']
        ]);
        return $equipment;
    }
}
