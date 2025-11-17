<?php

namespace App\Domain\Installation\Entities;

class Installation
{
    public function __construct(
        public string $name,
        public int $id,
    ) {}
}