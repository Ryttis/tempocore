<?php

namespace App\Providers;

use App\Domain\Availability\IntervalMath;
use App\Domain\Entities\ProviderSetting;
use App\Domain\Repositories\{AppointmentRepositoryInterface,
    ExceptionWindowRepositoryInterface,
    ServiceRepositoryInterface,
    WorkingHourRepositoryInterface,
    ProviderSettingRepositoryInterface};
use App\Domain\Repositories\HoldRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\EloquentProviderSetting;
use App\Infrastructure\Persistence\Eloquent\Repositories\{EloquentAppointmentRepository,
    EloquentExceptionWindowRepository,
    EloquentServiceRepository,
    EloquentWorkingHourRepository,
    EloquentProviderSettingRepository};
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentHoldRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AppointmentRepositoryInterface::class, EloquentAppointmentRepository::class);
        $this->app->bind(WorkingHourRepositoryInterface::class, EloquentWorkingHourRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, EloquentServiceRepository::class);
        $this->app->bind(ExceptionWindowRepositoryInterface::class, EloquentExceptionWindowRepository::class);
        $this->app->bind(HoldRepositoryInterface::class, EloquentHoldRepository::class);
        $this->app->bind(ProviderSettingRepositoryInterface::class, EloquentProviderSettingRepository::class);

        $this->app->singleton(IntervalMath::class);
        $this->app->singleton(ProviderSetting::class, function () {
            $row = EloquentProviderSetting::query()->first();
            if (!$row) {
                return new ProviderSetting(
                    id: 0,
                    slotGranularity: 15,
                    minLeadTimeMinutes: 120,
                    maxBookingHorizonDays: 90,
                    bufferBeforeMinutes: 0,
                    bufferAfterMinutes: 0,
                    cancellationCutoffMinutes: 360,
                    timezone: config('app.timezone', 'UTC'),
                );
            }
            return new ProviderSetting(
                id: $row->id,
                slotGranularity: (int)$row->slot_granularity,
                minLeadTimeMinutes: (int)$row->min_lead_time_minutes,
                maxBookingHorizonDays: (int)$row->max_booking_horizon_days,
                bufferBeforeMinutes: (int)$row->buffer_before_minutes,
                bufferAfterMinutes: (int)$row->buffer_after_minutes,
                cancellationCutoffMinutes: (int)$row->cancellation_cutoff_minutes,
                timezone: (string)$row->timezone,
            );
        });
    }

    public function boot(): void {}
}
