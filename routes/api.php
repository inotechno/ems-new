<?php

use App\Http\Controllers\Api\AccessControl;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'machines'], function () {
    Route::get('/', [\App\Http\Controllers\Api\MachineController::class, 'index']);
    Route::get('/{id}', [\App\Http\Controllers\Api\MachineController::class, 'show']);
    Route::post('/', [\App\Http\Controllers\Api\MachineController::class, 'store']);
    Route::put('/{id}', [\App\Http\Controllers\Api\MachineController::class, 'update']);
    Route::delete('/{id}', [\App\Http\Controllers\Api\MachineController::class, 'destroy']);
});

Route::post('/access-control', [AccessControl::class, 'index']);
