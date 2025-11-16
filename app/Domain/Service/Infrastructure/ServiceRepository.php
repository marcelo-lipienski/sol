<?php

namespace App\Domain\Service\Infrastructure;

use App\Models\Service as EloquentService;
use App\Domain\Service\Entities\Service;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function save(Service $service): Service
    {
        $storedService = EloquentService::updateOrCreate(
            ['id' => $service->id],
            ['customer_id' => $service->customer->id]
        );

        return new Service($service->customer, $storedService->id);
    }
}