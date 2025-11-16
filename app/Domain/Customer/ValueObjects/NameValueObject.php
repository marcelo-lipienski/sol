<?php

namespace App\Domain\Customer\ValueObjects;

use InvalidArgumentException;

final class NameValueObject
{
    private readonly string $value;

    public function __construct(string $value) {
        $this->value = trim($value);

        $this->ensureIsValid();
    }

    private function ensureIsValid()
    {
        if ($this->isInvalidName()) {
            throw new InvalidArgumentException('Name is invalid');
        }
    }

    private function isInvalidName(): bool
    {
        if (strlen($this->value) <= 2) {
            return true;
        }

        if (preg_match('/[^\w\s]/', $this->value)) {
            return true;
        }

        return false;
    }

    public function value(): string
    {
        return $this->value;
    }
}