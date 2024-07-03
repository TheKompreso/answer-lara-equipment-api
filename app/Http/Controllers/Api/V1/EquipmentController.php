<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentStoreRequest;
use App\Http\Requests\EquipmentRequest;
use App\Http\Resources\EquipmentCollection;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Services\EquipmentService;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    private $equipmentService;

    public function __construct()
    {
        // Надо подумать над тем, где лучше внедрять сервис через конструктор
        $this->equipmentService = new EquipmentService();
    }

    //
    public function index(EquipmentRequest $request)
    {
        $query = Equipment::query();
        if(!$request->has('q'))
        {
            if($request->has('equipment_type_id')) $query->where('equipment_type_id', $request->equipment_type_id);
            if($request->has('serial_number')) $query->where('serial_number', $request->serial_number);
            if($request->has('desc')) $query->where('desc', $request->desc);
        }
        return new EquipmentCollection($query->paginate(config('api.paginate_page_size', '')));
    }
    public function store(EquipmentStoreRequest $request)
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
        return $response;
    }

    public function update(EquipmentRequest $request, int $id)
    {
        $equipment = Equipment::where('id', $id)->first();
        if($equipment == null) return response()->json(['error' => 'Not found'], 404);
        return $this->equipmentService->update($equipment, $request->input());
    }

    public function show(Request $request, int $id)
    {
        $equipment = Equipment::where('id', $id)->first();
        if($equipment == null) return response()->json(['error' => 'Not found'], 404);
        return new EquipmentResource($equipment);
    }
    public function destroy(int $id)
    {
        $equipment = Equipment::where('id', $id)->first();
        if($equipment == null) return response()->json(['error' => 'Not found'], 404);
        $equipment->delete();
        return response()->json(['success' => 'Deleted'], 200);
    }
}
