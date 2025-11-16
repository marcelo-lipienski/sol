<?php

namespace App\Domain\Customer\ValueObjects;

use InvalidArgumentException;

final class EmailValueObject
{
    private readonly string $value;

    public function __construct(string $value) {
        $this->value = trim($value);

        $this->ensureIsValid();
    }

    private function ensureIsValid()
    {
        if ($this->isInvalidEmail()) {
            throw new InvalidArgumentException('E-mail is invalid');
        }
    }

    private function isInvalidEmail(): bool
    {
        // Implement e-mail validation
        return false;
    }

    public function value(): string
    {
        return $this->value;
    }
}