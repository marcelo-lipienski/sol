<?php

namespace Tests\Unit\Domain\Customer\ValueObjects;

use App\Domain\Customer\ValueObjects\NameValueObject;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class NameValueObjectTest extends TestCase
{
    #[DataProvider('listOfInvalidNames')]
    public function test_invalid_document_throws_exception($name): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NameValueObject($name);
    }

    public static function listOfInvalidNames(): array
    {
        return [
            // Invalid names
            ['A'], // Too short
            ['Ab'], // Too short
            ['Inv4l!d'], // Invalid characters
        ];
    }

    #[DataProvider('listOfValidNames')]
    public function test_valid_name($name): void
    {
        $nameValueObject = new NameValueObject($name);

        $expectedName = trim(preg_replace('/[^\w\s]/', '', $name));

        $this->assertSame($expectedName, $nameValueObject->value());
    }

    public static function listOfValidNames(): array
    {
        return [
            // Valid names
            ['Aba'],
            ['Fulano'],
            ['Fulano deTal'],
            ['Fulano de Tal'],
            ['    Fulano de Tal     ']
        ];
    }
}