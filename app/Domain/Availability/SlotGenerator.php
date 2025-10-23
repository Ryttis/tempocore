<?php

namespace App\Domain\Availability;

use App\Application\DTO\SlotDto;
use App\Domain\ValueObjects\TimeRange;
use Carbon\CarbonImmutable;

/**
 * Generates bookable slots based on open time ranges and provider settings.
 */
final class SlotGenerator
{
    /**
     * Generate available slots for a given set of open intervals.
     *
     * @param TimeRange[]         $openIntervals
     * @param AvailabilityContext $context
     *
     * @return SlotDto[] List of available booking slots
     */
    public function generate(array $openIntervals, AvailabilityContext $context): array
    {
        if (empty($openIntervals)) {
            return [];
        }

        $generatedSlots = [];

        $slotGranularity = $context->settings->slotGranularity;
        $bufferBeforeMinutes = $context->settings->bufferBeforeMinutes;
        $bufferAfterMinutes = $context->settings->bufferAfterMinutes;
        $serviceDurationMinutes = $context->service->durationMinutes;

        foreach ($openIntervals as $timeRange) {
            $currentTime = $this->ceilToGranularity(
                CarbonImmutable::instance($timeRange->start),
                $slotGranularity
            );

            $endOfRange = CarbonImmutable::instance($timeRange->end);

            while (true) {
                $slotStartLocal = $currentTime->addMinutes($bufferBeforeMinutes);
                $slotEndLocal = $slotStartLocal->addMinutes($serviceDurationMinutes);
                $slotEndIncludingBuffer = $slotEndLocal->addMinutes($bufferAfterMinutes);

                if ($slotEndIncludingBuffer > $endOfRange) {
                    break;
                }

                $slotStartUtc = $slotStartLocal->utc();
                $slotEndUtc = $slotEndLocal->utc();

                // Skip if slot falls outside the booking window
                if (!$context->withinBookingWindow($slotStartUtc)) {
                    $currentTime = $currentTime->addMinutes($slotGranularity);
                    continue;
                }

                $generatedSlots[] = new SlotDto(
                    $slotStartUtc,
                    $slotEndUtc,
                    $slotStartLocal->format('H:i'),
                    $slotEndLocal->format('H:i')
                );

                $currentTime = $currentTime->addMinutes($slotGranularity);
            }
        }

        return $generatedSlots;
    }

    /**
     * Rounds a time up to the nearest granularity step.
     */
    private function ceilToGranularity(CarbonImmutable $time, int $minutes): CarbonImmutable
    {
        $time = $time->setSecond(0);
        $remainder = $time->minute % $minutes;

        return $remainder ? $time->addMinutes($minutes - $remainder) : $time;
    }
}
