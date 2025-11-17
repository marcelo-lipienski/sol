<?php

namespace App\Domain\State\Repositories;

use App\Domain\State\Entities\State;

interface StateRepositoryInterface
{
    public function findById(int $id): State;
}