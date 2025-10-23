<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Service;

interface ServiceRepositoryInterface
{
    public function find(int $id): ?Service;
    /** @return Service[] */
    public function all(): array;
}
