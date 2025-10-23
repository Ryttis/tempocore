<?php

namespace App\Application\DTO;

use DateTimeImmutable;

final class SlotDto
{
    public function __construct(
        public DateTimeImmutable $startUtc,
        public DateTimeImmutable $endUtc,
        public string $startLocal,
        public string $endLocal,
    ) {
    }
}
