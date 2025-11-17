<?php

namespace App\Domain\Service\Services;

use App\Domain\Service\Entities\Service;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;

class FetchService
{
    public function __construct(private ServiceRepositoryInterface $serviceRepository)
    {
    }

    public function execute(int $id): Service
    {
        return $this->serviceRepository->findById($id);
    }
}