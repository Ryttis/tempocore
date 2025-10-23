<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Repositories\ProviderSettingRepositoryInterface;
use App\Domain\Entities\ProviderSetting;
use App\Infrastructure\Persistence\Eloquent\Models\EloquentProviderSetting;

final class EloquentProviderSettingRepository implements ProviderSettingRepositoryInterface
{
    public function first(): ProviderSetting
    {
        $eloquentSetting = EloquentProviderSetting::firstOrFail();

        return $this->mapToEntity($eloquentSetting);
    }

    public function getCurrent(): ?ProviderSetting
    {
        $eloquentSetting = EloquentProviderSetting::first();

        return $eloquentSetting
            ? $this->mapToEntity($eloquentSetting)
            : null;
    }

    private function mapToEntity(EloquentProviderSetting $eloquentSetting): ProviderSetting
    {
        return new ProviderSetting(
            id: $eloquentSetting->id,
            slotGranularity: $eloquentSetting->slot_granularity,
            minLeadTimeMinutes: $eloquentSetting->min_lead_time_minutes,
            maxBookingHorizonDays: $eloquentSetting->max_booking_horizon_days,
            bufferBeforeMinutes: $eloquentSetting->buffer_before_minutes,
            bufferAfterMinutes: $eloquentSetting->buffer_after_minutes,
            cancellationCutoffMinutes: $eloquentSetting->cancellation_cutoff_minutes,
            timezone: $eloquentSetting->timezone
        );
    }
}
