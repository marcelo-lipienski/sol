<?php

namespace App\Domain\Service\Services;

use App\Domain\Service\Repositories\ServiceRepositoryInterface;

class DeleteService
{
    public function __construct(private ServiceRepositoryInterface $serviceRepository)
    {
    }

    public function execute(int $id): void
    {
        $this->serviceRepository->delete($id);
    }
}