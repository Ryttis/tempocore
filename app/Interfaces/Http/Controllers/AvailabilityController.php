<?php

namespace App\Interfaces\Http\Controllers;

use App\Domain\Repositories\ProviderSettingRepositoryInterface;
use App\Services\AvailabilityService;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class AvailabilityController
{
    public function __construct(
        private readonly AvailabilityService $availability,
        private readonly ProviderSettingRepositoryInterface $settings,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $date = new DateTimeImmutable($request->query('date', 'now'));
        $serviceId = (int) $request->query('service_id');

        $providerSetting = $this->settings->getCurrent();

        if (!$serviceId || !$providerSetting) {
            return response()->json(['error' => 'Missing service_id or settings'], 422);
        }

        $slots = $this->availability->getAvailableSlots(
            $date,
            $serviceId,
            $providerSetting
        );

        return response()->json(['data' => $slots], 200);
    }
}
