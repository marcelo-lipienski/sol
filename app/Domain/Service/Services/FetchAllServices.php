<?php

namespace App\Domain\Service\Services;

use App\Domain\Service\Repositories\ServiceRepositoryInterface;

class FetchAllServices
{
    public function __construct(private ServiceRepositoryInterface $serviceRepository)
    {
    }

    /**
     * @return array<\App\Domain\Service\Entities\Service>
     */
    public function execute(): array
    {
        return $this->serviceRepository->fetchAll();
    }
}