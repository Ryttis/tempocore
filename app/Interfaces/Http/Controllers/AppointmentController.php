<?php

namespace App\Interfaces\Http\Controllers;

use App\Interfaces\Http\Requests\CreateAppointmentRequest;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;

class AppointmentController
{
    public function __construct(private BookingService $booking) {}

    public function store(CreateAppointmentRequest $request): JsonResponse
    {
        $data = $request->validated();
        $appointment = $this->booking->book(
            $data['service_id'],
            $data['client_email'],
            new \DateTimeImmutable($data['starts_at'])
        );

        return response()->json([
            'id' => $appointment->id,
            'status' => 'booked',
        ], 201);
    }
}
