<?php

namespace App\Domain\Entities;

final class Service
{
    public function __construct(
        public int $id,
        public string $name,
        public int $durationMinutes,
        public ?float $price = null,
        public ?string $color = null,
    ) {}
}

