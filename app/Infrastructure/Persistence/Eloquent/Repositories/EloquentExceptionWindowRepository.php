<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Entities\ExceptionWindow;
use App\Domain\Repositories\ExceptionWindowRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\EloquentExceptionWindow;
use DateTimeImmutable;

final class EloquentExceptionWindowRepository implements ExceptionWindowRepositoryInterface
{
    public function getForDate(DateTimeImmutable $date): array
    {
        return EloquentExceptionWindow::query()
            ->whereDate('date', $date->format('Y-m-d'))
            ->get()
            ->map(fn ($model) => new ExceptionWindow(
                id: $model->id,
                date: new DateTimeImmutable($model->date),
                startTime: $model->start_time,
                endTime: $model->end_time,
                type: $model->type,
            ))
            ->all();
    }
}
