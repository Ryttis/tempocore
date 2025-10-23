<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkingHourRuleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 5) as $day) {
            DB::table('working_hour_rules')->insert([
                'day_of_week' => $day,
                'start_time'  => '09:00:00',
                'end_time'    => '17:00:00',
            ]);
        }
    }
}
