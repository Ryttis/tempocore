<?php

namespace App\Interfaces\Http\Controllers;

use App\Domain\Repositories\ServiceRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ServiceController
{
    public function __construct(private ServiceRepositoryInterface $services) {}

    public function index(): JsonResponse
    {
        return response()->json($this->services->all());
    }
}
