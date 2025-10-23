<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Entities\WorkingHourRule;
use App\Domain\Repositories\WorkingHourRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\EloquentWorkingHourRule;

final class EloquentWorkingHourRepository implements WorkingHourRepositoryInterface
{
    public function getByDayOfWeek(int $dayOfWeek): array
    {
        return EloquentWorkingHourRule::query()
            ->where('day_of_week', $dayOfWeek)
            ->get()
            ->map(fn ($model) => new WorkingHourRule(
                id: $model->id,
                dayOfWeek: $model->day_of_week,
                startTime: $model->start_time,
                endTime: $model->end_time,
            ))
            ->all();
    }
}
