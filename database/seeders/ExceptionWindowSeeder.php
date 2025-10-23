<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;

class ExceptionWindowSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('exception_windows')->insert([
            [
                'date'       => CarbonImmutable::now('Europe/Vilnius')->addDays(2)->format('Y-m-d'),
                'start_time' => '12:00:00',
                'end_time'   => '13:00:00',
                'type'       => 'closed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
