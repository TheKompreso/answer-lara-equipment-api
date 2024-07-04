<?php

namespace App\Http\Resources;

use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property EquipmentType equipmentType
 * @property string serial_number
 * @property string desc
 * @property string created_at
 * @property string updated_at
 */
class EquipmentResource extends JsonResource
{
    public static $wrap = 'equipment';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'equipment_type' => $this->equipmentType,
            'serial_number' => $this->serial_number,
            'desc' => $this->desc,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
