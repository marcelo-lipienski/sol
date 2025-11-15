<?php

namespace Tests\Unit\Domain\Customer\ValueObjects;

use App\Domain\Customer\ValueObjects\DocumentValueObject;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class DocumentValueObjectTest extends TestCase
{
    #[DataProvider('listOfInvalidDocuments')]
    public function test_invalid_document_throws_exception($document): void
    {
        $this->expectException(InvalidArgumentException::class);
        new DocumentValueObject($document);
    }

    public static function listOfInvalidDocuments(): array
    {
        return [
            // Invalid natural person documents
            ['111.111.111-11'],
            ['111111.111-11'],
            ['111.111111-11'],
            ['123.456.789-012'], // Too long
            ['123.456.789-0'], // Too short

            // Invalid organization documents
            ['11.111.111/1111-11'],
            ['11111.111/111111'],
            ['11.1111111111-11'],
            ['12.456.7891/0001-11'], // Too long
            ['12.456.789/0001-1'],   // Too  short

            // Invalid for both
            ['abcdef'],
            ['123.456.789.10-1234'],
            ['123456789191234'],
            ['0'],
            ['1234567891012345']
        ];
    }

    #[DataProvider('listOfValidDocuments')]
    public function test_valid_document($document): void
    {
        $documentValueObject = new DocumentValueObject($document);

        $expectedDocument = preg_replace('/[^0-9]/is', '', $document);

        $this->assertSame($expectedDocument, $documentValueObject->value());
    }

    public static function listOfValidDocuments(): array
    {
        return [
            // Valid natural person documents
            ['765.223.260-00'],
            ['765223.260-00'],
            ['76522326000'],

            // Valid organization documents
            ['65.173.918/0001-88'],
            ['65173.918/0001-88'],
            ['65.1739180001-88']
        ];
    }
}