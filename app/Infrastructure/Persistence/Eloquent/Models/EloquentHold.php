<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentHold extends Model
{
    protected $table = 'holds';
    protected $fillable = ['service_id','starts_at_utc','ends_at_utc','expires_at_utc'];
    protected $casts = [
        'starts_at_utc' => 'datetime',
        'ends_at_utc'   => 'datetime',
        'expires_at_utc'=> 'datetime',
    ];
}

