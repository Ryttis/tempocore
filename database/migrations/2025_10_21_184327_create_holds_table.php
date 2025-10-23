<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->timestampTz('starts_at_utc');
            $table->timestampTz('ends_at_utc');
            $table->timestampTz('expires_at_utc');
            $table->timestamps();

            $table->index(['service_id', 'starts_at_utc']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holds');
    }
};
