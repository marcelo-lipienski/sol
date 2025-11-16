<?php

namespace App\Domain\Service\Repositories;

use App\Domain\Service\Entities\Service;

interface ServiceRepositoryInterface
{
    public function save(Service $service): Service;
}