<?php

namespace Tests\Unit\Domain\Customer\ValueObjects;

use App\Domain\Customer\ValueObjects\PhoneNumberValueObject;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class PhoneNumberValueObjectTest extends TestCase
{
    #[DataProvider('listOfInvalidPhoneNumbers')]
    public function test_invalid_document_throws_exception($phoneNumber): void
    {
        $this->expectException(InvalidArgumentException::class);
        new PhoneNumberValueObject($phoneNumber);
    }

    public static function listOfInvalidPhoneNumbers(): array
    {
        return [
            // Invalid phone numbers
            ['1'], // Too short
            ['12'], // Too short
            ['190'], // Too short
        ];
    }

    #[DataProvider('listOfValidPhoneNumbers')]
    public function test_valid_name($phoneNumber): void
    {
        $phoneNumberValueObject = new PhoneNumberValueObject($phoneNumber);

        $expectedPhoneNumber = trim(preg_replace('/[^\d]/', '', $phoneNumber));

        $this->assertSame($expectedPhoneNumber, $phoneNumberValueObject->value());
    }

    public static function listOfValidPhoneNumbers(): array
    {
        return [
            // Valid numbers
            ['1234'],
            ['  123 4 '],
            ['+55 21 123456789']
        ];
    }
}