<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $with = ['equipmentType'];
    protected $dates = ['deleted_at'];

    protected $fillable = ['equipment_type_id', 'serial_number', 'desc'];
    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }
}
