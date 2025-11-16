<?php

namespace Tests\Unit\Domain\Customer\ValueObjects;

use App\Domain\Customer\ValueObjects\EmailValueObject;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class EmailValueObjectTest extends TestCase
{
    #[DataProvider('listOfInvalidEmails')]
    public function test_invalid_document_throws_exception($email): void
    {
        $this->markTestSkipped('Implement e-mail validation in EmailValueObject');

        $this->expectException(InvalidArgumentException::class);
        new EmailValueObject($email);
    }

    public static function listOfInvalidEmails(): array
    {
        return [
            // Invalid names
            ['invalid-email'],            // Missing @ and TLD
            ['user@.com'],                // Invalid domain structure
            ['user@domain..com'],         // Double periods
            ['user@domain'],              // Missing TLD
            ['user@domain.toolongtld'],   // TLD too long
            ['user@domain!invalid.com'],  // Invalid character (!)
        ];
    }

    #[DataProvider('listOfValidEmails')]
    public function test_valid_name($email): void
    {
        $emailValueObject = new EmailValueObject($email);

        $this->assertSame($email, $emailValueObject->value());
    }

    public static function listOfValidEmails(): array
    {
        return [
            // Valid names
            ['test@example.com'],
            ['user.name+tag@subdomain.co.uk'],
            ['12345@domain.net'],
            ['a-b_c%d@e-f.g'],
        ];
    }
}