<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Appointment;
use DateTimeImmutable;

/**
 * Repository contract for accessing Appointment aggregates.
 */
interface AppointmentRepositoryInterface
{
    /**
     * Find appointments overlapping with a given time range for a specific service.
     *
     * @param int $serviceId
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @return Appointment[]  List of overlapping appointments
     */
    public function findOverlapping(int $serviceId, DateTimeImmutable $start, DateTimeImmutable $end): array;

    /**
     * Persist a new appointment entity.
     *
     * @param Appointment $appointment
     * @return Appointment  The created appointment entity
     */
    public function create(Appointment $appointment): Appointment;

    /**
     * Retrieve all appointments that fall within the provided date range.
     *
     * @param DateTimeImmutable $startUtc
     * @param DateTimeImmutable $endUtc
     * @return Appointment[]  List of appointments within the range
     */
    public function findByDateRange(DateTimeImmutable $startUtc, DateTimeImmutable $endUtc): array;
}
