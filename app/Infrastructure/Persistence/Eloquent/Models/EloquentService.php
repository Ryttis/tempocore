<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\EloquentServiceFactory;

/**
 * Eloquent model for services.
 *
 * @use HasFactory<EloquentServiceFactory>
 */
class EloquentService extends Model
{
    /** @use HasFactory<EloquentServiceFactory> */
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'name',
        'duration_minutes',
        'price',
        'color',
    ];

    /**
     * Create a new factory instance for this model.
     *
     * @return EloquentServiceFactory
     */
    protected static function newFactory(): EloquentServiceFactory
    {
        return EloquentServiceFactory::new();
    }
}
