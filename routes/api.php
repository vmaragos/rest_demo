<?php

use App\Http\Controllers\VesselOpexesAPIController;
use App\Http\Controllers\VesselsAPIController;
use App\Http\Controllers\VoyagesAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/vessels', [VesselsAPIController::class, 'index']);

Route::post('/vessels', [VesselsAPIController::class, 'store']);

Route::post('/voyages', [VoyagesAPIController::class, 'store']);

Route::get('/voyages', [VoyagesAPIController::class, 'index']);

Route::put('/voyages/{voyage}', [VoyagesAPIController::class, 'update']);

Route::post('/vessels/{vessel}/vessel-opex', [VesselOpexesAPIController::class, 'store']);

Route::get('/vessels/{vessel}/financial-report', [VesselsAPIController::class, 'show']);