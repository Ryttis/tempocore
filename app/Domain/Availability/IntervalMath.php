<?php

namespace App\Domain\Availability;

use App\Domain\ValueObjects\TimeRange;
use DateTimeImmutable;

/**
 * Provides operations for merging and subtracting time intervals.
 */
final class IntervalMath
{
    /**
     * Merge overlapping or contiguous time ranges.
     *
     * @param TimeRange[] $ranges
     *
     * @return TimeRange[]
     */
    public function merge(array $ranges): array
    {
        if (empty($ranges)) {
            return [];
        }

        usort($ranges, fn (TimeRange $left, TimeRange $right) => $left->start <=> $right->start);

        $mergedRanges = [$ranges[0]];

        for ($index = 1; $index < count($ranges); $index++) {
            $previousRange = $mergedRanges[count($mergedRanges) - 1];
            $currentRange = $ranges[$index];

            if ($currentRange->start <= $previousRange->end) {
                $mergedRanges[count($mergedRanges) - 1] = new TimeRange(
                    $previousRange->start,
                    $currentRange->end > $previousRange->end
                        ? $currentRange->end
                        : $previousRange->end
                );
            } else {
                $mergedRanges[] = $currentRange;
            }
        }

        return $mergedRanges;
    }

    /**
     * Subtract one set of time ranges from another.
     *
     * @param TimeRange[] $baseRanges
     * @param TimeRange[] $rangesToSubtract
     *
     * @return TimeRange[]
     */
    public function subtract(array $baseRanges, array $rangesToSubtract): array
    {
        $remainingRanges = $baseRanges;

        foreach ($rangesToSubtract as $rangeToSubtract) {
            $updatedRanges = [];

            foreach ($remainingRanges as $baseRange) {
                foreach ($this->subtractSingleRange($baseRange, $rangeToSubtract) as $segment) {
                    $updatedRanges[] = $segment;
                }
            }

            $remainingRanges = $updatedRanges;
        }

        return $remainingRanges;
    }

    /**
     * Subtract a single range from another.
     *
     * @return TimeRange[]
     */
    private function subtractSingleRange(TimeRange $baseRange, TimeRange $rangeToSubtract): array
    {
        if (!($baseRange->start < $rangeToSubtract->end && $baseRange->end > $rangeToSubtract->start)) {
            return [$baseRange];
        }

        $result = [];

        if ($rangeToSubtract->start > $baseRange->start) {
            $result[] = new TimeRange($baseRange->start, $rangeToSubtract->start);
        }

        if ($rangeToSubtract->end < $baseRange->end) {
            $result[] = new TimeRange($rangeToSubtract->end, $baseRange->end);
        }

        return $result;
    }

    public function range(DateTimeImmutable $start, DateTimeImmutable $end): TimeRange
    {
        return new TimeRange($start, $end);
    }
}
