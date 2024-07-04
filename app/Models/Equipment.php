<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static Builder|Equipment query()
 * @method static Builder|Equipment create()
 * @property EquipmentType equipmentType
 */
class Equipment extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $with = ['equipmentType'];
    protected $dates = ['deleted_at'];

    protected $fillable = ['equipment_type_id', 'serial_number', 'desc'];

    /**
     * Pulls its EquipmentType from the database.
     */
    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }
}
