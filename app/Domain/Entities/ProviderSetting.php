<?php

namespace App\Domain\Entities;

namespace App\Domain\Entities;

final class ProviderSetting
{
    public function __construct(
        public int $id,
        public int $slotGranularity,
        public int $minLeadTimeMinutes,
        public int $maxBookingHorizonDays,
        public int $bufferBeforeMinutes,
        public int $bufferAfterMinutes,
        public int $cancellationCutoffMinutes,
        public string $timezone,
    ) {
    }
}
