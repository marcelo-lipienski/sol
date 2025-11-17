<?php

namespace App\Domain\State\Entities;

class State
{
    public function __construct(
        public string $shortName,
        public string $longName,
        public int $id,
    ) {}
}