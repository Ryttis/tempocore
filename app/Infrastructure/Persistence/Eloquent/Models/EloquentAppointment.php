<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentAppointment extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'service_id',
        'client_email',
        'starts_at_utc',
        'ends_at_utc',
        'status',
    ];

    protected $casts = [
        'starts_at_utc' => 'datetime',
        'ends_at_utc'   => 'datetime',
    ];
}

