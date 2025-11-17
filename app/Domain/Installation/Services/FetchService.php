<?php

namespace App\Domain\Installation\Services;

use App\Domain\Installation\Entities\Installation;
use App\Domain\Installation\Repositories\InstallationRepositoryInterface;

class FetchService
{
    public function __construct(private InstallationRepositoryInterface $installationRepository)
    {
    }

    public function execute(int $id): Installation
    {
        return $this->installationRepository->findById($id);
    }
}