<?php

namespace App\Domain\Entities;

final class Appointment
{
    public function __construct(
        public int $id,
        public int $serviceId,
        public string $clientEmail,
        public \DateTimeImmutable $startsAt,
        public \DateTimeImmutable $endsAt,
        public string $status = 'confirmed',
        public ?string $clientName = null,
        public ?string $clientPhone = null,
    ) {
    }
}
