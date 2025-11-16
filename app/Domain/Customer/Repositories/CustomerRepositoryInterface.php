<?php

namespace App\Domain\Customer\Repositories;

use App\Domain\Customer\Entities\Customer;
use App\Domain\Customer\ValueObjects\DocumentValueObject;

interface CustomerRepositoryInterface
{
    /**
     * @return array<\App\Domain\Customer\Entities\Customer>
     */
    public function fetchAll(): array;
    public function findByDocument(DocumentValueObject $documentValueObject): Customer;
    public function save(Customer $customer): Customer;
    public function delete(DocumentValueObject $documentValueObject): void;
}