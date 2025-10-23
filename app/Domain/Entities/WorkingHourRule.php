<?php

namespace App\Domain\Entities;

final class WorkingHourRule
{
    public function __construct(
        public int $id,
        public int $dayOfWeek,
        public string $startTime,
        public string $endTime,
    ) {}
}

