<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Repositories\ServiceRepositoryInterface;
use App\Domain\Entities\Service;
use App\Infrastructure\Persistence\Eloquent\Models\EloquentService;

final class EloquentServiceRepository implements ServiceRepositoryInterface
{
    public function find(int $id): ?Service
    {
        $m = EloquentService::find($id);
        return $m ? new Service($m->id, $m->name, $m->duration_minutes, $m->price, $m->color) : null;
    }

    public function all(): array
    {
        return EloquentService::all()
            ->map(fn($m)=> new Service($m->id, $m->name, $m->duration_minutes, $m->price, $m->color))
            ->all();
    }
}

