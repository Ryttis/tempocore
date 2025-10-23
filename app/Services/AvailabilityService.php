<?php

namespace App\Services;

use App\Application\DTO\SlotDto;
use App\Domain\Availability\{AvailabilityContext, IntervalMath, SlotGenerator};
use App\Domain\Entities\ProviderSetting;
use App\Domain\Repositories\{AppointmentRepositoryInterface,
    ExceptionWindowRepositoryInterface,
    HoldRepositoryInterface,
    ServiceRepositoryInterface,
    WorkingHourRepositoryInterface
};
use App\Domain\ValueObjects\TimeRange;
use Carbon\CarbonImmutable;
use DateTimeImmutable;
use DateTimeZone;

final class AvailabilityService
{
    public function __construct(
        private readonly WorkingHourRepositoryInterface     $workingHours,
        private readonly AppointmentRepositoryInterface     $appointments,
        private readonly ExceptionWindowRepositoryInterface $exceptions,
        private readonly ServiceRepositoryInterface         $services,
        private readonly HoldRepositoryInterface            $holds,
        private readonly SlotGenerator                      $slotGenerator,
        private readonly IntervalMath                       $math,
    ) {
    }

    /** @return SlotDto[] */
    public function getAvailableSlots(
        DateTimeImmutable $day,
        int               $serviceId,
        ProviderSetting   $settings
    ): array {
        $service = $this->services->find($serviceId);
        if (!$service) {
            return [];
        }

        $context = new AvailabilityContext(
            $service,
            $settings,
            $day,
            new DateTimeZone($settings->timezone),
            CarbonImmutable::now('UTC')
        );

        $open = $this->computeOpenIntervals($context);
        $open = $this->applyExceptions($open, $context);

        $open = $this->subtractBusyIntervals($open, $context);

        return $this->slotGenerator->generate($open, $context);
    }

    /**
     * @return TimeRange[]
     */
    private function computeOpenIntervals(AvailabilityContext $ctx): array
    {
        $rules = $this->workingHours->getByDayOfWeek($ctx->localDayStart->dayOfWeek);
        $intervals = [];

        foreach ($rules as $r) {
            $start = $ctx->atLocalTime($r->startTime);
            $end = $ctx->atLocalTime($r->endTime);
            if ($end <= $start) {
                continue;
            }
            $intervals[] = new TimeRange($start, $end);
        }

        return $this->math->merge($intervals);
    }

    /**
     * @param TimeRange[] $open
     *
     * @return TimeRange[]
     */
    private function applyExceptions(array $open, AvailabilityContext $ctx): array
    {
        $exceptions = $this->exceptions->getForDate($ctx->localDayStart);
        $adds = $subs = [];

        foreach ($exceptions as $ex) {
            $range = $ctx->buildExceptionRange($ex);
            if ($ex->type === 'open') {
                $adds[] = $range;
            } else {
                $subs[] = $range;
            }
        }

        if ($adds) {
            $open = $this->math->merge(array_merge($open, $adds));
        }
        if ($subs) {
            $open = $this->math->subtract($open, $subs);
        }

        return $open;
    }

    /**
     * @param TimeRange[] $open
     *
     * @return TimeRange[]
     */
    private function subtractBusyIntervals(array $open, AvailabilityContext $ctx): array
    {
        [$dayStartUtc, $dayEndUtc] = $ctx->dayUtcRange();

        $appointments = $this->appointments->findByDateRange($dayStartUtc, $dayEndUtc);

        $activeHolds = $this->holds->activeByRange($dayStartUtc, $dayEndUtc);
        $busyLocal = $ctx->busyLocalRanges(
            $appointments,
            $activeHolds
        );

        return $busyLocal ? $this->math->subtract($open, $busyLocal) : $open;
    }
}
