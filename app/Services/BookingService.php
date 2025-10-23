<?php

namespace App\Services;

use App\Domain\Entities\Appointment;
use App\Domain\Repositories\{AppointmentRepositoryInterface, ServiceRepositoryInterface};
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

final class BookingService
{
    public function __construct(
        private AppointmentRepositoryInterface $appointments,
        private ServiceRepositoryInterface $services,
    ) {}

    public function book(
        int $serviceId,
        string $clientEmail,
        DateTimeImmutable $startsAt
    ): Appointment {
        $service = $this->services->find($serviceId);
        if (!$service) {
            throw new InvalidArgumentException('Invalid service.');
        }

        $endsAt = $startsAt->modify("+{$service->durationMinutes} minutes");

        return DB::transaction(function () use ($service, $clientEmail, $startsAt, $endsAt) {

            $conflicts = $this->appointments->findOverlapping(
                $service->id,
                $startsAt,
                $endsAt
            );

            if ($conflicts) {
                throw new RuntimeException('Slot already booked.');
            }

            $appointment = new Appointment(
                id: 0,
                serviceId: $service->id,
                clientEmail: $clientEmail,
                startsAt: $startsAt,
                endsAt: $endsAt,
            );

            return $this->appointments->create($appointment);
        }, 3);
    }
}
