<?php

namespace App\Domain\Installation\Infrastructure;

use App\Domain\Installation\Entities\Installation;
use App\Domain\Installation\Repositories\InstallationRepositoryInterface;
use App\Models\Installation as EloquentInstallation;

class InstallationRepository implements InstallationRepositoryInterface
{
    public function findById(int $id): Installation
    {
        $installation = EloquentInstallation::find($id);

        return new Installation($installation->name, $installation->id);
    }
}