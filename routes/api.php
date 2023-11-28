<?php

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
    Route::get('/workers', [WorkerIndexController::class, 'index'])->name('workers');
    Route::get('/machines', [MachineIndexController::class, 'index'])->name('machines');
    Route::get('/worker_history', [WorkerController::class, 'history'])->name('worker.log');
    Route::get('/machine_history', [MachineController::class, 'history'])->name('machine.log');
    Route::get('/worker_now', [WorkerController::class, 'now'])->name('worker.now');
    Route::get('/machine_now', [MachineController::class, 'now'])->name('machine.now');
    Route::post('/start', [CycleController::class, 'start'])->name('start');
    Route::put('/end', [CycleController::class, 'end'])->name('end');
});

Route::post('/login', ['as' => 'login']);
