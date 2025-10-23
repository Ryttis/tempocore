<?php

namespace App\Domain\ValueObjects;

use DateTimeImmutable;

/**
 * Value object representing an inclusive date range.
 */
final class DateRange
{
    public function __construct(
        public DateTimeImmutable $startDate,
        public DateTimeImmutable $endDate,
    ) {
        if ($endDate < $startDate) {
            throw new \InvalidArgumentException('End date must be after start date.');
        }
    }

    /**
     * Returns all dates between startDate and endDate (inclusive).
     *
     * @return DateTimeImmutable[] List of DateTimeImmutable objects, one per day.
     */
    public function days(): array
    {
        $days = [];
        $cursor = $this->startDate;

        while ($cursor <= $this->endDate) {
            $days[] = $cursor;
            $cursor = $cursor->modify('+1 day');
        }

        return $days;
    }
}
