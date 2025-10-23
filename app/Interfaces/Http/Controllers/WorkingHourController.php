<?php

namespace App\Interfaces\Http\Controllers;

use App\Infrastructure\Persistence\Eloquent\Models\EloquentWorkingHourRule;
use App\Interfaces\Http\Requests\CreateWorkingHourRuleRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class WorkingHourController
{
    /**
     * @return Collection<int, EloquentWorkingHourRule>
     */
    public function index(): Collection
    {
        return EloquentWorkingHourRule::orderBy('day_of_week')->get();
    }

    public function store(CreateWorkingHourRuleRequest $request): Model
    {
        return EloquentWorkingHourRule::create($request->validated());
    }
}
