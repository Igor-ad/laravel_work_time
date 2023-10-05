<?php

use App\Enums\PathEnum as Path;
use App\Http\Controllers\Api\CycleController;
use App\Http\Controllers\Api\MachineController;
use App\Http\Controllers\Api\MachineIndexController;
use App\Http\Controllers\Api\WorkerController;
use App\Http\Controllers\Api\WorkerIndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:api'])->group(callback: function () {
    Route::get(Path::getWorkers->value, [WorkerIndexController::class, 'index']);
    Route::get(Path::getMachines->value, [MachineIndexController::class, 'index']);
    Route::get(Path::getWorkerHistory->value, [WorkerController::class, 'history']);
    Route::get(Path::getMachineHistory->value, [MachineController::class, 'history']);
    Route::get(Path::getWorkerNow->value, [WorkerController::class, 'now']);
    Route::get(Path::getMachineNow->value, [MachineController::class, 'now']);
    Route::post(Path::setStart->value, [CycleController::class, 'start']);
    Route::put(Path::setEnd->value, [CycleController::class, 'end']);
});
