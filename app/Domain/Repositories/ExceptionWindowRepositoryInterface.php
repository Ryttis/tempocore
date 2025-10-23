<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\ExceptionWindow;
use DateTimeImmutable;

interface ExceptionWindowRepositoryInterface
{
    /** @return ExceptionWindow[] */
    public function getForDate(DateTimeImmutable $date): array;
}
