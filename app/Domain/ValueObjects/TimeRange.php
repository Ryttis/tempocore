<?php

namespace App\Domain\ValueObjects;

use DateTimeImmutable;

final class TimeRange
{
    public function __construct(
        public DateTimeImmutable $start,
        public DateTimeImmutable $end,
    ) {
        if ($end <= $start) {
            throw new \InvalidArgumentException('End must be after start.');
        }
    }

    public function durationMinutes(): int
    {
        return (int) (($this->end->getTimestamp() - $this->start->getTimestamp()) / 60);
    }

    public function overlaps(self $other): bool
    {
        return $this->start < $other->end && $this->end > $other->start;
    }

    public function contains(DateTimeImmutable $time): bool
    {
        return $time >= $this->start && $time <= $this->end;
    }
}
