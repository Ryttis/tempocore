<?php

namespace App\Domain\Entities;

final class ExceptionWindow
{
    public function __construct(
        public int                $id,
        public \DateTimeImmutable $date,
        public ?string            $startTime,
        public ?string            $endTime,
        public string             $type,
    )
    {
    }
}

