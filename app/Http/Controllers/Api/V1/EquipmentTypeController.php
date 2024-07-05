<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentTypeRequest;
use Illuminate\Http\JsonResponse;

use App\Http\Resources\EquipmentTypeCollection;
use App\Models\EquipmentType;

class EquipmentTypeController extends Controller
{
    /**
     * @param EquipmentTypeRequest $request
     * @return EquipmentTypeCollection|JsonResponse
     */
    public function index(EquipmentTypeRequest $request): JsonResponse|EquipmentTypeCollection
    {
        $query = EquipmentType::query();
        if($request->hasAny(['name', 'mask']))
        {
            if($request->has('name')) $query->where('name', 'like', '%'.$request->name.'%');
            if($request->has('mask')) $query->where('mask', 'like', '%'.$request->mask.'%');
        }
        else if($request->has('q'))
        {
            $query->where('name', 'like', '%'.$request->q.'%')->
                orWhere('mask', 'like', '%'.$request->q.'%');
        }
        else $query->get();
        return new EquipmentTypeCollection($query->paginate(config('api.paginate_page_size', '')));
    }
}
