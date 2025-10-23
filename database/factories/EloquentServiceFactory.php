<?php

namespace Database\Factories;

use App\Infrastructure\Persistence\Eloquent\Models\EloquentService;
use Illuminate\Database\Eloquent\Factories\Factory;

class EloquentServiceFactory extends Factory
{
    protected $model = EloquentService::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'duration_minutes' => $this->faker->numberBetween(15, 90),
            'price' => $this->faker->randomFloat(2, 10, 200),
            'color' => $this->faker->safeColorName(),
        ];
    }
}
