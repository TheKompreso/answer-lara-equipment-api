<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $with = ['equipmentType'];

    protected $fillable = ['equipment_type_id', 'serial_number', 'desc'];
    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }
}
