<?php

use App\Interfaces\Http\Controllers\{
    AppointmentController,
    AvailabilityController,
    ServiceController,
    WorkingHourController
};
use Illuminate\Support\Facades\Route;

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/availability', [AvailabilityController::class, 'index']);
Route::post('/appointments', [AppointmentController::class, 'store']);
Route::put('/working-hours/{id}', [WorkingHourController::class, 'update']);
Route::get('/working-hours', [WorkingHourController::class, 'index']);
Route::post('/working-hours', [WorkingHourController::class, 'store']);
