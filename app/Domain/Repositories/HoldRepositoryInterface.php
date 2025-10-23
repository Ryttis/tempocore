<?php

namespace App\Domain\Repositories;

use DateTimeImmutable;

/**
 * Repository contract for accessing active hold intervals.
 */
interface HoldRepositoryInterface
{
    /**
     * Returns a list of active hold intervals within the given UTC date range.
     *
     * Each element is an array of two DateTimeImmutable objects:
     *  - [0] = start time (UTC)
     *  - [1] = end time (UTC)
     *
     * @param DateTimeImmutable $startUtc
     * @param DateTimeImmutable $endUtc
     *
     * @return array<int, array{0: DateTimeImmutable, 1: DateTimeImmutable}>
     */
    public function activeByRange(DateTimeImmutable $startUtc, DateTimeImmutable $endUtc): array;
}
