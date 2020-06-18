<?php

use App\Http\Controllers\Api\CarParkController;
use Illuminate\Support\Facades\Route;

Route::get('/car-parks', [CarParkController::class, 'listCarParks']);
Route::get('/car-parks/reports', [CarParkController::class, 'listCarReports']);
Route::get('/car-parks/{uuid}', [CarParkController::class, 'getCarPark']);
Route::post('/car-parks', [CarParkController::class, 'createCarPark']);
Route::post('/car-parks/{uuid}/cars', [CarParkController::class, 'carEnter']);
Route::put('/car-parks/{uuid}/cars/{licensePlate}/pay', [CarParkController::class, 'payParkingFee']);
Route::delete('/car-parks/{uuid}/cars/{licensePlate}', [CarParkController::class, 'carLeave']);
