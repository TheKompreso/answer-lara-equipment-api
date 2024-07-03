<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentStoreRequest;
use App\Http\Resources\EquipmentCollection;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Services\CreateEquipmentService;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    private $createEquipmentService;

    public function __construct()
    {
        // Надо подумать над тем, где лучше внедрять сервис через конструктор
        $this->createEquipmentService = new CreateEquipmentService();
    }

    //
    public function index()
    {
        return new EquipmentCollection(Equipment::paginate());
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
            $result = $this->createEquipmentService->make($equipmentsArray[$i]);
            if($result instanceof Equipment){
                $response["success"][$i] = $result;
            }
            else{
                $response["errors"][$i] = $result;
            }

        }

        return $response;

    }

    public function show(Request $request, int $id)
    {
        return new EquipmentResource(Equipment::findOrFail($id));
    }
}
