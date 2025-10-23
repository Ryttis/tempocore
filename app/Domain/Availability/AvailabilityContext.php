<?php

namespace App\Domain\Availability;

use App\Domain\Entities\ProviderSetting;
use App\Domain\ValueObjects\TimeRange;
use Carbon\CarbonImmutable;
use DateTimeImmutable;
use DateTimeZone;

/**
 * Represents contextual data for a specific availability computation:
 *  - Provider settings (lead times, buffers, horizons)
 *  - Local and UTC time references
 *  - Helpers to build/convert time ranges
 */
final class AvailabilityContext
{
    public function __construct(
        public readonly object $service,
        public readonly ProviderSetting $settings,
        public readonly DateTimeImmutable $day,
        public readonly DateTimeZone $timeZone,
        public readonly CarbonImmutable $currentUtc
    ) {
        $this->localDayStart = CarbonImmutable::instance($day)
            ->setTimezone($this->timeZone)
            ->startOfDay();

        $this->localDayEnd = $this->localDayStart->endOfDay();
    }

    /** Start of the day in provider’s local time. */
    public CarbonImmutable $localDayStart;

    /** End of the day in provider’s local time. */
    public CarbonImmutable $localDayEnd;

    /**
     * Build a local DateTimeImmutable from an "HH:mm" string.
     */
    public function atLocalTime(string $timeString): DateTimeImmutable
    {
        return new DateTimeImmutable(
            $this->localDayStart->format('Y-m-d') . ' ' . $timeString,
            $this->timeZone
        );
    }

    /**
     * Build a TimeRange from an exception window object
     * (expects ->startTime, ->endTime, ->type).
     */
    public function buildExceptionRange(object $exceptionWindow): TimeRange
    {
        $start = $exceptionWindow->startTime
            ? $this->atLocalTime($exceptionWindow->startTime)
            : $this->localDayStart;

        $end = $exceptionWindow->endTime
            ? $this->atLocalTime($exceptionWindow->endTime)
            : $this->localDayEnd;

        return new TimeRange($start, $end);
    }

    /**
     * UTC start/end of the current local day.
     *
     * @return array{0: CarbonImmutable, 1: CarbonImmutable}
     */
    public function dayUtcRange(): array
    {
        return [$this->localDayStart->utc(), $this->localDayEnd->utc()];
    }

    /**
     * Convert appointments and holds into local-time TimeRange objects.
     *
     * @param array<int, object> $appointments  objects with ->startsAt, ->endsAt
     * @param array<int, array{0:mixed,1:mixed}> $holds [startUtc, endUtc]
     * @return TimeRange[]
     */
    public function busyLocalRanges(array $appointments, array $holds): array
    {
        $localTimeZone = $this->timeZone;
        $ranges = [];

        foreach ($appointments as $appointment) {
            $ranges[] = new TimeRange(
                CarbonImmutable::instance($appointment->startsAt)->setTimezone($localTimeZone),
                CarbonImmutable::instance($appointment->endsAt)->setTimezone($localTimeZone)
            );
        }

        foreach ($holds as [$holdStartUtc, $holdEndUtc]) {
            $ranges[] = new TimeRange(
                CarbonImmutable::instance($holdStartUtc)->setTimezone($localTimeZone),
                CarbonImmutable::instance($holdEndUtc)->setTimezone($localTimeZone)
            );
        }

        return $ranges;
    }

    /**
     * Whether a UTC start time is within the bookable window
     * (min lead time and max horizon).
     */
    public function withinBookingWindow(CarbonImmutable $startUtc): bool
    {
        $earliestAllowedStart = $this->currentUtc->addMinutes($this->settings->minLeadTimeMinutes);
        $latestAllowedStart   = $this->currentUtc->addDays($this->settings->maxBookingHorizonDays);

        return $startUtc->gte($earliestAllowedStart) && $startUtc->lte($latestAllowedStart);
    }
}
