<?php

namespace App\Domain\Service\Repositories;

use App\Domain\Service\Entities\Service;

interface ServiceRepositoryInterface
{
    /**
     * @return array<\App\Domain\Service\Entities\Service>
     */
    public function fetchAll(): array;
    public function findById(int $id): Service;
    public function save(Service $service): Service;
}