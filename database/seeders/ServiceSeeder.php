<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('services')->insert([
            ['name' => 'Consultation', 'duration_minutes' => 30, 'price' => 50.00, 'color' => '#3490dc'],
            ['name' => 'Implant Check', 'duration_minutes' => 45, 'price' => 80.00, 'color' => '#38c172'],
        ]);
    }
}
