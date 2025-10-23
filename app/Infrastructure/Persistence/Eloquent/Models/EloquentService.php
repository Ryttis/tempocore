<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Database\Factories\EloquentServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
