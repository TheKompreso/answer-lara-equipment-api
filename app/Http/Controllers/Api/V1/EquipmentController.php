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
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    private EquipmentService $equipmentService;

    public function __construct()
    {
        // Надо подумать над тем, где лучше внедрять сервис через конструктор
        $this->equipmentService = new EquipmentService();
    }

    public function index(EquipmentRequest $request): JsonResponse|EquipmentCollection
    {
        $query = Equipment::query();
        if($request->hasAny(['equipment_type_id', 'serial_number', 'desc']))
        {
            if($request->has('equipment_type_id')) $query->where('equipment_type_id', $request->equipment_type_id);
            if($request->has('serial_number')) $query->where('serial_number', $request->serial_number);
            if($request->has('desc')) $query->where('desc', $request->desc);
        }
        else if(!$request->has('q')) return response()->json(['error' => 'Parameters not specified'], 400);

        return new EquipmentCollection($query->paginate(config('api.paginate_page_size', '')));
    }

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

    public function update(EquipmentRequest $request, int $id): Equipment|JsonResponse
    {
        $equipment = Equipment::where('id', $id)->first();
        if($equipment == null) return response()->json(['error' => 'Not found'], 404);
        return $this->equipmentService->update($equipment, $request->input());
    }

    public function show(Request $request, int $id): JsonResponse|EquipmentResource
    {
        $equipment = Equipment::where('id', $id)->first();
        if($equipment == null) return response()->json(['error' => 'Not found'], 404);
        return new EquipmentResource($equipment);
    }

    public function destroy(int $id): JsonResponse
    {
        $equipment = Equipment::where('id', $id)->first();
        if($equipment == null) return response()->json(['error' => 'Not found'], 404);
        $equipment->delete();
        return response()->json(['success' => 'Deleted'], 200);
    }
}
