<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            WorkingHourRuleSeeder::class,
            ProviderSettingSeeder::class,
            AppointmentSeeder::class,
            ExceptionWindowSeeder::class,
            HoldSeeder::class,
        ]);
    }
}
