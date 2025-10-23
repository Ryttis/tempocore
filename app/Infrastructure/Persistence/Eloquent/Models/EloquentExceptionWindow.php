<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentExceptionWindow extends Model
{
    protected $table = 'exception_windows';

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'type',
    ];

    public $timestamps = false;
}
