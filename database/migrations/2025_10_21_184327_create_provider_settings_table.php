<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('provider_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('slot_granularity')->default(15);
            $table->unsignedSmallInteger('min_lead_time_minutes')->default(120);
            $table->unsignedSmallInteger('max_booking_horizon_days')->default(90);
            $table->unsignedSmallInteger('buffer_before_minutes')->default(0);
            $table->unsignedSmallInteger('buffer_after_minutes')->default(0);
            $table->unsignedSmallInteger('cancellation_cutoff_minutes')->default(360);
            $table->string('timezone')->default('Europe/Vilnius');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_settings');
    }
};
