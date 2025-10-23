<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;

class HoldSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('holds')->insert([
            [
                'service_id'      => 1,
                'starts_at_utc'   => CarbonImmutable::now('UTC')->addDay()->setTime(11, 0),
                'ends_at_utc'     => CarbonImmutable::now('UTC')->addDay()->setTime(11, 30),
                'expires_at_utc'  => CarbonImmutable::now('UTC')->addDay()->setTime(12, 0),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}
