<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string desc
 * @property string equipment_type_id
 * @property string serial_number
 * @property string q
 */
class EquipmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'equipment_type_id' => 'integer',
            'serial_number' => 'string',
            'q' => 'string',
            'desc' => 'string|nullable'
        ];
    }
}
