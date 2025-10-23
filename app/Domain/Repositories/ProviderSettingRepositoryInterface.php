<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\ProviderSetting;

interface ProviderSettingRepositoryInterface
{
    public function first(): ProviderSetting;
    public function getCurrent(): ?ProviderSetting;
}
