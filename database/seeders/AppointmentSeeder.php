<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('appointments')->insert([
            [
                'service_id'      => 1,
                'client_name'     => 'John Doe',
                'client_email'    => 'john@example.com',
                'starts_at_utc'   => CarbonImmutable::now('UTC')->addDay()->setTime(9, 0),
                'ends_at_utc'     => CarbonImmutable::now('UTC')->addDay()->setTime(9, 30),
                'status'          => 'confirmed',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}
