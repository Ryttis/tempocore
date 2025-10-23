<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Database\Factories\EloquentWorkingHourRuleFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Eloquent model representing a provider's working hour rule.
 *
 * @use HasFactory<EloquentWorkingHourRuleFactory>
 */
class EloquentWorkingHourRule extends Model
{
    /** @use HasFactory<EloquentWorkingHourRuleFactory> */
    use HasFactory;

    protected $table = 'working_hour_rules';

    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
    ];

    public $timestamps = false;

    /**
     * Create a new factory instance for this model.
     *
     * @return EloquentWorkingHourRuleFactory
     */
    protected static function newFactory(): EloquentWorkingHourRuleFactory
    {
        return EloquentWorkingHourRuleFactory::new();
    }
}
