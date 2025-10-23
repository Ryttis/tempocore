<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\WorkingHourRule;

interface WorkingHourRepositoryInterface
{
    /** @return WorkingHourRule[] */
    public function getByDayOfWeek(int $dayOfWeek): array;
}
