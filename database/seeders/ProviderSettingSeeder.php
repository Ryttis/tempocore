<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderSettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('provider_settings')->insert([
            'slot_granularity'           => 15,
            'min_lead_time_minutes'      => 120,
            'max_booking_horizon_days'   => 90,
            'buffer_before_minutes'      => 5,
            'buffer_after_minutes'       => 5,
            'cancellation_cutoff_minutes'=> 360,
            'timezone'                   => 'Europe/Vilnius',
        ]);
    }
}
