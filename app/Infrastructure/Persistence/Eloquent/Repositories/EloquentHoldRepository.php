<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Repositories\HoldRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\EloquentHold;
use Carbon\CarbonInterface;
use DateTimeImmutable;
use DateTimeZone;

final class EloquentHoldRepository implements HoldRepositoryInterface
{
    public function activeByRange(DateTimeImmutable $startUtc, DateTimeImmutable $endUtc): array
    {
        $now = new DateTimeImmutable('now', new DateTimeZone('UTC'));

        return EloquentHold::where('expires_at_utc', '>', $now)
            ->where('starts_at_utc', '<', $endUtc)
            ->where('ends_at_utc', '>', $startUtc)
            ->get(['starts_at_utc', 'ends_at_utc'])
            ->map(fn ($m) => [
                $this->toImmutable($m->starts_at_utc),
                $this->toImmutable($m->ends_at_utc),
            ])
            ->all();
    }

    private function toImmutable(mixed $value): DateTimeImmutable
    {
        if ($value instanceof CarbonInterface) {
            return new DateTimeImmutable($value->format('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        }

        if (is_string($value)) {
            return new DateTimeImmutable($value, new DateTimeZone('UTC'));
        }

        return new DateTimeImmutable('now', new DateTimeZone('UTC'));
    }
}
