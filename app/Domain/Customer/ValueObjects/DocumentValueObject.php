<?php

namespace App\Domain\Customer\ValueObjects;

use InvalidArgumentException;

final class DocumentValueObject
{
    private readonly string $value;

    public function __construct(string $value) {
        $this->value = preg_replace('/[^0-9]/is', '', $value);
        $this->ensureIsValid();
    }

    private function ensureIsValid()
    {
        if ($this->isInvalidDocument()) {
            throw new InvalidArgumentException('Document is invalid');
        }
    }

    private function isInvalidDocument(): bool
    {
        if (
            $this->isInvalidNaturalPersonDocument()
            && $this->isInvalidOrganizationDocument()
        ) {
            return true;
        }

        return false;
    }

    private function isInvalidNaturalPersonDocument(): bool
    {
        // Document must have exactly 11 digits
        if (strlen($this->value) != 11) {
            return true;
        }

        // Document can't have all digits repeated (e.g. 111.111.111-11)
        if (preg_match('/(\d)\1{10}/', $this->value)) {
            return true;
        }

        $documentDigits = substr($this->value, 0, 9);

        $firstVerificationDigit = intval($this->value[9]);
        $secondVerificationDigit = intval($this->value[10]);

        // --- 3. First Verification Digit (DV1) Calculation ---
        $sumOfProductsForFirstVerificationDigit = 0;
        
        // The multiplier for the first digit starts at 10 and decreases by 1 for each position.
        // Loop through the first 9 digits.
        for ($index = 0; $index < 9; $index++) {
            $digit = intval($documentDigits[$index]);
            $multiplier = 10 - $index;

            $sumOfProductsForFirstVerificationDigit += $digit * $multiplier;
        }

        // The remainder of the sum divided by 11.
        $firstVerificationDigitRemainder = $sumOfProductsForFirstVerificationDigit % 11;
        
        // Calculate the expected first verification digit.
        // If the remainder is less than 2, the DV is 0. Otherwise, the DV is 11 minus the remainder.
        $expectedFirstVerificationDigit = ($firstVerificationDigitRemainder < 2) ? 0 : (11 - $firstVerificationDigitRemainder);

        // Check if the calculated DV1 matches the provided DV1.
        if ($expectedFirstVerificationDigit !== $firstVerificationDigit) {
            return true;
        }

        // --- 4. Second Verification Digit (DV2) Calculation ---
        // Now, we include the first calculated DV (the 10th digit) in the calculation.
        $documentDigitsWithFirstExpectedVerificationDigit = $documentDigits . $expectedFirstVerificationDigit;
        
        $sumOfProductsForSecondVerificationDigit = 0;

        // The multiplier for the second DV starts at 11 and decreases by 1 for each position.
        // Loop through the first 10 digits (base + DV1).
        for ($index = 0; $index < 10; $index++) {
            $digit = intval($documentDigitsWithFirstExpectedVerificationDigit[$index]);
            $multiplier = 11 - $index;

            $sumOfProductsForSecondVerificationDigit += $digit * $multiplier;
        }
        
        // The remainder of the sum divided by 11.
        $secondVerificationDigitRemainder = $sumOfProductsForSecondVerificationDigit % 11;

        // Calculate the expected second verification digit.
        // If the remainder is less than 2, the DV is 0. Otherwise, the DV is 11 minus the remainder.
        $expectedSecondVerificationDigit = ($secondVerificationDigitRemainder < 2) ? 0 : (11 - $secondVerificationDigitRemainder);

        // 5. Final Verification
        // Check if the calculated DV2 matches the provided DV2.
        return $expectedSecondVerificationDigit !== $secondVerificationDigit;
    }

    private function isInvalidOrganizationDocument(): bool
    {
        // Document must have exactly 14 digits
        if (strlen($this->value) != 14) {
            return true;
        }

        // Document can't have all digits repeated (e.g. 11.111.111/1111-11).
        if (preg_match('/(\d)\1{13}/', $this->value)) {
            return true;
        }

        // Separate the first 12 digits (base number) from the two verification digits (DVs).
        $documentDigits = substr($this->value, 0, 12);

        $firstVerificationDigit = intval($this->value[12]);
        $secondVerificationDigit = intval($this->value[13]);
        
        // --- 3. First Verification Digit (DV1) Calculation ---
        // The multiplier sequence for the first 12 digits is: 5,4,3,2,9,8,7,6,5,4,3,2
        $firstVerificationDigitWeights = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        
        $sumOfProductsForFirstVerificationDigit = 0;
        
        // Loop through the first 12 base digits.
        for ($index = 0; $index < 12; $index++) {
            $digit = intval($documentDigits[$index]);
            $weight = $firstVerificationDigitWeights[$index];

            $sumOfProductsForFirstVerificationDigit += $digit * $weight;
        }

        // Calculate the remainder of the sum divided by 11.
        $firstVerificationDigitRemainder = $sumOfProductsForFirstVerificationDigit % 11;
        
        // Calculate the expected first verification digit.
        // If the remainder is less than 2, the DV is 0. Otherwise, the DV is 11 minus the remainder.
        $expectedFirstVerificationDigit = ($firstVerificationDigitRemainder < 2) ? 0 : (11 - $firstVerificationDigitRemainder);

        // Check if the calculated DV1 matches the provided DV1.
        if ($expectedFirstVerificationDigit !== $firstVerificationDigit) {
            return false;
        }

        // --- 4. Second Verification Digit (DV2) Calculation ---
        // Now, we use the first 13 digits (base + calculated DV1).
        $documentDigitsWithFirstExpectedVerificationDigit = $documentDigits . $firstVerificationDigit;

        $sumOfProductsForSecondVerificationDigit = 0;
        
        // The multiplier sequence for the first 13 digits is: 6,5,4,3,2,9,8,7,6,5,4,3,2
        $secondVerificationDigitWeights = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        // Loop through the first 13 digits.
        for ($index = 0; $index < 13; $index++) {
            $digit = intval($documentDigitsWithFirstExpectedVerificationDigit[$index]);
            $weight = $secondVerificationDigitWeights[$index];

            $sumOfProductsForSecondVerificationDigit += $digit * $weight;
        }
        
        // Calculate the remainder of the sum divided by 11.
        $secondVerificationDigitRemainder = $sumOfProductsForSecondVerificationDigit % 11;

        // Calculate the expected second verification digit.
        // If the remainder is less than 2, the DV is 0. Otherwise, the DV is 11 minus the remainder.
        $expectedSecondVerificationDigit = ($secondVerificationDigitRemainder < 2) ? 0 : (11 - $secondVerificationDigitRemainder);

        // 5. Final Verification
        // Check if the calculated DV2 matches the provided DV2.
        return $expectedSecondVerificationDigit !== $secondVerificationDigit;
    }

    public function value(): string
    {
        return $this->value;
    }
}