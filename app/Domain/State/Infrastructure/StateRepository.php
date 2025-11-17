<?php

namespace App\Domain\State\Infrastructure;

use App\Domain\State\Entities\State;
use App\Domain\State\Repositories\StateRepositoryInterface;
use App\Models\State as EloquentState;

class StateRepository implements StateRepositoryInterface
{
    public function findById(int $id): State
    {
        $state = EloquentState::find($id);

        return new State($state->short_name, $state->long_name, $state->id);
    }
}