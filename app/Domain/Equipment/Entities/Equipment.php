<?php

namespace App\Domain\Equipment\Entities;

class Equipment
{
    public function __construct(
        public string $name,
        public int $id,
    ) {}
}