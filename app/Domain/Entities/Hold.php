<?php

namespace App\Domain\Entities;

final class Hold
{
    public function __construct(
        public int $id,
        public int $serviceId,
        public \DateTimeImmutable $startsAt,
        public \DateTimeImmutable $endsAt,
        public \DateTimeImmutable $expiresAt,
    ) {
    }
}
