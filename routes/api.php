<?php

use Illuminate\Support\Facades\Route;
use App\Interfaces\Http\Controllers\{
    ServiceController,
    AvailabilityController,
    AppointmentController,
    WorkingHourController
};

Route::get('/services', [ServiceController::class, 'index']);

Route::get('/availability', [AvailabilityController::class, 'index']);

Route::post('/appointments', [AppointmentController::class, 'store']);

Route::get('/working-hours', [WorkingHourController::class, 'index']);
Route::post('/working-hours', [WorkingHourController::class, 'store']);
