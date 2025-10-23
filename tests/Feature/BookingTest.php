<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Infrastructure\Persistence\Eloquent\Models\EloquentService;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_books_a_slot_successfully(): void
    {
        $service = EloquentService::create([
            'name' => 'Haircut',
            'duration_minutes' => 30,
        ]);

        $payload = [
            'service_id'   => $service->id,
            'starts_at'    => now()->addHour()->toIso8601String(),
            'client_email' => 'client@example.com',
        ];

        $response = $this->postJson('/api/appointments', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseCount('appointments', 1);
    }

    #[Test]
    public function it_prevents_double_booking(): void
    {
        $service = EloquentService::create([
            'name' => 'Massage',
            'duration_minutes' => 60,
        ]);

        $startsAt = now()->addHour()->toIso8601String();

        $this->postJson('/api/appointments', [
            'service_id'   => $service->id,
            'starts_at'    => $startsAt,
            'client_email' => 'first@example.com',
        ])->assertStatus(201);

        $response = $this->postJson('/api/appointments', [
            'service_id'   => $service->id,
            'starts_at'    => $startsAt,
            'client_email' => 'second@example.com',
        ]);

        $response->assertStatus(500); // RuntimeException expected
        $this->assertDatabaseCount('appointments', 1);
    }
}
