<?php

namespace App\Domain\Installation\Repositories;

use App\Domain\Installation\Entities\Installation;

interface InstallationRepositoryInterface
{
    public function findById(int $id): Installation;
}