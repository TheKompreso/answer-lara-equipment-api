<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentTypeRequest;
use Illuminate\Http\Request;

use App\Http\Resources\EquipmentTypeCollection;
use App\Http\Resources\EquipmentTypeResource;
use App\Models\EquipmentType;

class EquipmentTypeController extends Controller
{
    //
    public function index(EquipmentTypeRequest $request)
    {
        $query = EquipmentType::query();
        if(!$request->has('q'))
        {
            if($request->has('name')) $query->where('name', $request->name);
            if($request->has('mask')) $query->where('mask', $request->mask);
        }
        return new EquipmentTypeCollection($query->paginate(config('api.paginate_page_size', '')));
    }
}
