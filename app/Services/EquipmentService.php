<?php

namespace App\Services;

use App\Http\Requests\EquipmentStoreRequest;
use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use function Laravel\Prompts\error;

class EquipmentService
{
    public function update(Equipment $equipment, array $array)
    {
        if(!isset($array['equipment_type_id'])) $array['equipment_type_id'] = $equipment['equipment_type_id'];
        if(!isset($array['serial_number'])) $array['serial_number'] = $equipment['serial_number'];

        $validator = Validator::make($array,
            [
                'equipment_type_id' => 'integer|exists:equipment_types,id',
                'serial_number' => ['string','unique:equipment,serial_number,'.$equipment['id'].',id,equipment_type_id,' . $array['equipment_type_id']]
            ]);

        if($validator->fails()){
            return $validator->errors()->messages();
        }



        $equipmentType = EquipmentType::where('id', $array['equipment_type_id'])->first();
        if($equipmentType == null){
            return ['error' => 'The equipment type does not exist.'];
        }
        if(!$equipmentType->IsSeriesMatchMask($array['serial_number'])){
            return ['error' => 'The serial_number doesn\'t match the mask.'];
        }

        $equipment->update($array);
        return $equipment;
    }

    public function make(array $array)
    {
        $validator = Validator::make($array,
            [
                'equipment_type_id' => ['required'],
                'serial_number' => ['required', 'unique:equipment,serial_number,null,id,equipment_type_id,' . $array['equipment_type_id']]
            ],
            [
                'serial_number.unique' => 'The (equipment_type_id, serial_number) has already been taken.'
            ]
        );
        if(!$validator->fails()){
            $equipmentType = EquipmentType::where('id', $array['equipment_type_id'])->first();
            if($equipmentType == null){
                $validator->errors()->add('equipment_type_id', 'The equipment type does not exist.');
            }
            else if(!$equipmentType->IsSeriesMatchMask($array['serial_number'])){
                $validator->errors()->add('serial_number', 'The serial_number doesn\'t match the mask.');
            }
        }

        if($validator->errors()->count() > 0){
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
