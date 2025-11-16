<?php

namespace App\Domain\Customer\ValueObjects;

use InvalidArgumentException;

final class PhoneNumberValueObject
{
    private readonly string $value;

    public function __construct(string $value) {
        $this->value = trim(preg_replace('/[^\d]/', '', $value));

        $this->ensureIsValid();
    }

    private function ensureIsValid()
    {
        if ($this->isInvalidPhoneNumber()) {
            throw new InvalidArgumentException('Phone number is invalid');
        }
    }

    private function isInvalidPhoneNumber(): bool
    {
        if (strlen($this->value) < 4) {
            return true;
        }

        return false;
    }

    public function value(): string
    {
        return $this->value;
    }
}