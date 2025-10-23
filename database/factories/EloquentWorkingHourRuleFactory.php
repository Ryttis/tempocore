<?php

namespace Database\Factories;

use App\Infrastructure\Persistence\Eloquent\Models\EloquentWorkingHourRule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EloquentWorkingHourRule>
 */
class EloquentWorkingHourRuleFactory extends Factory
{
    protected $model = EloquentWorkingHourRule::class;

    public function definition(): array
    {
        return [
            'day_of_week' => $this->faker->numberBetween(0, 6),
            'start_time'  => '09:00:00',
            'end_time'    => '17:00:00',
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
