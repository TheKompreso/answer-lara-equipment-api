<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class EquipmentService
{
    /**
     * @param Equipment $equipment
     * @param array $array
     * @return Equipment|JsonResponse
     */
    public function update(Equipment $equipment, array $array): Equipment|JsonResponse
    {
        if(!isset($array['equipment_type_id'])) $array['equipment_type_id'] = $equipment['equipment_type_id'];
        if(!isset($array['serial_number'])) $array['serial_number'] = $equipment['serial_number'];

        $validator = Validator::make($array,
            [
                'equipment_type_id' => 'integer|exists:equipment_types,id',
                'serial_number' => ['string','unique:equipment,serial_number,'.$equipment['id'].',id,equipment_type_id,' . $array['equipment_type_id']]
            ]);

        if($validator->fails()){
            return response()->json($validator->errors()->messages(), 400);
        }

        $equipmentType = EquipmentType::where('id', $array['equipment_type_id'])->first();
        if($equipmentType == null){
            return response()->json(['error' => 'The equipment type does not exist.'], 400);
        }
        if(!$equipmentType->IsSeriesMatchMask($array['serial_number'])){
            return response()->json(['error' => 'The serial_number doesn\'t match the mask.'], 400);
        }

        $equipment->update($array);
        return $equipment;
    }

    /**
     * @param array $array
     * @return Equipment|Builder|array
     */
    public function make(array $array): Equipment|Builder|array
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

        return Equipment::create([
            'equipment_type_id' => $array['equipment_type_id'],
            'serial_number' => $array['serial_number'],
            'desc' => $array['desc']
        ]);
    }
}
