<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentStoreRequest;
use App\Http\Requests\EquipmentRequest;
use App\Http\Resources\EquipmentCollection;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Services\EquipmentService;
use Illuminate\Http\JsonResponse;

class EquipmentController extends Controller
{
    private EquipmentService $equipmentService;

    public function __construct()
    {
        // Надо подумать над тем, где лучше внедрять сервис через конструктор
        $this->equipmentService = new EquipmentService();
    }

    /**
     * @param EquipmentRequest $request
     * @return JsonResponse|EquipmentCollection
     */
    public function index(EquipmentRequest $request): JsonResponse|EquipmentCollection
    {
        $query = Equipment::query();
        if($request->hasAny(['equipment_type_id', 'serial_number', 'desc']))
        {
            if($request->has('equipment_type_id')) $query->where('equipment_type_id', 'like', '%'.$request->equipment_type_id.'%');
            if($request->has('serial_number')) $query->where('serial_number', 'like', '%'.$request->serial_number.'%');
            if($request->has('desc')) $query->where('desc', 'like', '%'.$request->desc.'%');
        }
        else if($request->has('q'))
        {
            $query->where('equipment_type_id', 'like', '%'.$request->q.'%')->
                orWhere('serial_number', 'like', '%'.$request->q.'%')->
                orWhere('desc', 'like', '%'.$request->q.'%');
        }
        else $query->all();

        return new EquipmentCollection($query->paginate(config('api.paginate_page_size', '')));
    }

    /**
     * @param EquipmentStoreRequest $request
     * @return JsonResponse
     */
    public function store(EquipmentStoreRequest $request): JsonResponse
    {
        $response = [
            'errors' => [],
            'success' => [],
        ];

        $equipmentsArray = $request->input('equipments');
        for($i = 0; $i < count($equipmentsArray); $i++)
        {
            $result = $this->equipmentService->make($equipmentsArray[$i]);
            if($result instanceof Equipment){
                $response["success"][$i] = $result;
            }
            else{
                $response["errors"][$i] = $result;
            }
        }
        return response()->json($response, count($response["success"]) > 0 ? 201 : 400);
    }

    /**
     * @param EquipmentRequest $request
     * @param Equipment $equipment
     * @return Equipment|JsonResponse
     */
    public function update(EquipmentRequest $request, Equipment $equipment): Equipment|JsonResponse
    {
        return $this->equipmentService->update($equipment, $request->input());
    }

    /**
     * @param Equipment $equipment
     * @return JsonResponse|EquipmentResource
     */
    public function show(Equipment $equipment): JsonResponse|EquipmentResource
    {
        return new EquipmentResource($equipment);
    }

    /**
     * @param Equipment $equipment
     * @return JsonResponse
     */
    public function destroy(Equipment $equipment): JsonResponse
    {
        $equipment->delete();
        return response()->json(['success' => 'Deleted'], 200);
    }
}
