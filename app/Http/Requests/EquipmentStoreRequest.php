<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Foundation\Http\FormRequest;

class EquipmentStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'equipments' => 'required|array',
            'equipments.*.equipment_type_id' => 'required|integer',
            'equipments.*.serial_number' => 'required|string',
            'equipments.*.desc' => 'string|nullable',
        ];
    }
}
