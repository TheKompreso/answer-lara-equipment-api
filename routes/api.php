<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\EquipmentController;
use App\Http\Controllers\Api\V1\EquipmentTypeController;

Route::apiResource('/equipment', EquipmentController::class);
Route::get('/equipment-type', [EquipmentTypeController::class, 'index']);
