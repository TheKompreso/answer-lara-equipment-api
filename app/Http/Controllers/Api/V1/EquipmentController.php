<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentStoreRequest;
use App\Http\Resources\EquipmentCollection;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    //
    public function index()
    {
        return new EquipmentCollection(Equipment::paginate());
    }
    public function store(Request $request)
    {
        dd($request);
        //$this->CreateEquipmentService->make($request);
    }

    public function show(Request $request, int $id)
    {
        return new EquipmentResource(Equipment::findOrFail($id));
    }
}
