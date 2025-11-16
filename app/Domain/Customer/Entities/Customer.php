<?php

namespace App\Domain\Customer\Entities;

use App\Domain\Customer\ValueObjects\DocumentValueObject;
use App\Domain\Customer\ValueObjects\EmailValueObject;
use App\Domain\Customer\ValueObjects\NameValueObject;
use App\Domain\Customer\ValueObjects\PhoneNumberValueObject;

class Customer
{
    public function __construct(
        public EmailValueObject $email,
        public NameValueObject $name,
        public PhoneNumberValueObject $phoneNumber,
        public DocumentValueObject $document,
        public ?int $id,
    ) {}
}