<?php

namespace Database\Factories;

use App\Infrastructure\Persistence\Eloquent\Models\EloquentProviderSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class EloquentProviderSettingFactory extends Factory
{
    protected $model = EloquentProviderSetting::class;

    public function definition(): array
    {
        return [
            'slot_granularity' => 15,
            'min_lead_time_minutes' => 120,
            'max_booking_horizon_days' => 90,
            'buffer_before_minutes' => 0,
            'buffer_after_minutes' => 0,
            'cancellation_cutoff_minutes' => 360,
            'timezone' => 'Europe/Vilnius',
        ];
    }
}
