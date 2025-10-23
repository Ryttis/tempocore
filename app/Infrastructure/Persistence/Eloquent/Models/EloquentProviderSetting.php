<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\EloquentProviderSettingFactory;

/**
 * Eloquent model for provider settings.
 *
 * @use HasFactory<EloquentProviderSettingFactory>
 */
class EloquentProviderSetting extends Model
{
    /** @use HasFactory<EloquentProviderSettingFactory> */
    use HasFactory;

    protected $table = 'provider_settings';

    protected $fillable = [
        'slot_granularity',
        'min_lead_time_minutes',
        'max_booking_horizon_days',
        'buffer_before_minutes',
        'buffer_after_minutes',
        'cancellation_cutoff_minutes',
        'timezone',
    ];

    /**
     * Create a new factory instance for this model.
     *
     * @return EloquentProviderSettingFactory
     */
    protected static function newFactory(): EloquentProviderSettingFactory
    {
        return EloquentProviderSettingFactory::new();
    }
}
