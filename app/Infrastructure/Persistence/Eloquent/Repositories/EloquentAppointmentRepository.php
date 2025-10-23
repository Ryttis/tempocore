<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Entities\Appointment;
use App\Domain\Repositories\AppointmentRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\EloquentAppointment;
use Carbon\CarbonInterface;
use DateTimeImmutable;

/**
 * Eloquent implementation of the AppointmentRepositoryInterface.
 */
final class EloquentAppointmentRepository implements AppointmentRepositoryInterface
{
    /**
     * @return Appointment[]
     */
    public function findOverlapping(int $serviceId, DateTimeImmutable $start, DateTimeImmutable $end): array
    {
        return EloquentAppointment::query()
            ->where('service_id', $serviceId)
            ->where('status', 'confirmed')
            ->where('starts_at_utc', '<', $end)
            ->where('ends_at_utc', '>', $start)
            ->get()
            ->map(fn (EloquentAppointment $model): Appointment => $this->toEntity($model))
            ->all();
    }

    public function create(Appointment $appointment): Appointment
    {
        $model = EloquentAppointment::create([
            'service_id'    => $appointment->serviceId,
            'client_email'  => $appointment->clientEmail,
            'starts_at_utc' => $appointment->startsAt->format('Y-m-d H:i:s'),
            'ends_at_utc'   => $appointment->endsAt->format('Y-m-d H:i:s'),
            'status'        => $appointment->status,
        ]);

        return $this->toEntity($model);
    }

    /**
     * @return Appointment[]
     */
    public function findByDateRange(DateTimeImmutable $startUtc, DateTimeImmutable $endUtc): array
    {
        return EloquentAppointment::query()
            ->whereBetween('starts_at_utc', [$startUtc, $endUtc])
            ->where('status', 'confirmed')
            ->get()
            ->map(fn (EloquentAppointment $model): Appointment => $this->toEntity($model))
            ->all();
    }

    /**
     * Convert an Eloquent model to a domain entity.
     */
    private function toEntity(EloquentAppointment $model): Appointment
    {
        $startsAt = $this->toImmutable($model->starts_at_utc);
        $endsAt   = $this->toImmutable($model->ends_at_utc);

        return new Appointment(
            id: $model->id,
            serviceId: $model->service_id,
            clientEmail: $model->client_email,
            startsAt: $startsAt,
            endsAt: $endsAt,
            status: $model->status ?? 'confirmed',
        );
    }

    /**
     * Safely convert Carbon|string|null → DateTimeImmutable.
     */
    private function toImmutable(mixed $value): DateTimeImmutable
    {
        if ($value instanceof CarbonInterface) {
            return new DateTimeImmutable($value->format('Y-m-d H:i:s'));
        }

        if (is_string($value)) {
            return new DateTimeImmutable($value);
        }

        return new DateTimeImmutable();
    }
}
