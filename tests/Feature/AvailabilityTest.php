<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Carbon\Carbon;
use App\Infrastructure\Persistence\Eloquent\Models\{
    EloquentService,
    EloquentWorkingHourRule,
    EloquentProviderSetting
};
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvailabilityTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_available_slots(): void
    {
        Carbon::setTestNow('2025-10-20 08:00:00');

        $service = EloquentService::factory()->create([
            'duration_minutes' => 30,
        ]);

        EloquentWorkingHourRule::factory()->create([
            'day_of_week' => 6, // Saturday
            'start_time'  => '09:00:00',
            'end_time'    => '17:00:00',
        ]);

        EloquentProviderSetting::factory()->create([
            'slot_granularity' => 30,
            'min_lead_time_minutes' => 60,
            'max_booking_horizon_days' => 90,
            'buffer_before_minutes' => 0,
            'buffer_after_minutes'  => 0,
            'timezone' => 'Europe/Vilnius',
        ]);

        $response = $this->getJson("/api/availability?date=2025-10-25&service_id={$service->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['startUtc', 'endUtc', 'startLocal', 'endLocal']
                ]
            ]);
    }
}
